<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FormationSeeder extends Seeder
{
    /**
     * Catalogue de formations du centre. Contenu de démarrage : le client
     * l'ajuste ensuite depuis le back-office (Formation → Formations).
     */
    public function run(): void
    {
        foreach ($this->formations() as $index => $data) {
            $sessions = $data['sessions'] ?? [];
            unset($data['sessions']);

            $data['slug']       = Str::slug($data['title']);
            $data['sort_order'] = $index + 1;

            $formation = Formation::firstOrCreate(['slug' => $data['slug']], $data);

            // Les sessions ne sont posées qu'à la création, pour ne pas
            // écraser le planning saisi par le centre.
            if ($formation->wasRecentlyCreated) {
                foreach ($sessions as $session) {
                    $formation->sessions()->create($session);
                }
            }
        }

        $this->command->info('Formations : ' . Formation::count() . ' en base.');
    }

    private function formations(): array
    {
        // Sessions calées sur des mois à venir plutôt que sur des dates figées.
        $in = fn (int $months) => now()->addMonths($months)->startOfMonth()->addDays(7)->toDateString();
        $to = fn (int $months, int $days) => now()->addMonths($months)->startOfMonth()->addDays(7 + $days)->toDateString();

        return [
            [
                'title'         => 'Élevage de poules pondeuses',
                'summary'       => 'Maîtrisez la conduite d\'un élevage de pondeuses rentable, de la poussinière à la commercialisation des œufs.',
                'description'   => "Une formation complète et pratique, menée sur notre ferme-école. Vous apprenez à installer un bâtiment adapté, à conduire un lot de pondeuses, à maîtriser l'alimentation et la prophylaxie, et à tenir une comptabilité simple pour piloter votre marge.",
                'level'         => 'debutant',
                'duration'      => '5 jours',
                'prerequisites' => 'Aucun prérequis. Savoir lire et écrire.',
                'objectives'    => [
                    'Concevoir et équiper un poulailler de pondeuses',
                    'Conduire un lot du démarrage à la réforme',
                    'Maîtriser le plan de prophylaxie et repérer les maladies courantes',
                    'Calculer son coût de revient et fixer son prix de vente',
                ],
                'program' => [
                    ['title' => 'Jour 1 — Les bases', 'detail' => 'Races, cycle de ponte, choix du bâtiment et des équipements.'],
                    ['title' => 'Jour 2 — Alimentation', 'detail' => 'Besoins nutritionnels, formulation, fabrication d\'aliment à la ferme.'],
                    ['title' => 'Jour 3 — Santé du troupeau', 'detail' => 'Prophylaxie, vaccination, biosécurité, maladies courantes.'],
                    ['title' => 'Jour 4 — Pratique', 'detail' => 'Travaux pratiques sur le poulailler de la ferme-école.'],
                    ['title' => 'Jour 5 — Gestion', 'detail' => 'Coût de revient, marge, commercialisation des œufs.'],
                ],
                'certification' => 'Attestation de fin de formation',
                'price'         => 75000,
                'badge'         => 'LA PLUS DEMANDÉE',
                'featured'      => true,
                'sessions'      => [
                    ['starts_on' => $in(1), 'ends_on' => $to(1, 4), 'location' => 'Ferme-école Divin Élevage', 'seats' => 20],
                    ['starts_on' => $in(3), 'ends_on' => $to(3, 4), 'location' => 'Ferme-école Divin Élevage', 'seats' => 20],
                ],
            ],
            [
                'title'         => 'Élevage de poulets de chair',
                'summary'       => 'Conduire une bande de poulets de chair en 45 jours, avec un indice de consommation maîtrisé.',
                'description'   => "De la réception des poussins à l'abattage, apprenez à conduire une bande rentable : densité, ambiance du bâtiment, courbe de croissance, prophylaxie et écoulement de la production.",
                'level'         => 'debutant',
                'duration'      => '4 jours',
                'prerequisites' => 'Aucun prérequis.',
                'objectives'    => [
                    'Préparer et démarrer une bande de poussins',
                    'Piloter l\'ambiance du bâtiment (température, ventilation, litière)',
                    'Suivre la croissance et l\'indice de consommation',
                    'Organiser l\'abattage et la vente',
                ],
                'program' => [
                    ['title' => 'Jour 1 — Le poussin', 'detail' => 'Réception, démarrage, ambiance de la poussinière.'],
                    ['title' => 'Jour 2 — Croissance', 'detail' => 'Alimentation par phase, suivi de poids, indice de consommation.'],
                    ['title' => 'Jour 3 — Santé & biosécurité', 'detail' => 'Programme sanitaire, prévention, gestion des mortalités.'],
                    ['title' => 'Jour 4 — Aval', 'detail' => 'Abattage, conditionnement, circuits de vente et marge.'],
                ],
                'certification' => 'Attestation de fin de formation',
                'price'         => 60000,
                'featured'      => true,
                'sessions'      => [
                    ['starts_on' => $in(2), 'ends_on' => $to(2, 3), 'location' => 'Ferme-école Divin Élevage', 'seats' => 20],
                ],
            ],
            [
                'title'         => 'Pisciculture — élevage de tilapias',
                'summary'       => 'Créer et conduire un élevage de tilapias en étang ou en bac hors-sol.',
                'description'   => "Une formation orientée terrain : implantation et construction des étangs, qualité de l'eau, alevinage, alimentation, suivi de croissance et récolte.",
                'level'         => 'intermediaire',
                'duration'      => '6 jours',
                'prerequisites' => 'Disposer d\'un terrain avec accès à l\'eau est un plus.',
                'objectives'    => [
                    'Choisir entre étang, bassin bétonné et bac hors-sol',
                    'Maîtriser la qualité de l\'eau et son suivi',
                    'Conduire l\'alevinage et le grossissement',
                    'Planifier la récolte et la commercialisation',
                ],
                'program' => [
                    ['title' => 'Module 1', 'detail' => 'Choix du site, dimensionnement, construction des ouvrages.'],
                    ['title' => 'Module 2', 'detail' => 'Qualité de l\'eau : oxygène, pH, température, transparence.'],
                    ['title' => 'Module 3', 'detail' => 'Alevinage, tri, densités de mise en charge.'],
                    ['title' => 'Module 4', 'detail' => 'Alimentation, croissance, prophylaxie.'],
                    ['title' => 'Module 5', 'detail' => 'Récolte, conservation, vente.'],
                ],
                'certification' => 'Attestation de fin de formation',
                'price'         => 90000,
                'badge'         => 'NOUVEAU',
                'sessions'      => [
                    ['starts_on' => $in(2), 'ends_on' => $to(2, 5), 'location' => 'Ferme-école Divin Élevage', 'seats' => 15],
                ],
            ],
            [
                'title'         => 'Élevage porcin',
                'summary'       => 'De la truie au porc charcutier : conduite d\'élevage, alimentation et gestion sanitaire.',
                'description'   => "Apprenez à conduire un atelier porcin naisseur-engraisseur : logement, reproduction, alimentation par stade physiologique, prophylaxie et valorisation de la production.",
                'level'         => 'intermediaire',
                'duration'      => '5 jours',
                'prerequisites' => 'Une première expérience en élevage est recommandée.',
                'objectives' => [
                    'Concevoir une porcherie fonctionnelle',
                    'Conduire la reproduction et la maternité',
                    'Alimenter selon le stade physiologique',
                    'Prévenir les principales pathologies',
                ],
                'program' => [
                    ['title' => 'Module 1', 'detail' => 'Races, logement, équipements.'],
                    ['title' => 'Module 2', 'detail' => 'Reproduction, gestation, mise bas, sevrage.'],
                    ['title' => 'Module 3', 'detail' => 'Alimentation et engraissement.'],
                    ['title' => 'Module 4', 'detail' => 'Santé, biosécurité, gestion des effluents.'],
                    ['title' => 'Module 5', 'detail' => 'Économie de l\'atelier et commercialisation.'],
                ],
                'certification' => 'Attestation de fin de formation',
                'price'         => 85000,
                'sessions'      => [
                    ['starts_on' => $in(4), 'ends_on' => $to(4, 4), 'location' => 'Ferme-école Divin Élevage', 'seats' => 15],
                ],
            ],
            [
                'title'         => 'Cuniculture — élevage de lapins',
                'summary'       => 'Un atelier accessible et rentable, idéal pour se lancer avec peu de capital.',
                'description'   => "Le lapin se prête bien à l'installation progressive. Cette formation couvre les clapiers, la reproduction, l'alimentation à base de ressources locales et la commercialisation.",
                'level'         => 'debutant',
                'duration'      => '3 jours',
                'prerequisites' => 'Aucun prérequis.',
                'objectives' => [
                    'Construire des clapiers à moindre coût',
                    'Conduire la reproduction et le sevrage',
                    'Valoriser les fourrages et sous-produits locaux',
                    'Écouler sa production',
                ],
                'program' => [
                    ['title' => 'Jour 1', 'detail' => 'Races, clapiers, matériel, installation.'],
                    ['title' => 'Jour 2', 'detail' => 'Reproduction, sevrage, alimentation.'],
                    ['title' => 'Jour 3', 'detail' => 'Santé, hygiène, abattage, vente.'],
                ],
                'certification' => 'Attestation de fin de formation',
                'price'         => 45000,
                'sessions'      => [
                    ['starts_on' => $in(1), 'ends_on' => $to(1, 2), 'location' => 'Ferme-école Divin Élevage', 'seats' => 25],
                ],
            ],
            [
                'title'         => 'Fabrication d\'aliment à la ferme',
                'summary'       => 'Formuler et produire son propre aliment pour réduire le premier poste de charge de l\'élevage.',
                'description'   => "L'aliment représente l'essentiel du coût de production. Cette formation technique vous apprend à formuler une ration équilibrée à partir des matières premières disponibles localement, et à produire votre aliment en toute sécurité.",
                'level'         => 'avance',
                'duration'      => '4 jours',
                'prerequisites' => 'Conduire déjà un atelier d\'élevage, ou avoir suivi une formation d\'élevage du centre.',
                'objectives' => [
                    'Connaître les matières premières et leur valeur nutritionnelle',
                    'Formuler une ration au moindre coût',
                    'Produire, stocker et conserver l\'aliment',
                    'Contrôler la qualité et éviter les contaminations',
                ],
                'program' => [
                    ['title' => 'Module 1', 'detail' => 'Besoins des animaux par espèce et par stade.'],
                    ['title' => 'Module 2', 'detail' => 'Matières premières locales : maïs, tourteaux, sons, minéraux.'],
                    ['title' => 'Module 3', 'detail' => 'Méthode de formulation et calcul du moindre coût.'],
                    ['title' => 'Module 4', 'detail' => 'Broyage, mélange, stockage, contrôle qualité.'],
                ],
                'certification' => 'Attestation de fin de formation',
                'price'         => null, // Nous consulter
                'badge'         => 'SUR MESURE',
                'sessions'      => [],
            ],
        ];
    }
}
