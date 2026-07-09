<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedItemResource;
use App\Models\FeedItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeedItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FeedItem::orderBy('name');
        if ($request->boolean('low')) $query->lowStock();

        $items = $query->get();

        return response()->json([
            'data'      => FeedItemResource::collection($items),
            'low_count' => $items->where('is_low', true)->count(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Le stock ne se saisit pas : il découle des mouvements. Un aliment
        // naît donc à zéro, et sa première « entrée » constitue le stock.
        $item = FeedItem::create($request->validate($this->rules()));

        return response()->json([
            'message' => 'Aliment créé. Enregistrez une entrée de stock pour l\'approvisionner.',
            'data'    => new FeedItemResource($item),
        ], 201);
    }

    public function update(Request $request, FeedItem $feedItem): JsonResponse
    {
        $feedItem->update($request->validate($this->rules(true, $feedItem->id)));

        return response()->json([
            'message' => 'Aliment mis à jour.',
            'data'    => new FeedItemResource($feedItem->fresh()),
        ]);
    }

    public function destroy(FeedItem $feedItem): JsonResponse
    {
        if ($feedItem->movements()->exists()) {
            return response()->json([
                'message' => 'Impossible : cet aliment a un historique de mouvements. Désactivez-le plutôt.',
            ], 409);
        }

        $feedItem->delete();

        return response()->json(['message' => 'Aliment supprimé.']);
    }

    private function rules(bool $isUpdate = false, ?int $ignoreId = null): array
    {
        $require = $isUpdate ? 'sometimes' : 'required';
        $unique  = 'unique:feed_items,name' . ($ignoreId ? ",{$ignoreId}" : '');

        return [
            'name'            => "{$require}|string|max:120|{$unique}",
            'unit'            => 'nullable|string|max:10',
            'alert_threshold' => 'nullable|numeric|min:0',
            'unit_cost'       => 'nullable|integer|min:0',
            'active'          => 'nullable|boolean',
        ];
    }
}
