<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MediaUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * POST /api/admin/uploads
     * Téléversement d'image générique (produits, catégories…) pour tout admin.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file'   => 'required|file|mimes:jpeg,png,jpg,webp,svg,gif|max:4096',
            'folder' => 'nullable|string',
        ]);

        $url = MediaUploader::store($request->file('file'), $request->input('folder', 'misc'));

        return response()->json([
            'message' => 'Image téléversée avec succès.',
            'url'     => $url,
        ]);
    }
}
