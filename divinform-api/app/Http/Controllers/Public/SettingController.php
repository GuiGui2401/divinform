<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    /**
     * GET /api/v1/settings
     * Map plate clé => valeur de tous les réglages publics (listes décodées).
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => SiteSettings::publicValues(),
        ]);
    }
}
