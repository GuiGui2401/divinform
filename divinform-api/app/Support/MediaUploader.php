<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Stockage centralisé des images téléversées (produits, catégories, réglages…).
 * Renvoie l'URL publique absolue du fichier stocké.
 */
class MediaUploader
{
    private const FOLDERS = ['products', 'categories', 'settings', 'misc'];

    public static function store(UploadedFile $file, string $folder = 'misc'): string
    {
        $folder = in_array($folder, self::FOLDERS, true) ? $folder : 'misc';
        $ext    = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, ['svg', 'gif'], true)) {
            // Pas de ré-encodage : préserve le vectoriel (SVG) et l'animation (GIF).
            $filename = Str::uuid().'.'.$ext;
            Storage::put("public/{$folder}/{$filename}", file_get_contents($file->getRealPath()));
        } else {
            $filename = Str::uuid().'.webp';
            $image = (new ImageManager(new Driver()))
                ->read($file->getRealPath())
                ->scaleDown(width: 1600)
                ->toWebp(quality: 88);
            Storage::put("public/{$folder}/{$filename}", (string) $image);
        }

        return Storage::url("public/{$folder}/{$filename}");
    }
}
