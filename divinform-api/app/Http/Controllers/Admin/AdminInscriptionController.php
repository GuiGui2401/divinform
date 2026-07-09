<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InscriptionResource;
use App\Models\Inscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminInscriptionController extends Controller
{
    /**
     * GET /api/admin/inscriptions
     */
    public function index(Request $request): JsonResponse
    {
        $query = Inscription::with('session')->latest();

        if ($request->filled('status'))       $query->status($request->status);
        if ($request->filled('formation_id')) $query->where('formation_id', $request->formation_id);

        $perPage      = min((int) $request->get('per_page', 20), 100);
        $inscriptions = $query->paginate($perPage);

        return response()->json([
            'data'         => InscriptionResource::collection($inscriptions->items()),
            'total'        => $inscriptions->total(),
            'per_page'     => $inscriptions->perPage(),
            'current_page' => $inscriptions->currentPage(),
            'last_page'    => $inscriptions->lastPage(),
            'counts'       => Inscription::query()
                ->select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status'),
        ]);
    }

    /**
     * PUT /api/admin/inscriptions/{inscription}
     *
     * Le passage à « confirmee » réserve une place sur la session ;
     * en sortir la libère. Les compteurs restent donc cohérents.
     */
    public function update(Request $request, Inscription $inscription): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status'     => 'sometimes|in:' . implode(',', Inscription::STATUSES),
            'admin_note' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data      = $validator->validated();
        $oldStatus = $inscription->status;
        $newStatus = $data['status'] ?? $oldStatus;

        DB::transaction(function () use ($inscription, $data, $oldStatus, $newStatus) {
            $inscription->update($data);

            $session = $inscription->session()->lockForUpdate()->first();
            if (! $session || $oldStatus === $newStatus) {
                return;
            }

            if ($newStatus === 'confirmee') {
                $session->increment('seats_taken');
            } elseif ($oldStatus === 'confirmee' && $session->seats_taken > 0) {
                $session->decrement('seats_taken');
            }
        });

        return response()->json([
            'message' => 'Demande mise à jour.',
            'data'    => new InscriptionResource($inscription->fresh()->load('session')),
        ]);
    }

    /**
     * DELETE /api/admin/inscriptions/{inscription}
     */
    public function destroy(Inscription $inscription): JsonResponse
    {
        DB::transaction(function () use ($inscription) {
            $session = $inscription->session()->lockForUpdate()->first();
            if ($inscription->status === 'confirmee' && $session && $session->seats_taken > 0) {
                $session->decrement('seats_taken');
            }
            $inscription->delete();
        });

        return response()->json(['message' => 'Demande supprimée.']);
    }
}
