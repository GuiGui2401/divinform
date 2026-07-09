<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\MediaUploader;
use App\Support\SiteSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * GET /api/admin/settings
     * Renvoie le schéma (pour générer le formulaire) + les valeurs courantes.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => [
                'schema' => SiteSettings::adminSchema(),
                'values' => SiteSettings::resolved(),
            ],
        ]);
    }

    /**
     * PUT /api/admin/settings
     * Valide dynamiquement selon le registre et enregistre chaque réglage fourni.
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate(SiteSettings::rules());

        foreach ($validated as $key => $value) {
            if (! SiteSettings::exists($key) || ! $request->exists($key)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => SiteSettings::encode($key, $value),
                    'group' => SiteSettings::groupOf($key),
                ]
            );
            Setting::clearCache($key);
        }

        SiteSettings::flushCache();

        return response()->json([
            'message' => 'Paramètres mis à jour avec succès.',
            'data'    => SiteSettings::resolved(),
        ]);
    }

    /**
     * POST /api/admin/settings/upload
     * Téléverse une image (logo, bannière…) et renvoie son URL publique absolue.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,svg,gif|max:4096',
        ]);

        return response()->json([
            'message' => 'Image téléversée avec succès.',
            'url'     => MediaUploader::store($request->file('file'), 'settings'),
        ]);
    }
}
