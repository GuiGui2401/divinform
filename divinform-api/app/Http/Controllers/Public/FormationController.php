<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    /**
     * GET /api/v1/formations
     */
    public function index(Request $request): JsonResponse
    {
        $query = Formation::with('upcomingSessions')->active()->ordered();

        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('level'))  $query->level($request->level);
        if ($request->boolean('featured')) $query->featured();

        $perPage    = min((int) $request->get('per_page', 12), 50);
        $formations = $query->paginate($perPage);

        return response()->json([
            'data'         => FormationResource::collection($formations->items()),
            'total'        => $formations->total(),
            'per_page'     => $formations->perPage(),
            'current_page' => $formations->currentPage(),
            'last_page'    => $formations->lastPage(),
        ]);
    }

    /**
     * GET /api/v1/formations/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $formation = Formation::with('upcomingSessions')
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json(['data' => new FormationResource($formation)]);
    }

    /**
     * POST /api/v1/formations/{id}/view
     */
    public function trackView(Formation $formation): JsonResponse
    {
        $formation->incrementViews();
        return response()->json(['message' => 'ok']);
    }

    /**
     * POST /api/v1/formations/{id}/contact
     */
    public function trackContact(Formation $formation): JsonResponse
    {
        $formation->incrementContact();
        return response()->json(['message' => 'ok']);
    }
}
