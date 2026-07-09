<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationSessionResource;
use App\Models\FormationSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFormationSessionController extends Controller
{
    /**
     * GET /api/admin/formation-sessions
     */
    public function index(Request $request): JsonResponse
    {
        $query = FormationSession::with('formation')->orderBy('starts_on');

        if ($request->filled('formation_id')) {
            $query->where('formation_id', $request->formation_id);
        }
        if ($request->boolean('upcoming')) {
            $query->upcoming();
        }

        $sessions = $query->get();

        return response()->json([
            'data' => $sessions->map(fn ($s) => array_merge(
                (new FormationSessionResource($s))->toArray($request),
                ['formation_title' => $s->formation?->title],
            )),
        ]);
    }

    /**
     * POST /api/admin/formation-sessions
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $session = FormationSession::create($validator->validated());

        return response()->json([
            'message' => 'Session créée.',
            'data'    => new FormationSessionResource($session),
        ], 201);
    }

    /**
     * PUT /api/admin/formation-sessions/{formation_session}
     */
    public function update(Request $request, FormationSession $formationSession): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->rules(true));

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // On ne peut pas descendre le nombre de places sous les inscriptions déjà confirmées.
        if (isset($data['seats']) && $data['seats'] > 0 && $data['seats'] < $formationSession->seats_taken) {
            return response()->json([
                'message' => 'Impossible : cette session compte déjà ' . $formationSession->seats_taken . ' inscrit(s).',
                'errors'  => ['seats' => ['Nombre de places inférieur aux inscriptions confirmées.']],
            ], 422);
        }

        $formationSession->update($data);

        return response()->json([
            'message' => 'Session mise à jour.',
            'data'    => new FormationSessionResource($formationSession->fresh()),
        ]);
    }

    /**
     * DELETE /api/admin/formation-sessions/{formation_session}
     */
    public function destroy(FormationSession $formationSession): JsonResponse
    {
        $formationSession->delete();
        return response()->json(['message' => 'Session supprimée.']);
    }

    private function rules(bool $isUpdate = false): array
    {
        $require = $isUpdate ? 'sometimes' : 'required';

        return [
            'formation_id'      => "{$require}|exists:formations,id",
            'starts_on'         => "{$require}|date",
            'ends_on'           => 'nullable|date|after_or_equal:starts_on',
            'location'          => 'nullable|string|max:200',
            'seats'             => 'nullable|integer|min:0|max:65535',
            'seats_taken'       => 'nullable|integer|min:0|max:65535',
            'registration_open' => 'nullable|boolean',
        ];
    }
}
