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
        'site_name'      => ['group' => 'branding', 'label' => 'Nom du site',            'type' => 'text',  'default' => 'Ferme Divinform',                'rules' => 'nullable|string|max:100', 'public' => true],
        'company_name'   => ['group' => 'branding', 'label' => 'Raison sociale',         'type' => 'text',  'default' => 'Ferme Divinform',                'rules' => 'nullable|string|max:150', 'public' => true],
        'logo_emoji'     => ['group' => 'branding', 'label' => 'Logo (emoji)',           'type' => 'text',  'default' => '🌾',                              'rules' => 'nullable|string|max:16',  'public' => true, 'help' => 'Emoji affiché dans le logo si aucune image n\'est fournie.'],
        'logo_image_url' => ['group' => 'branding', 'label' => 'Logo (URL image)',       'type' => 'image', 'default' => '',                               'rules' => 'nullable|string|max:300', 'public' => true, 'help' => 'Si renseignée, remplace l\'emoji par une image.'],
        'tagline'        => ['group' => 'branding', 'label' => 'Slogan court (sous le logo)', 'type' => 'text', 'default' => 'Le bon, le vrai, le fermier', 'rules' => 'nullable|string|max:120', 'public' => true],
        'slogan'         => ['group' => 'branding', 'label' => 'Slogan principal',       'type' => 'text',  'default' => 'Le meilleur de la ferme, en vente directe', 'rules' => 'nullable|string|max:200', 'public' => true],

        // ── Coordonnées ─────────────────────────────────────────────
        'phone1'         => ['group' => 'contact', 'label' => 'Téléphone 1',             'type' => 'text',     'default' => '+237 696 809 909',                          'rules' => 'nullable|string|max:30',  'public' => true],
        'phone2'         => ['group' => 'contact', 'label' => 'Téléphone 2',             'type' => 'text',     'default' => '+237 696 534 179',                          'rules' => 'nullable|string|max:30',  'public' => true],
        'whatsapp'       => ['group' => 'contact', 'label' => 'Numéro WhatsApp (sans +)','type' => 'text',     'default' => '237696809909',                              'rules' => 'nullable|string|max:30',  'public' => true],
        'email'          => ['group' => 'contact', 'label' => 'Adresse email',           'type' => 'email',    'default' => 'contact@divinform.com',                     'rules' => 'nullable|email|max:120',  'public' => true],
        'website'        => ['group' => 'contact', 'label' => 'Site web',                'type' => 'text',     'default' => 'www.divinform.com',                         'rules' => 'nullable|string|max:120', 'public' => true],
        'address'        => ['group' => 'contact', 'label' => 'Adresse (ligne 1)',       'type' => 'text',     'default' => 'Ferme Divinform',                           'rules' => 'nullable|string|max:200', 'public' => true],
        'address_detail' => ['group' => 'contact', 'label' => 'Adresse (ligne 2)',       'type' => 'text',     'default' => 'Vente directe à la ferme',                  'rules' => 'nullable|string|max:200', 'public' => true],
        'wa_msg_default' => ['group' => 'contact', 'label' => 'Message WhatsApp par défaut', 'type' => 'textarea', 'default' => 'Bonjour, je souhaite avoir des informations sur vos produits de la ferme.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'wa_msg_product' => ['group' => 'contact', 'label' => 'Message WhatsApp (produit)',  'type' => 'textarea', 'default' => "Bonjour, je suis intéressé(e) par : {product}. Est-ce disponible et à quel prix ?", 'rules' => 'nullable|string|max:400', 'public' => true, 'help' => 'Utilisez {product} pour insérer le nom du produit.'],

        // ── Réseaux sociaux ─────────────────────────────────────────
        'facebook_url'  => ['group' => 'social', 'label' => 'Facebook',  'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'instagram_url' => ['group' => 'social', 'label' => 'Instagram', 'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'linkedin_url'  => ['group' => 'social', 'label' => 'LinkedIn',  'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],
        'youtube_url'   => ['group' => 'social', 'label' => 'YouTube',   'type' => 'url', 'default' => '', 'rules' => 'nullable|string|max:200', 'public' => true],

        // ── Hero / Bannière ─────────────────────────────────────────
        'hero_eyebrow'       => ['group' => 'hero', 'label' => 'Sur-titre (badge)',        'type' => 'text',     'default' => 'Produits fermiers en vente directe',             'rules' => 'nullable|string|max:120', 'public' => true],
        'hero_title'         => ['group' => 'hero', 'label' => 'Titre — début',            'type' => 'text',     'default' => 'Le meilleur',                                     'rules' => 'nullable|string|max:120', 'public' => true],
        'hero_highlight'     => ['group' => 'hero', 'label' => 'Titre — mot surligné (vert)', 'type' => 'text',  'default' => 'de la ferme',                                     'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_title_suffix'  => ['group' => 'hero', 'label' => 'Titre — suite',            'type' => 'text',     'default' => 'du producteur à votre table',                     'rules' => 'nullable|string|max:160', 'public' => true],
        'hero_subtitle'      => ['group' => 'hero', 'label' => 'Sous-titre (paragraphe)',  'type' => 'textarea', 'default' => 'La Ferme Divinform vous propose ses produits laitiers, viandes, œufs et bien plus, issus d\'un élevage respectueux du bien-être animal et d\'une agriculture régénérative.', 'rules' => 'nullable|string|max:600', 'public' => true],
        'hero_cta_primary'   => ['group' => 'hero', 'label' => 'Bouton principal',         'type' => 'text',     'default' => '🧺 Découvrir nos produits',                       'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_cta_secondary' => ['group' => 'hero', 'label' => 'Bouton secondaire',        'type' => 'text',     'default' => '📞 Nous contacter',                               'rules' => 'nullable|string|max:60',  'public' => true],
        'hero_image_url'     => ['group' => 'hero', 'label' => 'Image de fond (URL)',      'type' => 'image',    'default' => 'https://divinform.com/img/agriregenerative.jpg', 'rules' => 'nullable|string|max:400', 'public' => true],
        'guarantee_months'   => ['group' => 'hero', 'label' => 'Garantie fraîcheur (jours)', 'type' => 'number', 'default' => '0',                                               'rules' => 'nullable|integer|min:0|max:120', 'public' => true],

        // ── Chiffres clés (liste) ───────────────────────────────────
        'stats' => [
            'group' => 'stats', 'label' => 'Chiffres clés (bannière)', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Chiffre',
            'fields' => [
                ['key' => 'num',   'label' => 'Valeur',  'type' => 'text'],
                ['key' => 'label', 'label' => 'Libellé', 'type' => 'text'],
            ],
            'default' => [
                ['num' => '100%',    'label' => 'Fermier & naturel'],
                ['num' => '15 ans',  'label' => "D'élevage passionné"],
                ['num' => '0',       'label' => 'Intermédiaire'],
                ['num' => '7j/7',    'label' => 'Vente à la ferme'],
            ],
        ],

        // ── Titres de sections ──────────────────────────────────────
        'categories_eyebrow'  => ['group' => 'sections', 'label' => 'Catégories — sur-titre',  'type' => 'text',     'default' => 'Nos univers',                           'rules' => 'nullable|string|max:120', 'public' => true],
        'categories_title'    => ['group' => 'sections', 'label' => 'Catégories — titre',      'type' => 'text',     'default' => 'Les produits de la ferme',              'rules' => 'nullable|string|max:160', 'public' => true],
        'categories_subtitle' => ['group' => 'sections', 'label' => 'Catégories — description','type' => 'textarea', 'default' => "Des produits laitiers aux visites de la ferme, découvrez tout ce que la Ferme Divinform a à offrir, en circuit court.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'contact_eyebrow'     => ['group' => 'sections', 'label' => 'Contact — sur-titre',     'type' => 'text',     'default' => 'Contactez-nous',                        'rules' => 'nullable|string|max:120', 'public' => true],
        'contact_title'       => ['group' => 'sections', 'label' => 'Contact — titre',         'type' => 'text',     'default' => 'Envie de produits fermiers ?',          'rules' => 'nullable|string|max:160', 'public' => true],
        'contact_subtitle'    => ['group' => 'sections', 'label' => 'Contact — description',   'type' => 'textarea', 'default' => "Notre équipe est à votre disposition pour vos commandes, la vente directe et l'organisation de vos visites à la ferme.", 'rules' => 'nullable|string|max:400', 'public' => true],
        'cta_box_title'       => ['group' => 'sections', 'label' => 'Encart CTA — titre',      'type' => 'text',     'default' => 'Envie de goûter à la ferme ?',          'rules' => 'nullable|string|max:160', 'public' => true],
        'cta_box_subtitle'    => ['group' => 'sections', 'label' => 'Encart CTA — sous-titre', 'type' => 'textarea', 'default' => 'Contactez-nous dès maintenant pour vos commandes et la réservation de votre panier fermier.', 'rules' => 'nullable|string|max:300', 'public' => true],

        // ── Pourquoi nous ───────────────────────────────────────────
        'why_eyebrow'  => ['group' => 'why', 'label' => 'Sur-titre',   'type' => 'text',     'default' => 'Nos engagements',                                                          'rules' => 'nullable|string|max:120', 'public' => true],
        'why_title'    => ['group' => 'why', 'label' => 'Titre',       'type' => 'text',     'default' => 'Pourquoi choisir la Ferme Divinform ?',                                     'rules' => 'nullable|string|max:160', 'public' => true],
        'why_subtitle' => ['group' => 'why', 'label' => 'Description', 'type' => 'textarea', 'default' => 'Des produits sains et savoureux, issus d\'un élevage responsable et d\'un circuit ultra-court.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'why_items' => [
            'group' => 'why', 'label' => 'Cartes « Pourquoi nous »', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Carte',
            'fields' => [
                ['key' => 'icon',  'label' => 'Icône (emoji)', 'type' => 'text'],
                ['key' => 'title', 'label' => 'Titre',         'type' => 'text'],
                ['key' => 'desc',  'label' => 'Description',    'type' => 'textarea'],
            ],
            'default' => [
                ['icon' => '🌿', 'title' => '100% naturel',          'desc' => 'Des produits sans additif ni conservateur, issus d\'une agriculture régénérative respectueuse des sols.'],
                ['icon' => '🐄', 'title' => 'Bien-être animal',      'desc' => 'Nos animaux sont élevés en plein air, au pâturage, dans le respect de leur rythme naturel.'],
                ['icon' => '🧺', 'title' => 'Vente directe',         'desc' => 'Du producteur à votre table : circuit court, sans intermédiaire et au juste prix.'],
                ['icon' => '🌱', 'title' => 'Fraîcheur garantie',    'desc' => 'Lait, œufs et produits récoltés et préparés chaque jour à la ferme.'],
                ['icon' => '👨‍🌾', 'title' => 'Savoir-faire fermier', 'desc' => 'Un savoir-faire artisanal cultivé avec passion au fil des saisons.'],
                ['icon' => '🤝', 'title' => 'Circuit local',         'desc' => "Nous privilégions les clients de notre région pour un impact durable et solidaire."],
            ],
        ],

        // ── Pied de page ────────────────────────────────────────────
        'footer_about'     => ['group' => 'footer', 'label' => 'Texte « À propos »', 'type' => 'textarea', 'default' => 'La Ferme Divinform, votre ferme en vente directe. Produits laitiers, viandes, œufs et bien plus, issus d\'un élevage naturel et respectueux.', 'rules' => 'nullable|string|max:400', 'public' => true],
        'copyright'        => ['group' => 'footer', 'label' => 'Mention copyright',  'type' => 'text',     'default' => '© {year} Ferme Divinform. Tous droits réservés.', 'rules' => 'nullable|string|max:200', 'public' => true, 'help' => 'Utilisez {year} pour l\'année courante.'],
        'footer_services'  => [
            'group' => 'footer', 'label' => 'Liste « Services »', 'type' => 'list', 'public' => true, 'rules' => 'nullable|array',
            'item_label' => 'Service',
            'fields' => [
                ['key' => 'label', 'label' => 'Intitulé', 'type' => 'text'],
            ],
            'default' => [
                ['label' => 'Vente directe à la ferme'],
                ['label' => 'Paniers fermiers'],
                ['label' => 'Visites & activités'],
                ['label' => 'Livraison locale'],
            ],
        ],

        // ── SEO ─────────────────────────────────────────────────────
        'meta_title'       => ['group' => 'seo', 'label' => 'Titre de la page (onglet navigateur)', 'type' => 'text',     'default' => 'Ferme Divinform — Produits fermiers en vente directe', 'rules' => 'nullable|string|max:160', 'public' => true],
        'meta_description' => ['group' => 'seo', 'label' => 'Méta-description',                      'type' => 'textarea', 'default' => 'Ferme Divinform — produits laitiers, viandes, œufs et produits fermiers issus d\'un élevage naturel. Vente directe du producteur au consommateur.', 'rules' => 'nullable|string|max:300', 'public' => true],
    ],
];
