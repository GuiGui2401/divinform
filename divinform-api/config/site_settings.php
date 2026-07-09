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
        'branding'   => 'Identité & logo',
        'contact'    => 'Coordonnées',
        'social'     => 'Réseaux sociaux',
        'hero'       => 'Accueil — Bannière',
        'stats'      => 'Accueil — Chiffres clés',
        'formations' => 'Accueil — Nos formations',
        'sections'   => 'Accueil — Titres de sections',
        'why'        => 'Accueil — Pourquoi nous',
        'footer'     => 'Pied de page',
        'seo'        => 'SEO (référencement)',
    ],

    'settings' => [

        // ── Identité ────────────────────────────────────────────────
        'site_name'      => ['group' => 'branding', 'label' => 'Nom du site',            'type' => 'text',  'default' => 'C.F Divin Élevage',              'rules' => 'nullable|string|max:100', 'public' => true],
        'company_name'   => ['group' => 'branding', 'label' => 'Raison sociale',         'type' => 'text',  'default' => 'Centre de Formation Divin Élevage', 'rules' => 'nullable|string|max:150', 'public' => true],
        'logo_emoji'     => ['group' => 'branding', 'label' => 'Logo (emoji)',           'type' => 'text',  'default' => '🎓',                              'rules' => 'nullable|string|max:16',  'public' => true, 'help' => 'Emoji affiché dans le logo si aucune image n\'est fournie.'],
        'logo_image_url' => ['group' => 'branding', 'label' => 'Logo (URL image)',       'type' => 'image', 'default' => '',                               'rules' => 'nullable|string|max:300', 'public' => true, 'help' => 'Si renseignée, remplace l\'emoji par une image.'],
        'tagline'        => ['group' => 'branding', 'label' => 'Slogan court (sous le logo)', 'type' => 'text', 'default' => 'Centre de formation en élevage', 'rules' => 'nullable|string|max:120', 'public' => true],
        'slogan'         => ['group' => 'branding', 'label' => 'Slogan principal',       'type' => 'text',  'default' => 'La forge des leaders pour un élevage sain', 'rules' => 'nullable|string|max:200', 'public' => true],

        // ── Coordonnées ─────────────────────────────────────────────
        'phone1'         => ['group' => 'contact', 'label' => 'Téléphone 1',             'type' => 'text',     'default' => '060337821',                                 'rules' => 'nullable|string|max:30',  'public' => true],
        'phone2'         => ['group' => 'contact', 'label' => 'Téléphone 2',             'type' => 'text',     'default' => '076328536',                                 'rules' => 'nullable|string|max:30',  'public' => true],
        'whatsapp'       => ['group' => 'contact', 'label' => 'Numéro WhatsApp',         'type' => 'text',     'default' => '060337821',                                 'rules' => 'nullable|string|max:30',  'public' => true, 'help' => 'Format national (060337821) ou international (+241 60 33 78 21). Le zéro initial est retiré automatiquement pour le lien wa.me.'],
        'email'          => ['group' => 'contact', 'label' => 'Adresse email',           'type' => 'email',    'default' => 'divinformelevage@gmail.com',                'rules' => 'nullable|email|max:120',  'public' => true],
        'website'        => ['group' => 'contact', 'label' => 'Site web',                'type' => 'text',     'default' => 'www.divinform.com',                         'rules' => 'nullable|string|max:120', 'public' => true],
        'address'        => ['group' => 'contact', 'label' => 'Adresse (ligne 1)',       'type' => 'text',     'default' => 'C.F Divin Élevage',                         'rules' => 'nullable|string|max:200', 'public' => true],
        'address_detail' => ['group' => 'contact', 'label' => 'Adresse (ligne 2)',       'type' => 'text',     'default' => 'Gabon',                                     'rules' => 'nullable|string|max:200', 'public' => true],
        'wa_msg_default'   => ['group' => 'contact', 'label' => 'Message WhatsApp par défaut', 'type' => 'textarea', 'default' => 'Bonjour, je souhaite avoir des informations sur le centre de formation.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'wa_msg_formation' => ['group' => 'contact', 'label' => 'Message WhatsApp (inscription formation)', 'type' => 'textarea', 'default' => "Bonjour, je souhaite m'inscrire à la formation : {formation}. Pouvez-vous me communiquer les modalités ?", 'rules' => 'nullable|string|max:400', 'public' => true, 'help' => 'Utilisez {formation} pour insérer le titre de la formation et {session} pour la session choisie.'],
        'wa_msg_product'   => ['group' => 'contact', 'label' => 'Message WhatsApp (produit)',  'type' => 'textarea', 'default' => "Bonjour, je suis intéressé(e) par : {product}. Est-ce disponible et à quel prix ?", 'rules' => 'nullable|string|max:400', 'public' => true, 'help' => 'Utilisez {product} pour insérer le nom du produit.'],

        // ── Réseaux sociaux ─────────────────────────────────────────
        'facebook_url'  => ['group' => 'social', 'label' => 'Facebook',  'type' => 'url', 'default' => 'https://www.facebook.com/profile.php?id=61572106177650', 'rules' => 'nullable|string|max:200', 'public' => true],
        'tiktok_url'    => ['group' => 'social', 'label' => 'TikTok',    'type' => 'url', 'default' => 'https://www.tiktok.com/@user9655911945880',             'rules' => 'nullable|string|max:200', 'public' => true],
        'instagram_url' => ['group' => 'social', 'label' => 'Instagram', 'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'linkedin_url'  => ['group' => 'social', 'label' => 'LinkedIn',  'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'youtube_url'   => ['group' => 'social', 'label' => 'YouTube',   'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],

        // ── Hero / Bannière ─────────────────────────────────────────
        'hero_eyebrow'       => ['group' => 'hero', 'label' => 'Sur-titre (badge)',        'type' => 'text',     'default' => 'Centre de formation en élevage',                  'rules' => 'nullable|string|max:120', 'public' => true],
        'hero_title'         => ['group' => 'hero', 'label' => 'Titre — début',            'type' => 'text',     'default' => 'Apprenez le métier',                              'rules' => 'nullable|string|max:120', 'public' => true],
        'hero_highlight'     => ['group' => 'hero', 'label' => 'Titre — mot surligné (vert)', 'type' => 'text',  'default' => "d'éleveur",                                       'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_title_suffix'  => ['group' => 'hero', 'label' => 'Titre — suite',            'type' => 'text',     'default' => 'sur une vraie ferme-école',                       'rules' => 'nullable|string|max:160', 'public' => true],
        'hero_subtitle'      => ['group' => 'hero', 'label' => 'Sous-titre (paragraphe)',  'type' => 'textarea', 'default' => "Nos formations pratiques en élevage et en agriculture vous donnent les compétences et la confiance nécessaires pour lancer votre propre exploitation, quel que soit votre niveau de départ.", 'rules' => 'nullable|string|max:600', 'public' => true],
        'hero_cta_primary'   => ['group' => 'hero', 'label' => 'Bouton principal',         'type' => 'text',     'default' => '🎓 Découvrir nos formations',                     'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_cta_secondary' => ['group' => 'hero', 'label' => 'Bouton secondaire',        'type' => 'text',     'default' => '📞 Nous contacter',                               'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_image_url'     => ['group' => 'hero', 'label' => 'Image de fond (URL)',      'type' => 'image',    'default' => 'https://divinform.com/img/agriregenerative.jpg', 'rules' => 'nullable|string|max:400', 'public' => true],
        'hero_card_title'    => ['group' => 'hero', 'label' => 'Encart — titre',           'type' => 'text',     'default' => 'LA FERME-ÉCOLE',                                  'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_card_items' => [
            'group' => 'hero', 'label' => 'Encart — points clés', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Point',
            'fields' => [
                ['key' => 'label', 'label' => 'Intitulé', 'type' => 'text'],
            ],
            'default' => [
                ['label' => '🎓 Formations certifiantes'],
                ['label' => '🐄 Travaux pratiques'],
                ['label' => '📋 Accompagnement projet'],
                ['label' => '🤝 Suivi post-formation'],
            ],
        ],

        // ── Chiffres clés (liste) ───────────────────────────────────
        'stats' => [
            'group' => 'stats', 'label' => 'Chiffres clés (bannière)', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Chiffre',
            'fields' => [
                ['key' => 'num',   'label' => 'Valeur',  'type' => 'text'],
                ['key' => 'label', 'label' => 'Libellé', 'type' => 'text'],
            ],
            'default' => [
                ['num' => '6',      'label' => 'Formations au catalogue'],
                ['num' => '100%',   'label' => 'Pratique sur la ferme'],
                ['num' => '15 ans', 'label' => "D'expérience en élevage"],
                ['num' => '7j/7',   'label' => 'Accompagnement'],
            ],
        ],

        // ── Section « Nos formations » ──────────────────────────────
        'formations_eyebrow'  => ['group' => 'formations', 'label' => 'Sur-titre',   'type' => 'text',     'default' => 'Notre catalogue', 'rules' => 'nullable|string|max:120', 'public' => true],
        'formations_title'    => ['group' => 'formations', 'label' => 'Titre',       'type' => 'text',     'default' => 'Nos formations',  'rules' => 'nullable|string|max:160', 'public' => true],
        'formations_subtitle' => ['group' => 'formations', 'label' => 'Description', 'type' => 'textarea', 'default' => "Des formations courtes, concrètes et menées sur le terrain, pour apprendre un métier et vivre de son élevage.", 'rules' => 'nullable|string|max:400', 'public' => true],

        // ── Titres de sections ──────────────────────────────────────
        'categories_eyebrow'  => ['group' => 'sections', 'label' => 'La ferme — sur-titre',  'type' => 'text',     'default' => 'Notre ferme',                          'rules' => 'nullable|string|max:120', 'public' => true],
        'categories_title'    => ['group' => 'sections', 'label' => 'La ferme — titre',      'type' => 'text',     'default' => 'Les produits de la ferme',             'rules' => 'nullable|string|max:160', 'public' => true],
        'categories_subtitle' => ['group' => 'sections', 'label' => 'La ferme — description','type' => 'textarea', 'default' => "Notre ferme-école est une exploitation en activité. Les produits issus de nos ateliers pédagogiques sont proposés en vente directe.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'contact_eyebrow'     => ['group' => 'sections', 'label' => 'Contact — sur-titre',     'type' => 'text',     'default' => 'Contactez-nous',                        'rules' => 'nullable|string|max:120', 'public' => true],
        'contact_title'       => ['group' => 'sections', 'label' => 'Contact — titre',         'type' => 'text',     'default' => 'Une question sur nos formations ?',     'rules' => 'nullable|string|max:160', 'public' => true],
        'contact_subtitle'    => ['group' => 'sections', 'label' => 'Contact — description',   'type' => 'textarea', 'default' => "Notre équipe vous renseigne sur les programmes, les dates de session et les modalités d'inscription.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'cta_box_title'       => ['group' => 'sections', 'label' => 'Encart CTA — titre',      'type' => 'text',     'default' => 'Prêt à vous former ?',                  'rules' => 'nullable|string|max:160', 'public' => true],
        'cta_box_subtitle'    => ['group' => 'sections', 'label' => 'Encart CTA — sous-titre', 'type' => 'textarea', 'default' => 'Contactez-nous pour connaître les prochaines sessions et réserver votre place.', 'rules' => 'nullable|string|max:300', 'public' => true],

        // ── Pourquoi nous ───────────────────────────────────────────
        'why_eyebrow'  => ['group' => 'why', 'label' => 'Sur-titre',   'type' => 'text',     'default' => 'Notre pédagogie',                                                          'rules' => 'nullable|string|max:120', 'public' => true],
        'why_title'    => ['group' => 'why', 'label' => 'Titre',       'type' => 'text',     'default' => 'Pourquoi se former chez nous ?',                                            'rules' => 'nullable|string|max:160', 'public' => true],
        'why_subtitle' => ['group' => 'why', 'label' => 'Description', 'type' => 'textarea', 'default' => 'Une formation qui se vit sur le terrain, transmise par des éleveurs en activité.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'why_items' => [
            'group' => 'why', 'label' => 'Cartes « Pourquoi nous »', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Carte',
            'fields' => [
                ['key' => 'icon',  'label' => 'Icône (emoji)', 'type' => 'text'],
                ['key' => 'title', 'label' => 'Titre',         'type' => 'text'],
                ['key' => 'desc',  'label' => 'Description',    'type' => 'textarea'],
            ],
            'default' => [
                ['icon' => '🎓', 'title' => 'Une ferme-école',            'desc' => "Vous n'apprenez pas dans une salle : vous apprenez sur une ferme en activité, au contact des animaux."],
                ['icon' => '👨‍🌾', 'title' => 'Des formateurs éleveurs',   'desc' => "Nos formateurs vivent de leur élevage. Ils enseignent ce qu'ils pratiquent chaque jour."],
                ['icon' => '🔧', 'title' => 'De la pratique avant tout',  'desc' => 'La majorité du temps est consacrée aux travaux pratiques, pas à la théorie.'],
                ['icon' => '📋', 'title' => 'Un projet, pas un cours',    'desc' => "Chaque stagiaire repart avec un plan d'installation chiffré et adapté à ses moyens."],
                ['icon' => '🤝', 'title' => 'Un suivi après la formation','desc' => "Nous restons joignables pour vous accompagner dans vos premiers mois d'activité."],
                ['icon' => '🏅', 'title' => 'Une attestation reconnue',   'desc' => "Une attestation de fin de formation vous est remise à l'issue de chaque session."],
            ],
        ],

        // ── Pied de page ────────────────────────────────────────────
        'footer_about'     => ['group' => 'footer', 'label' => 'Texte « À propos »', 'type' => 'textarea', 'default' => "Centre de formation en élevage et en agriculture. Nous formons celles et ceux qui veulent vivre de la terre, sur une ferme-école en activité.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'copyright'        => ['group' => 'footer', 'label' => 'Mention copyright',  'type' => 'text',     'default' => '© {year} C.F Divin Élevage. Tous droits réservés.', 'rules' => 'nullable|string|max:200', 'public' => true, 'help' => 'Utilisez {year} pour l\'année courante.'],
        'footer_services'  => [
            'group' => 'footer', 'label' => 'Liste « Services »', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Service',
            'fields' => [
                ['key' => 'label', 'label' => 'Intitulé', 'type' => 'text'],
            ],
            'default' => [
                ['label' => 'Formations en élevage'],
                ['label' => 'Formations en agriculture'],
                ['label' => 'Accompagnement des porteurs de projet'],
                ['label' => 'Ferme-école & travaux pratiques'],
            ],
        ],

        // ── SEO ─────────────────────────────────────────────────────
        'meta_title'       => ['group' => 'seo', 'label' => 'Titre de la page (onglet navigateur)', 'type' => 'text',     'default' => 'C.F Divin Élevage — Centre de formation en élevage au Gabon', 'rules' => 'nullable|string|max:160', 'public' => true],
        'meta_description' => ['group' => 'seo', 'label' => 'Méta-description',                      'type' => 'textarea', 'default' => "Centre de formation en élevage et en agriculture au Gabon. Formations pratiques en aviculture, pisciculture, élevage porcin et cuniculture, sur une ferme-école en activité.", 'rules' => 'nullable|string|max:300', 'public' => true],
    ],
];
