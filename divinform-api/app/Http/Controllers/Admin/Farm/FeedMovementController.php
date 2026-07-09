<?php

namespace App\Http\Controllers\Admin\Farm;

use App\Exceptions\StockException;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedMovementResource;
use App\Models\FeedItem;
use App\Models\FeedMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedMovementController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FeedMovement::with(['item', 'batch', 'user'])
            ->orderByDesc('occurred_on')
            ->orderByDesc('id');

        if ($request->filled('feed_item_id'))  $query->where('feed_item_id', $request->feed_item_id);
        if ($request->filled('farm_batch_id')) $query->where('farm_batch_id', $request->farm_batch_id);
        if ($request->filled('type'))          $query->where('type', $request->type);
        if ($request->boolean('rations'))      $query->rations();

        $perPage    = min((int) $request->get('per_page', 50), 200);
        $movements  = $query->paginate($perPage);

        return response()->json([
            'data'         => FeedMovementResource::collection($movements->items()),
            'total'        => $movements->total(),
            'current_page' => $movements->currentPage(),
            'last_page'    => $movements->lastPage(),
        ]);
    }

    /**
     * POST /api/admin/farm/feed-movements
     *
     * Une ration distribuée est un mouvement « sortie » portant farm_batch_id.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'feed_item_id'  => 'required|exists:feed_items,id',
            'farm_batch_id' => 'nullable|exists:farm_batches,id',
            'type'          => 'required|in:' . implode(',', FeedMovement::TYPES),
            'quantity'      => 'required|numeric|min:0',
            'unit_cost'     => 'nullable|integer|min:0',
            'occurred_on'   => 'required|date',
            'note'          => 'nullable|string|max:255',
        ]);

        // Seule une sortie peut être imputée à une bande.
        if (! empty($data['farm_batch_id']) && $data['type'] !== 'sortie') {
            return response()->json([
                'message' => 'Seule une sortie de stock peut être affectée à une bande.',
                'errors'  => ['farm_batch_id' => ['Type de mouvement incompatible.']],
            ], 422);
        }

        try {
            $movement = DB::transaction(function () use ($data, $request) {
                $item = FeedItem::lockForUpdate()->findOrFail($data['feed_item_id']);

                $movement = $item->movements()->create($data + [
                    'user_id'   => $request->user()?->id,
                    'qty_after' => 0, // recalculé par le rejeu ci-dessous
                ]);

                // Lève StockException si le stock devient négatif à une date
                // quelconque : la transaction est alors annulée, rien n'est écrit.
                $item->recomputeStock();

                return $movement;
            });
        } catch (StockException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors'  => ['quantity' => [$e->getMessage()]],
            ], 422);
        }

        return response()->json([
            'message' => 'Mouvement enregistré.',
            'data'    => new FeedMovementResource($movement->fresh()->load(['item', 'batch'])),
        ], 201);
    }

    public function destroy(FeedMovement $feedMovement): JsonResponse
    {
        try {
            DB::transaction(function () use ($feedMovement) {
                $item = FeedItem::lockForUpdate()->findOrFail($feedMovement->feed_item_id);
                $feedMovement->delete();
                $item->recomputeStock();
            });
        } catch (StockException $e) {
            // Supprimer une entrée peut rendre des sorties ultérieures impossibles.
            return response()->json([
                'message' => 'Suppression refusée : ' . $e->getMessage(),
            ], 422);
        }

        return response()->json(['message' => 'Mouvement supprimé, stock recalculé.']);
    }
}
