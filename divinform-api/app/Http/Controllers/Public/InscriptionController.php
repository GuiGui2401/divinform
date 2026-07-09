<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\FormationSession;
use App\Models\Inscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InscriptionController extends Controller
{
    /**
     * POST /api/v1/inscriptions
     *
     * Demande d'inscription déposée par un visiteur. Aucune place n'est
     * réservée ici : le centre confirme la demande depuis le back-office.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'formation_id'         => 'required|exists:formations,id',
            'formation_session_id' => 'nullable|exists:formation_sessions,id',
            'name'                 => 'required|string|max:120',
            'phone'                => 'required|string|max:30',
            'email'                => 'nullable|email|max:120',
            'message'              => 'nullable|string|max:1000',
            // Pot de miel : rempli uniquement par les robots.
            'website'              => 'nullable|prohibited',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Merci de vérifier les informations saisies.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data      = $validator->validated();
        $formation = Formation::active()->findOrFail($data['formation_id']);

        // La session doit appartenir à la formation demandée.
        if (! empty($data['formation_session_id'])) {
            $session = FormationSession::find($data['formation_session_id']);
            if (! $session || $session->formation_id !== $formation->id) {
                return response()->json([
                    'message' => 'La session choisie ne correspond pas à cette formation.',
                    'errors'  => ['formation_session_id' => ['Session invalide.']],
                ], 422);
            }
            if (! $session->registration_open || $session->is_full) {
                return response()->json([
                    'message' => 'Les inscriptions à cette session ne sont plus ouvertes.',
                    'errors'  => ['formation_session_id' => ['Session complète ou fermée.']],
                ], 422);
            }
        }

        $inscription = Inscription::create([
            'formation_id'         => $formation->id,
            'formation_session_id' => $data['formation_session_id'] ?? null,
            'formation_title'      => $formation->title,
            'name'                 => $data['name'],
            'phone'                => $data['phone'],
            'email'                => $data['email']   ?? null,
            'message'              => $data['message'] ?? null,
            'status'               => 'nouvelle',
            'ip'                   => $request->ip(),
        ]);

        $formation->incrementContact();

        return response()->json([
            'message' => 'Votre demande d\'inscription a bien été enregistrée. Nous vous recontactons très vite.',
            'data'    => ['id' => $inscription->id],
        ], 201);
    }
}
