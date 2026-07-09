<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FarmAnimalResource;
use App\Models\FarmAnimal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FarmAnimalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FarmAnimal::with('unit')->orderBy('tag');

        if ($request->filled('farm_unit_id')) $query->where('farm_unit_id', $request->farm_unit_id);
        if ($request->filled('status'))       $query->where('status', $request->status);
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($q) => $q->where('tag', 'LIKE', "%{$term}%")
                                       ->orWhere('name', 'LIKE', "%{$term}%"));
        }

        return response()->json(['data' => FarmAnimalResource::collection($query->get())]);
    }

    public function store(Request $request): JsonResponse
    {
        $data   = $request->validate($this->rules());
        $animal = FarmAnimal::create($data);

        return response()->json([
            'message' => 'Animal enregistré.',
            'data'    => new FarmAnimalResource($animal->load('unit')),
        ], 201);
    }

    public function update(Request $request, FarmAnimal $farmAnimal): JsonResponse
    {
        $data = $request->validate($this->rules(true, $farmAnimal->id));
        $farmAnimal->update($data);

        return response()->json([
            'message' => 'Animal mis à jour.',
            'data'    => new FarmAnimalResource($farmAnimal->fresh()->load('unit')),
        ]);
    }

    public function destroy(FarmAnimal $farmAnimal): JsonResponse
    {
        $farmAnimal->delete();

        return response()->json(['message' => 'Animal supprimé.']);
    }

    private function rules(bool $isUpdate = false, ?int $ignoreId = null): array
    {
        $require = $isUpdate ? 'sometimes' : 'required';
        $unique  = 'unique:farm_animals,tag' . ($ignoreId ? ",{$ignoreId}" : '');

        return [
            'farm_unit_id'  => "{$require}|exists:farm_units,id",
            'farm_batch_id' => 'nullable|exists:farm_batches,id',
            'tag'           => "{$require}|string|max:40|{$unique}",
            'name'          => 'nullable|string|max:80',
            'species'       => "{$require}|string|max:60",
            'breed'         => 'nullable|string|max:80',
            'sex'           => 'nullable|in:M,F',
            'born_on'       => 'nullable|date',
            'entered_on'    => 'nullable|date',
            'status'        => 'nullable|in:' . implode(',', FarmAnimal::STATUSES),
            'notes'         => 'nullable|string',
        ];
    }
}
