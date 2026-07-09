<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;

/**
 * Bascule les contenus du site de « ferme en vente directe » vers
 * « centre de formation ».
 *
 * Ce seeder ÉCRASE en base les réglages listés dans REPLACE, en les
 * ramenant à leur valeur par défaut du registre (config/site_settings.php).
 *
 * Il ne touche volontairement PAS aux réglages déjà personnalisés par le
 * centre depuis le back-office (nom du site, slogan, logo, coordonnées,
 * réseaux sociaux) : voir la liste PRESERVE ci-dessous.
 *
 *     php artisan db:seed --class=IdentitySeeder
 */
class IdentitySeeder extends Seeder
{
    /** Réglages dont le contenu « ferme » doit être remplacé. */
    private const REPLACE = [
        // Bannière
        'hero_title', 'hero_highlight', 'hero_title_suffix', 'hero_subtitle', 'hero_cta_primary',
        'hero_card_title', 'hero_card_items',
        // Chiffres clés
        'stats',
        // Nos formations
        'formations_eyebrow', 'formations_title', 'formations_subtitle',
        // Pourquoi nous
        'why_eyebrow', 'why_title', 'why_subtitle', 'why_items',
        // Titres de sections
        'categories_eyebrow', 'categories_title', 'categories_subtitle',
        'contact_title', 'contact_subtitle', 'cta_box_title', 'cta_box_subtitle',
        // Pied de page
        'footer_about', 'copyright', 'footer_services',
        // SEO
        'meta_title', 'meta_description',
        // Identité complémentaire
        'company_name', 'logo_emoji',
        // Coordonnées & messages
        'email', 'address', 'address_detail', 'wa_msg_default', 'wa_msg_formation',
        // Réseaux sociaux ajoutés
        'tiktok_url',
    ];

    /**
     * Réglages laissés intacts : le centre les a déjà renseignés lui-même.
     * Les modifier reviendrait à écraser son travail.
     */
    private const PRESERVE = [
        'site_name', 'tagline', 'slogan', 'hero_eyebrow', 'logo_image_url', 'hero_image_url',
        'phone1', 'phone2', 'whatsapp', 'website', 'facebook_url',
        'instagram_url', 'linkedin_url', 'youtube_url', 'wa_msg_product',
    ];

    public function run(): void
    {
        $registry = SiteSettings::registry();
        $replaced = 0;

        foreach (self::REPLACE as $key) {
            if (in_array($key, self::PRESERVE, true)) {
                continue; // garde-fou : une clé ne peut pas être dans les deux listes
            }
            if (! isset($registry[$key])) {
                $this->command->warn("Réglage inconnu, ignoré : {$key}");
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => SiteSettings::encode($key, $registry[$key]['default'] ?? ''),
                    'group' => $registry[$key]['group'] ?? 'general',
                ],
            );
            $replaced++;
        }

        SiteSettings::flushCache();

        $this->command->info("Identité « centre de formation » appliquée : {$replaced} réglage(s) mis à jour.");
        $this->command->info('Réglages préservés : ' . implode(', ', self::PRESERVE));
    }
}
