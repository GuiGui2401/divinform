<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FarmBatchResource;
use App\Models\FarmBatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FarmBatchController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FarmBatch::with(['unit', 'product'])->latest('started_on');

        if ($request->filled('farm_unit_id')) $query->where('farm_unit_id', $request->farm_unit_id);
        if ($request->filled('status'))       $query->where('status', $request->status);
        if ($request->boolean('open'))        $query->open();

        return response()->json(['data' => FarmBatchResource::collection($query->get())]);
    }

    public function show(FarmBatch $farmBatch): JsonResponse
    {
        return response()->json([
            'data' => new FarmBatchResource($farmBatch->load(['unit', 'product'])),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        // À la création, l'effectif vivant part de l'effectif initial :
        // aucune mortalité n'a encore été enregistrée.
        $data['current_qty'] = $data['initial_qty'];

        $batch = FarmBatch::create($data);

        return response()->json([
            'message' => 'Bande créée.',
            'data'    => new FarmBatchResource($batch->load(['unit', 'product'])),
        ], 201);
    }

    public function update(Request $request, FarmBatch $farmBatch): JsonResponse
    {
        $data = $request->validate($this->rules(true, $farmBatch->id));

        $farmBatch->update($data);

        // L'effectif initial a pu changer : on redérive l'effectif vivant
        // depuis les mortalités enregistrées.
        if (array_key_exists('initial_qty', $data)) {
            $farmBatch->recomputeHeadcount();
        }

        return response()->json([
            'message' => 'Bande mise à jour.',
            'data'    => new FarmBatchResource($farmBatch->fresh()->load(['unit', 'product'])),
        ]);
    }

    public function destroy(FarmBatch $farmBatch): JsonResponse
    {
        $farmBatch->delete();

        return response()->json(['message' => 'Bande supprimée.']);
    }

    private function rules(bool $isUpdate = false, ?int $ignoreId = null): array
    {
        $require = $isUpdate ? 'sometimes' : 'required';
        $unique  = 'unique:farm_batches,code' . ($ignoreId ? ",{$ignoreId}" : '');

        return [
            'farm_unit_id'    => "{$require}|exists:farm_units,id",
            'product_id'      => 'nullable|exists:products,id',
            'code'            => "{$require}|string|max:40|{$unique}",
            'species'         => "{$require}|string|max:60",
            'breed'           => 'nullable|string|max:80',
            'started_on'      => "{$require}|date",
            'expected_end_on' => 'nullable|date|after_or_equal:started_on',
            'initial_qty'     => "{$require}|integer|min:1",
            'avg_weight_g'    => 'nullable|integer|min:0',
            'status'          => 'nullable|in:' . implode(',', FarmBatch::STATUSES),
            'notes'           => 'nullable|string',
        ];
    }
}
