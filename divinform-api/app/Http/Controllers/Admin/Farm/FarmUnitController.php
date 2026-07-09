<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FarmUnitResource;
use App\Models\FarmUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FarmUnitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $units = FarmUnit::withCount(['batches', 'animals'])->ordered()->get();

        return response()->json(['data' => FarmUnitResource::collection($units)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $unit = FarmUnit::create($data);

        return response()->json([
            'message' => 'Atelier créé.',
            'data'    => new FarmUnitResource($unit),
        ], 201);
    }

    public function update(Request $request, FarmUnit $farmUnit): JsonResponse
    {
        $data = $request->validate($this->rules(true));
        $farmUnit->update($data);

        return response()->json([
            'message' => 'Atelier mis à jour.',
            'data'    => new FarmUnitResource($farmUnit->fresh()),
        ]);
    }

    public function destroy(FarmUnit $farmUnit): JsonResponse
    {
        // Les bandes et animaux sont supprimés en cascade : on refuse tant
        // qu'il reste des données d'élevage rattachées.
        if ($farmUnit->batches()->exists() || $farmUnit->animals()->exists()) {
            return response()->json([
                'message' => 'Impossible : cet atelier contient encore des bandes ou des animaux.',
            ], 409);
        }

        $farmUnit->delete();

        return response()->json(['message' => 'Atelier supprimé.']);
    }

    private function rules(bool $isUpdate = false): array
    {
        $require = $isUpdate ? 'sometimes' : 'required';

        return [
            'name'       => "{$require}|string|max:100",
            'type'       => 'nullable|in:' . implode(',', FarmUnit::TYPES),
            'location'   => 'nullable|string|max:150',
            'capacity'   => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
            'notes'      => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
