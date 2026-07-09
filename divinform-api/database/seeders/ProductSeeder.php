<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $imagerie   = Category::where('slug', 'imagerie-medicale')->first();
        $labo       = Category::where('slug', 'laboratoire-medical')->first();
        $mobilier   = Category::where('slug', 'mobilier-hospitalier')->first();

        $products = [
            // ── IMAGERIE ──────────────────────────────────────────────────
            [
                'category_id' => $imagerie->id,
                'name'        => 'Scanner Multidétecteur Haute Résolution',
                'slug'        => 'scanner-multidetecteur',
                'short_desc'  => 'Imagerie tomodensitométrique de pointe, coupes ultra-fines',
                'description' => 'Le scanner multidétecteur offre une résolution spatiale exceptionnelle avec des coupes de 0,5 mm. Idéal pour le diagnostic cardiovasculaire, pulmonaire et oncologique. Interface intuitive, faible dose de rayonnement et reconstruction 3D en temps réel.',
                'images'      => ['https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&q=80'],
                'badge'       => 'TOP VENTE',
                'badge_color' => '#2ECC71',
                'featured'    => true,
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Détecteurs',       'value' => '64 à 256 rangées'],
                    ['label' => 'Résolution',        'value' => '0,5 mm isotrope'],
                    ['label' => 'Vitesse rotation',  'value' => '0,27 s/rotation'],
                    ['label' => 'Tension',           'value' => '80 – 140 kV'],
                    ['label' => 'Garantie',          'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $imagerie->id,
                'name'        => 'IRM 1.5T / 3T Haute Performance',
                'slug'        => 'irm-1-5t-3t',
                'short_desc'  => 'IRM pour diagnostic neurologique et musculosquelettique',
                'description' => 'Système IRM dernière génération avec champ magnétique 1.5T ou 3T. Acquisition rapide, qualité d\'image supérieure, faible niveau sonore. Compatible avec les implants cardiaques de nouvelle génération.',
                'images'      => ['https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80'],
                'badge'       => 'NOUVEAU',
                'badge_color' => '#1A6FC4',
                'featured'    => true,
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Champ magnétique', 'value' => '1.5T ou 3T'],
                    ['label' => 'Bore',             'value' => '70 cm diamètre'],
                    ['label' => 'Gradient',         'value' => '45 mT/m'],
                    ['label' => 'Bruit',            'value' => '< 75 dB'],
                    ['label' => 'Garantie',         'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $imagerie->id,
                'name'        => 'Échographie Haute Définition',
                'slug'        => 'echographie-hd',
                'short_desc'  => 'Échographe polyvalent pour obstétrique et cardiologie',
                'description' => 'Plateforme d\'échographie polyvalente avec sondes multi-fréquences. Mode Doppler couleur, élastographie et imagerie 3D/4D. Connectivité DICOM complète.',
                'images'      => ['https://images.unsplash.com/photo-1666214280557-f1b5022eb634?w=800&q=80'],
                'sort_order'  => 3,
                'specs' => [
                    ['label' => 'Modes',        'value' => 'B, M, Doppler, 3D/4D'],
                    ['label' => 'Fréquence',    'value' => '1 – 15 MHz'],
                    ['label' => 'Connectivité', 'value' => 'DICOM, Wi-Fi, USB'],
                    ['label' => 'Écran',        'value' => '21,5" LCD LED'],
                    ['label' => 'Garantie',     'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $imagerie->id,
                'name'        => 'Radiologie Numérique Haute Qualité',
                'slug'        => 'radiologie-numerique',
                'short_desc'  => 'Radiographie numérique directe pour urgences et blocs',
                'description' => 'Détecteur numérique plat (FPD) avec traitement automatique des images. Réduction de 70% des doses de rayonnement par rapport à l\'analogique.',
                'images'      => ['https://images.unsplash.com/photo-1571772996211-2f02c9727629?w=800&q=80'],
                'sort_order'  => 4,
                'specs' => [
                    ['label' => 'Détecteur',      'value' => 'Amorphous Silicon FPD'],
                    ['label' => 'Résolution',      'value' => '3,4 lp/mm'],
                    ['label' => 'Réduction dose',  'value' => '70% vs analogique'],
                    ['label' => 'Format image',    'value' => 'DICOM 3.0'],
                    ['label' => 'Garantie',        'value' => '12 mois'],
                ],
            ],
            // ── LABORATOIRE ───────────────────────────────────────────────
            [
                'category_id' => $labo->id,
                'name'        => 'Analyseur Hématologique Automatisé',
                'slug'        => 'analyseur-hematologique',
                'short_desc'  => 'NFS, formule leucocytaire et réticulocytes complets',
                'description' => 'Automate de numération-formule sanguine avec 5 à 8 paramètres différentiels. Débit de 80 à 120 échantillons/heure. Alarmes morphologiques intelligentes.',
                'images'      => ['https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80'],
                'badge'       => 'TOP VENTE',
                'badge_color' => '#2ECC71',
                'featured'    => true,
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Paramètres', 'value' => '28 à 36 paramètres'],
                    ['label' => 'Débit',      'value' => '80 – 120 éch/h'],
                    ['label' => 'Volume',     'value' => '9 µL sang total'],
                    ['label' => 'CV%',        'value' => '< 2%'],
                    ['label' => 'Garantie',   'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $labo->id,
                'name'        => 'Analyseur de Biochimie Automatisé',
                'slug'        => 'analyseur-biochimie',
                'short_desc'  => 'Bilan métabolique, hépatique et rénal automatisé',
                'description' => 'Automate de biochimie polyvalent avec réactifs ouverts. Analyse de 400 à 800 tests/heure. Interface LIS/HIS compatible.',
                'images'      => ['https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80'],
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Débit',       'value' => '400 – 800 tests/h'],
                    ['label' => 'Réactifs',    'value' => 'Système ouvert'],
                    ['label' => 'Température', 'value' => '37 °C ± 0,1'],
                    ['label' => 'Connexion',   'value' => 'LIS/HIS'],
                    ['label' => 'Garantie',    'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $labo->id,
                'name'        => 'Centrifugeuse Réfrigérée',
                'slug'        => 'centrifugeuse-refrigeree',
                'short_desc'  => 'Centrifugation précise pour sérum et plasma',
                'description' => 'Centrifugeuse de paillasse réfrigérée (-20°C à +40°C) avec rotor interchangeable. Vitesse jusqu\'à 18 000 rpm, FCR jusqu\'à 30 000 × g.',
                'images'      => ['https://images.unsplash.com/photo-1576671081837-49000212a370?w=800&q=80'],
                'sort_order'  => 3,
                'specs' => [
                    ['label' => 'Vitesse max',  'value' => '18 000 rpm'],
                    ['label' => 'FCR max',      'value' => '30 000 × g'],
                    ['label' => 'Température',  'value' => '-20°C à +40°C'],
                    ['label' => 'Capacité',     'value' => '6 × 50 mL'],
                    ['label' => 'Garantie',     'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $labo->id,
                'name'        => 'Microscope Binoculaire Haute Précision',
                'slug'        => 'microscope-binoculaire',
                'short_desc'  => 'Microscopie avancée pour anatomopathologie',
                'description' => 'Microscope binoculaire avec optiques plan-achromatiques et éclairage LED à intensité variable. Grossissements de 40× à 1000×. Port caméra C-mount inclus.',
                'images'      => ['https://images.unsplash.com/photo-1628595351029-c2bf17511435?w=800&q=80'],
                'badge'       => 'NOUVEAU',
                'badge_color' => '#1A6FC4',
                'sort_order'  => 4,
                'specs' => [
                    ['label' => 'Grossissement', 'value' => '40× – 1000×'],
                    ['label' => 'Éclairage',     'value' => 'LED 3W variable'],
                    ['label' => 'Optiques',      'value' => 'Plan-achromatiques'],
                    ['label' => 'Caméra',        'value' => 'Port C-mount inclus'],
                    ['label' => 'Garantie',      'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $labo->id,
                'name'        => 'Système d\'Analyse d\'Urine',
                'slug'        => 'systeme-analyse-urine',
                'short_desc'  => 'Bandelettes et sédiment urinaire automatisés par IA',
                'description' => 'Automate d\'urinalyse avec module bandelette et sédiment intégrés. Classification automatique des éléments figurés par intelligence artificielle.',
                'images'      => ['https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&q=80'],
                'sort_order'  => 5,
                'specs' => [
                    ['label' => 'Débit',       'value' => '500 – 1000 éch/h'],
                    ['label' => 'Paramètres',  'value' => '10 – 14 paramètres'],
                    ['label' => 'Sédiment',    'value' => 'Classif. IA intégrée'],
                    ['label' => 'Connexion',   'value' => 'LIS bidirectionnel'],
                    ['label' => 'Garantie',    'value' => '12 mois'],
                ],
            ],
            // ── MOBILIER ──────────────────────────────────────────────────
            [
                'category_id' => $mobilier->id,
                'name'        => 'Table d\'Opération Électrique Multiposition',
                'slug'        => 'table-operation-electrique',
                'short_desc'  => 'Table chirurgicale motorisée plateau carbone radiotransparent',
                'description' => 'Table d\'opération à commande électrique avec plateau radiotransparent compatible avec l\'imagerie per-opératoire. Mouvements motorisés : Trendelenburg, flexion latérale.',
                'images'      => ['https://images.unsplash.com/photo-1551190822-a9333d879b1f?w=800&q=80'],
                'sort_order'  => 1,
                'specs' => [
                    ['label' => 'Charge max', 'value' => '250 kg'],
                    ['label' => 'Plateau',    'value' => 'Carbone radiotransparent'],
                    ['label' => 'Commande',   'value' => 'Filaire + télécommande'],
                    ['label' => 'Positions',  'value' => 'Trendelenburg ±30°'],
                    ['label' => 'Garantie',   'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $mobilier->id,
                'name'        => 'Lit Médicalisé à Hauteur Variable',
                'slug'        => 'lit-medicalise-hauteur-variable',
                'short_desc'  => 'Lit hospitalier motorisé pour soins intensifs',
                'description' => 'Lit médicalisé avec réglage motorisé de la hauteur, du dossier et des pieds. Barrières de sécurité escamotables, pèse-personne intégré.',
                'images'      => ['https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80'],
                'sort_order'  => 2,
                'specs' => [
                    ['label' => 'Hauteur plancher', 'value' => '35 – 80 cm'],
                    ['label' => 'Charge max',       'value' => '200 kg'],
                    ['label' => 'Pèse-personne',    'value' => 'Intégré ±1 kg'],
                    ['label' => 'Normes',           'value' => 'EN 60601-2-52'],
                    ['label' => 'Garantie',         'value' => '12 mois'],
                ],
            ],
            [
                'category_id' => $mobilier->id,
                'name'        => 'Chariot de Soins Inox Modulable',
                'slug'        => 'chariot-soins-inox',
                'short_desc'  => 'Chariot anti-corrosion pour bloc opératoire',
                'description' => 'Chariot de soins en acier inoxydable 304 avec plateaux amovibles et tiroirs sécurisés. Roues silencieuses avec freins, revêtement anti-bactérien certifié.',
                'images'      => ['https://images.unsplash.com/photo-1576671081837-49000212a370?w=800&q=80'],
                'sort_order'  => 3,
                'specs' => [
                    ['label' => 'Matériau',    'value' => 'Inox 304'],
                    ['label' => 'Plateaux',    'value' => '2 à 4 niveaux'],
                    ['label' => 'Charge totale','value' => '80 kg'],
                    ['label' => 'Revêtement',  'value' => 'Anti-bactérien certifié'],
                    ['label' => 'Garantie',    'value' => '12 mois'],
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

        $this->command->info('✅ 12 produits créés avec leurs spécifications.');
    }
}
