<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Couche d'accès au registre des réglages du site (config/site_settings.php).
 * Centralise défauts, validation, encodage des listes, et fusion BDD + défauts.
 */
class SiteSettings
{
    public const CACHE_KEY = 'site_settings:resolved:v1';

    /** @return array<string,array> définition de chaque réglage */
    public static function registry(): array
    {
        return config('site_settings.settings', []);
    }

    /** @return array<string,string> libellés des groupes (dans l'ordre) */
    public static function groups(): array
    {
        return config('site_settings.groups', []);
    }

    public static function isList(string $key): bool
    {
        return (self::registry()[$key]['type'] ?? null) === 'list';
    }

    public static function exists(string $key): bool
    {
        return isset(self::registry()[$key]);
    }

    public static function groupOf(string $key): string
    {
        return self::registry()[$key]['group'] ?? 'general';
    }

    /** Règles de validation, clé => règle. Les listes restreintes à array. */
    public static function rules(): array
    {
        $rules = [];
        foreach (self::registry() as $key => $def) {
            $rules[$key] = $def['rules'] ?? 'nullable';
        }

        return $rules;
    }

    /** Valeurs par défaut (listes en tableaux PHP). */
    public static function defaults(): array
    {
        $out = [];
        foreach (self::registry() as $key => $def) {
            $out[$key] = $def['default'] ?? ($def['type'] === 'list' ? [] : '');
        }

        return $out;
    }

    /** Décode une valeur brute issue de la BDD selon son type. */
    public static function decode(string $key, mixed $value): mixed
    {
        if (self::isList($key)) {
            if (is_array($value)) {
                return $value;
            }
            $decoded = json_decode((string) $value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return $value;
    }

    /** Encode une valeur pour stockage (listes en JSON). */
    public static function encode(string $key, mixed $value): string
    {
        if (self::isList($key)) {
            return json_encode(is_array($value) ? array_values($value) : [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $value === null ? '' : (string) $value;
    }

    /**
     * Toutes les valeurs résolues (défauts fusionnés avec la BDD), décodées.
     * Mis en cache et invalidé à chaque sauvegarde.
     */
    public static function resolved(): array
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            $db = Setting::pluck('value', 'key')->toArray();
            $out = [];
            foreach (self::registry() as $key => $def) {
                $raw = array_key_exists($key, $db) ? $db[$key] : null;
                $out[$key] = $raw === null
                    ? ($def['default'] ?? ($def['type'] === 'list' ? [] : ''))
                    : self::decode($key, $raw);
            }

            return $out;
        });
    }

    /** Sous-ensemble exposé publiquement (boutique). */
    public static function publicValues(): array
    {
        $resolved = self::resolved();
        $out = [];
        foreach (self::registry() as $key => $def) {
            if (! empty($def['public'])) {
                $out[$key] = $resolved[$key];
            }
        }

        return $out;
    }

    /**
     * Schéma destiné au formulaire d'administration : groupes ordonnés,
     * chacun avec ses champs (type, libellé, aide, sous-champs des listes).
     */
    public static function adminSchema(): array
    {
        $schema = [];
        foreach (self::groups() as $gKey => $gLabel) {
            $schema[$gKey] = ['key' => $gKey, 'label' => $gLabel, 'fields' => []];
        }

        foreach (self::registry() as $key => $def) {
            $group = $def['group'] ?? 'general';
            if (! isset($schema[$group])) {
                $schema[$group] = ['key' => $group, 'label' => ucfirst($group), 'fields' => []];
            }
            $schema[$group]['fields'][] = [
                'key'        => $key,
                'label'      => $def['label'] ?? $key,
                'type'       => $def['type'] ?? 'text',
                'help'       => $def['help'] ?? null,
                'item_label' => $def['item_label'] ?? 'Élément',
                'fields'     => $def['fields'] ?? null,
            ];
        }

        return array_values($schema);
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
