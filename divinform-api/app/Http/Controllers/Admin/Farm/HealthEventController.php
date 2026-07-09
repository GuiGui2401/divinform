<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Http\Controllers\Controller;
use App\Http\Resources\HealthEventResource;
use App\Models\FarmAnimal;
use App\Models\FarmBatch;
use App\Models\HealthEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthEventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = HealthEvent::with(['batch', 'animal', 'user'])
            ->orderByDesc('occurred_on')
            ->orderByDesc('id');

        if ($request->filled('farm_batch_id'))  $query->where('farm_batch_id', $request->farm_batch_id);
        if ($request->filled('farm_animal_id')) $query->where('farm_animal_id', $request->farm_animal_id);
        if ($request->filled('type'))           $query->type($request->type);
        if ($request->boolean('due'))           $query->dueBy(now()->addDays(14)->toDateString());

        $perPage = min((int) $request->get('per_page', 50), 200);
        $events  = $query->paginate($perPage);

        return response()->json([
            'data'         => HealthEventResource::collection($events->items()),
            'total'        => $events->total(),
            'current_page' => $events->currentPage(),
            'last_page'    => $events->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'farm_batch_id'    => 'nullable|exists:farm_batches,id',
            'farm_animal_id'   => 'nullable|exists:farm_animals,id',
            'type'             => 'required|in:' . implode(',', HealthEvent::TYPES),
            'label'            => 'required|string|max:150',
            'medicine'         => 'nullable|string|max:120',
            'dose'             => 'nullable|string|max:60',
            'quantity'         => 'nullable|integer|min:1',
            'occurred_on'      => 'required|date',
            'next_due_on'      => 'nullable|date|after_or_equal:occurred_on',
            'withdrawal_until' => 'nullable|date|after_or_equal:occurred_on',
            'cost'             => 'nullable|integer|min:0',
            'note'             => 'nullable|string',
        ]);

        if (empty($data['farm_batch_id']) && empty($data['farm_animal_id'])) {
            return response()->json([
                'message' => 'Indiquez la bande ou l\'animal concerné.',
                'errors'  => ['farm_batch_id' => ['Bande ou animal requis.']],
            ], 422);
        }

        if ($data['type'] === 'mortalite') {
            if (! empty($data['farm_batch_id']) && empty($data['quantity'])) {
                return response()->json([
                    'message' => 'Indiquez le nombre d\'animaux morts.',
                    'errors'  => ['quantity' => ['Nombre requis pour une mortalité de bande.']],
                ], 422);
            }

            if (! empty($data['farm_batch_id'])) {
                $batch = FarmBatch::findOrFail($data['farm_batch_id']);
                $dejaMorts = (int) $batch->healthEvents()->where('type', 'mortalite')->sum('quantity');

                if ($dejaMorts + $data['quantity'] > $batch->initial_qty) {
                    $restant = $batch->initial_qty - $dejaMorts;
                    return response()->json([
                        'message' => "Impossible : la bande {$batch->code} ne compte plus que {$restant} animal(aux) vivant(s).",
                        'errors'  => ['quantity' => ['Mortalité supérieure à l\'effectif vivant.']],
                    ], 422);
                }
            }
        }

        $event = DB::transaction(function () use ($data, $request) {
            $event = HealthEvent::create($data + ['user_id' => $request->user()?->id]);

            $this->applySideEffects($event);

            return $event;
        });

        return response()->json([
            'message' => 'Événement enregistré.',
            'data'    => new HealthEventResource($event->load(['batch', 'animal'])),
        ], 201);
    }

    public function destroy(HealthEvent $healthEvent): JsonResponse
    {
        DB::transaction(function () use ($healthEvent) {
            $batch  = $healthEvent->batch;
            $animal = $healthEvent->animal;
            $wasMortality = $healthEvent->type === 'mortalite';

            $healthEvent->delete();

            // L'effectif étant dérivé des mortalités, il se restaure seul.
            if ($wasMortality && $batch) {
                $batch->recomputeHeadcount();
            }
            if ($wasMortality && $animal && $animal->status === 'mort') {
                $animal->update(['status' => 'actif']);
            }
        });

        return response()->json(['message' => 'Événement supprimé, effectif recalculé.']);
    }

    /** Une mortalité décrémente la bande, ou fait passer l'animal en « mort ». */
    private function applySideEffects(HealthEvent $event): void
    {
        if ($event->type !== 'mortalite') {
            return;
        }

        if ($event->farm_batch_id) {
            FarmBatch::findOrFail($event->farm_batch_id)->recomputeHeadcount();
        }

        if ($event->farm_animal_id) {
            FarmAnimal::whereKey($event->farm_animal_id)->update(['status' => 'mort']);
        }
    }
}
