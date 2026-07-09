<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedItemResource;
use App\Models\FarmAnimal;
use App\Models\FarmBatch;
use App\Models\FarmUnit;
use App\Models\FeedItem;
use App\Models\HealthEvent;
use Illuminate\Http\JsonResponse;

class FarmDashboardController extends Controller
{
    /**
     * GET /api/admin/farm/dashboard
     *
     * Volontairement non caché : le personnel d'élevage saisit et doit voir
     * l'effet de sa saisie immédiatement.
     */
    public function index(): JsonResponse
    {
        $horizon = now()->addDays(14)->toDateString();

        return response()->json(['data' => [
            'units_count'    => FarmUnit::active()->count(),
            'batches_open'   => FarmBatch::open()->count(),
            'headcount'      => (int) FarmBatch::open()->sum('current_qty')
                                + FarmAnimal::alive()->count(),
            'animals_alive'  => FarmAnimal::alive()->count(),

            // Alertes : ce que le gestionnaire doit traiter aujourd'hui
            'low_stock'      => FeedItemResource::collection(
                FeedItem::active()->lowStock()->orderBy('name')->get()
            ),
            'vaccines_due'   => HealthEvent::with(['batch', 'animal'])
                ->dueBy($horizon)
                ->orderBy('next_due_on')
                ->limit(10)
                ->get()
                ->map(fn ($e) => [
                    'id'          => $e->id,
                    'label'       => $e->label,
                    'next_due_on' => $e->next_due_on?->toDateString(),
                    'target'      => $e->batch?->code ?? $e->animal?->tag,
                ]),

            // Mortalité sur les bandes ouvertes
            'mortality' => FarmBatch::open()->get()->map(fn ($b) => [
                'code' => $b->code,
                'rate' => $b->mortality_rate,
            ])->sortByDesc('rate')->take(5)->values(),

            'feed_items_count' => FeedItem::active()->count(),
        ]]);
    }
}
