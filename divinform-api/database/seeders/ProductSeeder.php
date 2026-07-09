<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laitiers = Category::where('slug', 'produits-laitiers')->first();
        $viandes  = Category::where('slug', 'viandes-charcuterie')->first();
        $oeufs    = Category::where('slug', 'oeufs-volaille')->first();
        $animaux  = Category::where('slug', 'animaux-elevage')->first();
        $laine    = Category::where('slug', 'laine-fibres')->first();
        $visites  = Category::where('slug', 'visites-activites')->first();

        $img = fn ($file) => 'https://divinform.com/img/' . $file;

        $products = [
            // ── PRODUITS LAITIERS ─────────────────────────────────────────
            [
                'category_id' => $laitiers->id,
                'name'        => 'Lait Cru Fermier',
                'slug'        => 'lait-cru-fermier',
                'short_desc'  => 'Lait entier cru de nos vaches au pâturage, collecté chaque matin.',
                'description' => "Un lait entier cru, non pasteurisé, riche et onctueux, issu de nos vaches Montbéliardes nourries à l'herbe et au foin de la ferme. Idéal pour la consommation quotidienne, la fabrication de yaourts ou de fromages maison. Collecté et mis en bouteille chaque matin.",
                'images'      => [$img('lait.jpg')],
                'badge'       => 'FRAIS DU JOUR',
                'badge_color' => '#6BA83A',
                'featured'    => true,
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Origine',        'value' => 'Vaches Montbéliardes'],
                    ['label' => 'Conditionnement', 'value' => 'Bouteille verre 1 L'],
                    ['label' => 'Conservation',   'value' => '72 h à +4 °C'],
                    ['label' => 'Disponibilité',  'value' => "Toute l'année"],
                ],
            ],
            [
                'category_id' => $laitiers->id,
                'name'        => 'Beurre Fermier Baratté',
                'slug'        => 'beurre-fermier-baratte',
                'short_desc'  => 'Beurre baratté à l\'ancienne à partir de notre crème crue.',
                'description' => "Beurre fermier fabriqué à la baratte traditionnelle à partir de la crème de notre lait cru. Texture fondante, goût authentique de noisette. Disponible doux ou demi-sel au sel de Guérande. Fabrication artisanale en petites quantités.",
                'images'      => [$img('beurre.jpg')],
                'badge'       => 'ARTISANAL',
                'badge_color' => '#8B5E34',
                'featured'    => true,
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Fabrication',    'value' => 'Baratte traditionnelle'],
                    ['label' => 'Conditionnement', 'value' => 'Motte 250 g'],
                    ['label' => 'Goût',           'value' => 'Doux ou demi-sel'],
                    ['label' => 'Lait',           'value' => 'Cru non pasteurisé'],
                ],
            ],
            [
                'category_id' => $laitiers->id,
                'name'        => 'Fromage Fermier Affiné',
                'slug'        => 'fromage-fermier-affine',
                'short_desc'  => 'Tomme de vache à pâte pressée, affinée en cave à la ferme.',
                'description' => "Une tomme fermière à pâte pressée non cuite, fabriquée à partir de notre lait cru et affinée patiemment en cave sur planches d'épicéa pendant 3 à 6 mois. Croûte naturelle, pâte souple et fruitée.",
                'images'      => [$img('divin1.jpg')],
                'sort_order'  => 3,
                'specs' => [
                    ['label' => 'Type',     'value' => 'Pâte pressée non cuite'],
                    ['label' => 'Affinage', 'value' => '3 à 6 mois'],
                    ['label' => 'Lait',     'value' => 'Vache cru'],
                    ['label' => 'Poids',    'value' => '≈ 400 g'],
                ],
            ],

            // ── VIANDES & CHARCUTERIE ─────────────────────────────────────
            [
                'category_id' => $viandes->id,
                'name'        => 'Colis de Viande Bovine',
                'slug'        => 'colis-viande-bovine',
                'short_desc'  => 'Colis de bœuf fermier élevé à l\'herbe, vendu sur commande.',
                'description' => "Colis de viande bovine issue de nos animaux de race Charolaise, élevés en plein air et nourris à l'herbe. Viande maturée 3 semaines pour une tendreté et une saveur incomparables. Colis équilibrés (steaks, rôtis, bourguignon, hachés).",
                'images'      => [$img('viande.jpg')],
                'badge'       => 'SUR COMMANDE',
                'badge_color' => '#8B5E34',
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Race',       'value' => 'Charolaise'],
                    ['label' => 'Colis',      'value' => '5 ou 10 kg'],
                    ['label' => 'Élevage',    'value' => "Plein air, à l'herbe"],
                    ['label' => 'Maturation', 'value' => '3 semaines'],
                ],
            ],
            [
                'category_id' => $viandes->id,
                'name'        => 'Saucisses Fermières Artisanales',
                'slug'        => 'saucisses-fermieres',
                'short_desc'  => 'Saucisses de porc fermier assaisonnées aux herbes de la ferme.',
                'description' => "Saucisses fraîches préparées à la ferme à partir de notre porc fermier élevé sur paille. Assaisonnées avec les herbes aromatiques de notre jardin, sans conservateur ni additif. Parfaites au barbecue ou à la poêle.",
                'images'      => [$img('saucisse.jpg')],
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Base',           'value' => 'Porc fermier'],
                    ['label' => 'Conditionnement', 'value' => 'Barquette 500 g'],
                    ['label' => 'Assaisonnement', 'value' => 'Herbes de la ferme'],
                    ['label' => 'Conservation',   'value' => '5 jours à +4 °C'],
                ],
            ],

            // ── ŒUFS & VOLAILLE ───────────────────────────────────────────
            [
                'category_id' => $oeufs->id,
                'name'        => 'Œufs Frais Plein Air',
                'slug'        => 'oeufs-frais-plein-air',
                'short_desc'  => 'Œufs extra-frais de poules élevées en plein air.',
                'description' => "Œufs pondus par nos poules qui gambadent librement dans les prés. Coquille solide, jaune orangé et goût prononcé grâce à une alimentation naturelle complétée par nos céréales. Ramassés à la main chaque jour.",
                'images'      => [$img('oeuf.jpg')],
                'badge'       => 'PLEIN AIR',
                'badge_color' => '#D9A441',
                'featured'    => true,
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Élevage',        'value' => 'Poules plein air'],
                    ['label' => 'Conditionnement', 'value' => 'Boîte de 6 ou 12'],
                    ['label' => 'Calibre',        'value' => 'Moyen à gros'],
                    ['label' => 'Ramassage',      'value' => 'Quotidien'],
                ],
            ],
            [
                'category_id' => $oeufs->id,
                'name'        => 'Poulet Fermier',
                'slug'        => 'poulet-fermier',
                'short_desc'  => 'Poulet fermier élevé en plein air, croissance lente.',
                'description' => "Poulet fermier élevé en plein air pendant 100 jours minimum, nourri aux céréales de la ferme. Chair ferme et savoureuse, sans antibiotique. Prêt à cuire, vendu à l'unité selon disponibilité.",
                'images'      => [$img('vie4.jpg')],
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Type',         'value' => 'Poulet fermier'],
                    ['label' => 'Élevage',      'value' => 'Plein air, 100 jours'],
                    ['label' => 'Poids',        'value' => '1,5 – 2 kg'],
                    ['label' => 'Alimentation', 'value' => 'Céréales de la ferme'],
                ],
            ],

            // ── ANIMAUX D'ÉLEVAGE ─────────────────────────────────────────
            [
                'category_id' => $animaux->id,
                'name'        => 'Vache Montbéliarde',
                'slug'        => 'vache-montbeliarde',
                'short_desc'  => 'Vaches laitières de race Montbéliarde, conduite au pâturage.',
                'description' => "Le cœur de notre ferme : nos vaches laitières de race Montbéliarde, rustiques et dociles. Conduite en pâturage tournant sur nos prairies naturelles. Reproductrices et génisses disponibles pour l'élevage.",
                'images'      => [$img('vie1.jpg')],
                'badge'       => 'CHEPTEL',
                'badge_color' => '#4A7C2F',
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Race',    'value' => 'Montbéliarde'],
                    ['label' => 'Usage',   'value' => 'Lait & reproduction'],
                    ['label' => 'Conduite', 'value' => 'Pâturage tournant'],
                    ['label' => 'Statut',  'value' => 'Nées à la ferme'],
                ],
            ],
            [
                'category_id' => $animaux->id,
                'name'        => 'Brebis & Agneaux',
                'slug'        => 'brebis-agneaux',
                'short_desc'  => 'Troupeau de brebis élevées pour la laine et la viande.',
                'description' => "Notre troupeau de brebis pâture sur les coteaux de la ferme. Élevage extensif et respectueux du rythme des saisons. Agneaux et brebis disponibles selon la saison, pour la laine comme pour la viande.",
                'images'      => [$img('vie2.jpg')],
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Race',          'value' => 'Mérinos rustique'],
                    ['label' => 'Usage',         'value' => 'Laine & viande'],
                    ['label' => 'Conduite',      'value' => 'Plein air extensif'],
                    ['label' => 'Disponibilité', 'value' => 'Selon saison'],
                ],
            ],
            [
                'category_id' => $animaux->id,
                'name'        => 'Volailles de Basse-Cour',
                'slug'        => 'volailles-basse-cour',
                'short_desc'  => 'Poules, canards et oies élevés en liberté à la ferme.',
                'description' => "Notre basse-cour vivante : poules pondeuses, canards et oies évoluant librement autour de la ferme. Animaux rustiques élevés en plein air, pour les œufs comme pour la table.",
                'images'      => [$img('vie5.jpg')],
                'sort_order'  => 3,
                'specs' => [
                    ['label' => 'Espèces', 'value' => 'Poules, canards, oies'],
                    ['label' => 'Élevage', 'value' => 'Plein air en liberté'],
                    ['label' => 'Usage',   'value' => 'Œufs & viande'],
                    ['label' => 'Statut',  'value' => 'Cheptel de la ferme'],
                ],
            ],

            // ── LAINE & FIBRES ────────────────────────────────────────────
            [
                'category_id' => $laine->id,
                'name'        => 'Laine Brute Lavée',
                'slug'        => 'laine-brute-lavee',
                'short_desc'  => 'Laine naturelle de nos moutons, lavée et cardée à la ferme.',
                'description' => "Laine issue de la tonte de nos moutons, lavée à l'eau claire et cardée à la ferme. Fibre naturelle écrue, idéale pour le feutrage, le filage et l'isolation. Vendue à la toison ou au poids.",
                'images'      => [$img('laine.jpg')],
                'badge'       => 'NATUREL',
                'badge_color' => '#A3B18A',
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Origine',        'value' => 'Moutons de la ferme'],
                    ['label' => 'Conditionnement', 'value' => 'Toison ou 500 g'],
                    ['label' => 'Couleur',        'value' => 'Écru naturel'],
                    ['label' => 'Traitement',     'value' => 'Lavée et cardée'],
                ],
            ],

            // ── VISITES & ACTIVITÉS ───────────────────────────────────────
            [
                'category_id' => $visites->id,
                'name'        => 'Visite Guidée de la Ferme',
                'slug'        => 'visite-guidee-ferme',
                'short_desc'  => 'Découvrez le quotidien de la ferme et l\'agriculture régénérative.',
                'description' => "Venez découvrir les coulisses de notre ferme lors d'une visite guidée : rencontre avec les animaux, traite, prairies et pratiques d'agriculture régénérative. Une expérience idéale pour les familles et les écoles, suivie d'une dégustation de nos produits.",
                'images'      => [$img('agriregenerative.jpg')],
                'badge'       => 'NOUVEAU',
                'badge_color' => '#5B6E2F',
                'featured'    => true,
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Durée',       'value' => '1 h 30'],
                    ['label' => 'Public',      'value' => 'Familles, écoles'],
                    ['label' => 'Réservation', 'value' => 'Obligatoire'],
                    ['label' => 'Tarif',       'value' => 'Sur demande'],
                ],
            ],
            [
                'category_id' => $visites->id,
                'name'        => 'Panier Fermier de Saison',
                'slug'        => 'panier-fermier-saison',
                'short_desc'  => 'Assortiment hebdomadaire de nos produits, en vente directe.',
                'description' => "Chaque semaine, composez ou recevez un panier fermier avec le meilleur de la ferme : produits laitiers, œufs, viande et surprises de saison. Vente directe, retrait à la ferme. Le circuit court par excellence.",
                'images'      => [$img('modern1.jpg')],
                'badge'       => 'TOP VENTE',
                'badge_color' => '#6BA83A',
                'featured'    => true,
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Contenu',   'value' => 'Assortiment de saison'],
                    ['label' => 'Format',    'value' => 'Petit ou grand'],
                    ['label' => 'Retrait',   'value' => 'À la ferme'],
                    ['label' => 'Fréquence', 'value' => 'Hebdomadaire'],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $specs = $productData['specs'] ?? [];
            unset($productData['specs']);

            $product = Product::firstOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );

            if ($product->wasRecentlyCreated && ! empty($specs)) {
                foreach ($specs as $i => $spec) {
                    $product->specs()->create([
                        'label'      => $spec['label'],
                        'value'      => $spec['value'],
                        'sort_order' => $i,
                    ]);
                }
            }
        }

        $this->command->info('✅ Produits de la ferme créés avec leurs caractéristiques.');
    }
}
