<?php

/*
|--------------------------------------------------------------------------
| Réglages du site — registre central
|--------------------------------------------------------------------------
| Chaque réglage est défini UNE seule fois ici. Ce registre pilote :
|   - les valeurs par défaut (seeder + fallback API)
|   - la validation et l'enregistrement (AdminSettingController)
|   - l'API publique (Public/SettingController)
|   - le formulaire d'administration (généré automatiquement)
|
| type : text | textarea | email | url | number | color | image | list
| public : exposé sur l'API publique /v1/settings (consommé par la boutique)
| Pour les listes : "fields" décrit les colonnes de chaque ligne.
*/

return [

    // Libellés + ordre des groupes (onglets/sections du formulaire admin)
    'groups' => [
        'branding' => 'Identité & logo',
        'contact'  => 'Coordonnées',
        'social'   => 'Réseaux sociaux',
        'hero'     => 'Accueil — Bannière',
        'stats'    => 'Accueil — Chiffres clés',
        'sections' => 'Accueil — Titres de sections',
        'why'      => 'Accueil — Pourquoi nous',
        'footer'   => 'Pied de page',
        'seo'      => 'SEO (référencement)',
    ],

    'settings' => [

        // ── Identité ────────────────────────────────────────────────
        'site_name'      => ['group' => 'branding', 'label' => 'Nom du site',            'type' => 'text',  'default' => 'Medex65',                         'rules' => 'nullable|string|max:100', 'public' => true],
        'company_name'   => ['group' => 'branding', 'label' => 'Raison sociale',         'type' => 'text',  'default' => 'Medex65 SARL',                    'rules' => 'nullable|string|max:150', 'public' => true],
        'logo_emoji'     => ['group' => 'branding', 'label' => 'Logo (emoji)',           'type' => 'text',  'default' => '🫀',                              'rules' => 'nullable|string|max:16',  'public' => true, 'help' => 'Emoji affiché dans le logo si aucune image n\'est fournie.'],
        'logo_image_url' => ['group' => 'branding', 'label' => 'Logo (URL image)',       'type' => 'image', 'default' => '',                               'rules' => 'nullable|string|max:300', 'public' => true, 'help' => 'Si renseignée, remplace l\'emoji par une image.'],
        'tagline'        => ['group' => 'branding', 'label' => 'Slogan court (sous le logo)', 'type' => 'text', 'default' => 'Faites confiance au processus', 'rules' => 'nullable|string|max:120', 'public' => true],
        'slogan'         => ['group' => 'branding', 'label' => 'Slogan principal',       'type' => 'text',  'default' => 'Faites confiance au processus',   'rules' => 'nullable|string|max:200', 'public' => true],

        // ── Coordonnées ─────────────────────────────────────────────
        'phone1'         => ['group' => 'contact', 'label' => 'Téléphone 1',             'type' => 'text',     'default' => '+237 696 809 909',                          'rules' => 'nullable|string|max:30',  'public' => true],
        'phone2'         => ['group' => 'contact', 'label' => 'Téléphone 2',             'type' => 'text',     'default' => '+237 696 534 179',                          'rules' => 'nullable|string|max:30',  'public' => true],
        'whatsapp'       => ['group' => 'contact', 'label' => 'Numéro WhatsApp (sans +)','type' => 'text',     'default' => '237696809909',                              'rules' => 'nullable|string|max:30',  'public' => true],
        'email'          => ['group' => 'contact', 'label' => 'Adresse email',           'type' => 'email',    'default' => 'info@medex237.com',                         'rules' => 'nullable|email|max:120',  'public' => true],
        'website'        => ['group' => 'contact', 'label' => 'Site web',                'type' => 'text',     'default' => 'www.medex237.com',                          'rules' => 'nullable|string|max:120', 'public' => true],
        'address'        => ['group' => 'contact', 'label' => 'Adresse (ligne 1)',       'type' => 'text',     'default' => 'Cameroun — Bafoussam',                      'rules' => 'nullable|string|max:200', 'public' => true],
        'address_detail' => ['group' => 'contact', 'label' => 'Adresse (ligne 2)',       'type' => 'text',     'default' => 'Quartier Haoussa',                          'rules' => 'nullable|string|max:200', 'public' => true],
        'wa_msg_default' => ['group' => 'contact', 'label' => 'Message WhatsApp par défaut', 'type' => 'textarea', 'default' => 'Bonjour, je voudrais avoir des informations sur vos équipements médicaux.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'wa_msg_product' => ['group' => 'contact', 'label' => 'Message WhatsApp (produit)',  'type' => 'textarea', 'default' => "Bonjour, je suis intéressé par l'équipement : {product}. Pouvez-vous me donner plus d'informations ?", 'rules' => 'nullable|string|max:400', 'public' => true, 'help' => 'Utilisez {product} pour insérer le nom du produit.'],

        // ── Réseaux sociaux ─────────────────────────────────────────
        'facebook_url'  => ['group' => 'social', 'label' => 'Facebook',  'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'instagram_url' => ['group' => 'social', 'label' => 'Instagram', 'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'linkedin_url'  => ['group' => 'social', 'label' => 'LinkedIn',  'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'youtube_url'   => ['group' => 'social', 'label' => 'YouTube',   'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],

        // ── Hero / Bannière ─────────────────────────────────────────
        'hero_eyebrow'       => ['group' => 'hero', 'label' => 'Sur-titre (badge)',        'type' => 'text',     'default' => 'Équipements médicaux certifiés',                  'rules' => 'nullable|string|max:120', 'public' => true],
        'hero_title'         => ['group' => 'hero', 'label' => 'Titre — début',            'type' => 'text',     'default' => 'Équipements',                                     'rules' => 'nullable|string|max:120', 'public' => true],
        'hero_highlight'     => ['group' => 'hero', 'label' => 'Titre — mot surligné (vert)', 'type' => 'text',  'default' => 'Innovants',                                       'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_title_suffix'  => ['group' => 'hero', 'label' => 'Titre — suite',            'type' => 'text',     'default' => 'pour un Diagnostic de Précision',                 'rules' => 'nullable|string|max:160', 'public' => true],
        'hero_subtitle'      => ['group' => 'hero', 'label' => 'Sous-titre (paragraphe)',  'type' => 'textarea', 'default' => 'MEDEX SARL vous propose des équipements médicaux fiables et performants pour l\'imagerie médicale et le laboratoire, pour une meilleure prise en charge des patients.', 'rules' => 'nullable|string|max:600', 'public' => true],
        'hero_cta_primary'   => ['group' => 'hero', 'label' => 'Bouton principal',         'type' => 'text',     'default' => '🔬 Voir nos équipements',                         'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_cta_secondary' => ['group' => 'hero', 'label' => 'Bouton secondaire',        'type' => 'text',     'default' => '📞 Nous contacter',                               'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_image_url'     => ['group' => 'hero', 'label' => 'Image de fond (URL)',      'type' => 'image',    'default' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=1600&q=80', 'rules' => 'nullable|string|max:400', 'public' => true],
        'guarantee_months'   => ['group' => 'hero', 'label' => 'Garantie (mois)',          'type' => 'number',   'default' => '12',                                              'rules' => 'nullable|integer|min:0|max:120', 'public' => true],

        // ── Chiffres clés (liste) ───────────────────────────────────
        'stats' => [
            'group' => 'stats', 'label' => 'Chiffres clés (bannière)', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Chiffre',
            'fields' => [
                ['key' => 'num',   'label' => 'Valeur',  'type' => 'text'],
                ['key' => 'label', 'label' => 'Libellé', 'type' => 'text'],
            ],
            'default' => [
                ['num' => '120+',   'label' => 'Produits certifiés'],
                ['num' => '85+',    'label' => 'Hôpitaux équipés'],
                ['num' => '10 ans', 'label' => "D'expérience"],
                ['num' => '24/7',   'label' => 'Support technique'],
            ],
        ],

        // ── Titres de sections ──────────────────────────────────────
        'categories_eyebrow'  => ['group' => 'sections', 'label' => 'Catégories — sur-titre',  'type' => 'text',     'default' => 'Nos domaines',                          'rules' => 'nullable|string|max:120', 'public' => true],
        'categories_title'    => ['group' => 'sections', 'label' => 'Catégories — titre',      'type' => 'text',     'default' => "Nos gammes d'équipements",              'rules' => 'nullable|string|max:160', 'public' => true],
        'categories_subtitle' => ['group' => 'sections', 'label' => 'Catégories — description','type' => 'textarea', 'default' => "De l'imagerie médicale de pointe au mobilier hospitalier certifié, découvrez notre catalogue complet.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'contact_eyebrow'     => ['group' => 'sections', 'label' => 'Contact — sur-titre',     'type' => 'text',     'default' => 'Contactez-nous',                        'rules' => 'nullable|string|max:120', 'public' => true],
        'contact_title'       => ['group' => 'sections', 'label' => 'Contact — titre',         'type' => 'text',     'default' => 'Parlons de vos besoins médicaux',       'rules' => 'nullable|string|max:160', 'public' => true],
        'contact_subtitle'    => ['group' => 'sections', 'label' => 'Contact — description',   'type' => 'textarea', 'default' => "Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans votre projet d'acquisition.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'cta_box_title'       => ['group' => 'sections', 'label' => 'Encart CTA — titre',      'type' => 'text',     'default' => 'Prêt à équiper votre structure médicale ?', 'rules' => 'nullable|string|max:160', 'public' => true],
        'cta_box_subtitle'    => ['group' => 'sections', 'label' => 'Encart CTA — sous-titre', 'type' => 'textarea', 'default' => 'Contactez-nous dès maintenant pour un devis personnalisé et gratuit.', 'rules' => 'nullable|string|max:300', 'public' => true],

        // ── Pourquoi nous ───────────────────────────────────────────
        'why_eyebrow'  => ['group' => 'why', 'label' => 'Sur-titre',   'type' => 'text',     'default' => 'Nos engagements',                                                          'rules' => 'nullable|string|max:120', 'public' => true],
        'why_title'    => ['group' => 'why', 'label' => 'Titre',       'type' => 'text',     'default' => 'Pourquoi choisir Medex65 ?',                                               'rules' => 'nullable|string|max:160', 'public' => true],
        'why_subtitle' => ['group' => 'why', 'label' => 'Description', 'type' => 'textarea', 'default' => 'Des équipements de qualité supérieure avec un accompagnement complet à chaque étape.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'why_items' => [
            'group' => 'why', 'label' => 'Cartes « Pourquoi nous »', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Carte',
            'fields' => [
                ['key' => 'icon',  'label' => 'Icône (emoji)', 'type' => 'text'],
                ['key' => 'title', 'label' => 'Titre',         'type' => 'text'],
                ['key' => 'desc',  'label' => 'Description',    'type' => 'textarea'],
            ],
            'default' => [
                ['icon' => '🏆', 'title' => 'Technologies de pointe',      'desc' => 'Équipements de dernière génération conformes aux normes internationales les plus strictes.'],
                ['icon' => '🔒', 'title' => 'Sécurité et conformité',      'desc' => 'Tous nos produits sont certifiés et répondent aux exigences réglementaires médicales.'],
                ['icon' => '🛠️', 'title' => 'Maintenance rapide',          'desc' => 'Service après-vente réactif avec des techniciens qualifiés disponibles 24h/7j.'],
                ['icon' => '🎓', 'title' => 'Formation incluse',            'desc' => 'Formation complète du personnel soignant et technique lors de chaque installation.'],
                ['icon' => '🚚', 'title' => 'Livraison partout',            'desc' => "Livraison et installation sur site dans toutes les régions du Cameroun et d'Afrique Centrale."],
                ['icon' => '🤝', 'title' => 'Accompagnement personnalisé', 'desc' => 'Conseil expert adapté à vos besoins spécifiques et à votre budget.'],
            ],
        ],

        // ── Pied de page ────────────────────────────────────────────
        'footer_about'     => ['group' => 'footer', 'label' => 'Texte « À propos »', 'type' => 'textarea', 'default' => 'Votre partenaire en technologies médicales de pointe. Équipements certifiés, maintenance rapide, formation incluse.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'copyright'        => ['group' => 'footer', 'label' => 'Mention copyright',  'type' => 'text',     'default' => '© {year} Medex65 SARL. Tous droits réservés.', 'rules' => 'nullable|string|max:200', 'public' => true, 'help' => 'Utilisez {year} pour l\'année courante.'],
        'footer_services'  => [
            'group' => 'footer', 'label' => 'Liste « Services »', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Service',
            'fields' => [
                ['key' => 'label', 'label' => 'Intitulé', 'type' => 'text'],
            ],
            'default' => [
                ['label' => 'Maintenance technique'],
                ['label' => 'Formation du personnel'],
                ['label' => 'Installation sur site'],
                ['label' => 'Consommables & accessoires'],
            ],
        ],

        // ── SEO ─────────────────────────────────────────────────────
        'meta_title'       => ['group' => 'seo', 'label' => 'Titre de la page (onglet navigateur)', 'type' => 'text',     'default' => 'Medex65 — Équipements Médicaux Innovants', 'rules' => 'nullable|string|max:160', 'public' => true],
        'meta_description' => ['group' => 'seo', 'label' => 'Méta-description',                      'type' => 'textarea', 'default' => 'Medex65 — Équipements médicaux innovants pour un diagnostic de précision. Imagerie médicale, laboratoire, mobilier hospitalier.', 'rules' => 'nullable|string|max:300', 'public' => true],
    ],
];
