<?php

namespace Database\Seeders;

use App\Models\FarmAnimal;
use App\Models\FarmBatch;
use App\Models\FarmUnit;
use App\Models\FeedItem;
use App\Models\HealthEvent;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Jeu de DÉMONSTRATION pour la gestion de l'exploitation.
 *
 * Toutes les entrées sont suffixées « [DÉMO] » afin d'être reconnaissables.
 * Pour les retirer une fois l'outil pris en main :
 *
 *     php artisan tinker --execute="
 *       App\Models\FeedItem::where('name','like','%[DÉMO]%')->get()->each->delete();
 *       App\Models\FarmUnit::where('name','like','%[DÉMO]%')->get()->each->delete();
 *     "
 *
 * La suppression d'un atelier emporte ses bandes, animaux et événements
 * sanitaires (cascade) ; celle d'un aliment emporte ses mouvements.
 */
class FarmDemoSeeder extends Seeder
{
    private const TAG = ' [DÉMO]';

    public function run(): void
    {
        if (FarmUnit::where('name', 'like', '%[DÉMO]%')->exists()) {
            $this->command->warn('Jeu de démonstration déjà présent — rien à faire.');
            return;
        }

        // ── Ateliers ────────────────────────────────────────────
        $poulailler = FarmUnit::create([
            'name' => 'Poulailler 1' . self::TAG, 'type' => 'aviculture',
            'location' => 'Ferme-école', 'capacity' => 600, 'sort_order' => 1,
        ]);

        $bassin = FarmUnit::create([
            'name' => 'Bassin tilapia' . self::TAG, 'type' => 'pisciculture',
            'location' => 'Ferme-école', 'capacity' => 1200, 'sort_order' => 2,
        ]);

        $porcherie = FarmUnit::create([
            'name' => 'Porcherie' . self::TAG, 'type' => 'porcin',
            'location' => 'Ferme-école', 'capacity' => 40, 'sort_order' => 3,
        ]);

        // ── Bandes ──────────────────────────────────────────────
        // Rattachée au produit du catalogue s'il existe : la bande « disponible »
        // alimentera alors le stock vendable affiché sur la vitrine.
        $poulet = Product::where('slug', 'poulet-fermier')->first();

        $bande = FarmBatch::create([
            'farm_unit_id' => $poulailler->id,
            'product_id'   => $poulet?->id,
            'code'         => 'DEMO-B-001',
            'species'      => 'Poulet de chair',
            'breed'        => 'Cobb 500',
            'started_on'   => now()->subDays(32)->toDateString(),
            'expected_end_on' => now()->addDays(13)->toDateString(),
            'initial_qty'  => 500,
            'current_qty'  => 500,
            'avg_weight_g' => 1250,
            'status'       => 'en_cours',
            'notes'        => 'Bande de démonstration.',
        ]);

        FarmBatch::create([
            'farm_unit_id' => $bassin->id,
            'code'         => 'DEMO-B-002',
            'species'      => 'Tilapia',
            'started_on'   => now()->subDays(70)->toDateString(),
            'initial_qty'  => 1000,
            'current_qty'  => 1000,
            'status'       => 'en_cours',
        ]);

        // ── Animal identifié individuellement ───────────────────
        FarmAnimal::create([
            'farm_unit_id' => $porcherie->id,
            'tag'          => 'DEMO-TRUIE-01',
            'name'         => 'Bijou',
            'species'      => 'Porc',
            'breed'        => 'Large White',
            'sex'          => 'F',
            'born_on'      => now()->subMonths(20)->toDateString(),
            'entered_on'   => now()->subMonths(14)->toDateString(),
            'status'       => 'actif',
        ]);

        // ── Aliments & mouvements ───────────────────────────────
        $mais = FeedItem::create([
            'name' => 'Maïs concassé' . self::TAG, 'unit' => 'kg',
            'alert_threshold' => 50, 'unit_cost' => 350,
        ]);

        $provende = FeedItem::create([
            'name' => 'Provende démarrage' . self::TAG, 'unit' => 'kg',
            'alert_threshold' => 50, 'unit_cost' => 520,
        ]);

        // Réception initiale
        $mais->movements()->create([
            'type' => 'entree', 'quantity' => 500, 'qty_after' => 0,
            'occurred_on' => now()->subDays(30)->toDateString(),
            'note' => 'Réception fournisseur',
        ]);
        $provende->movements()->create([
            'type' => 'entree', 'quantity' => 60, 'qty_after' => 0,
            'occurred_on' => now()->subDays(30)->toDateString(),
        ]);

        // Rations distribuées à la bande de poulets, sur dix jours
        foreach (range(1, 10) as $i) {
            $mais->movements()->create([
                'type' => 'sortie', 'farm_batch_id' => $bande->id,
                'quantity' => 20, 'qty_after' => 0,
                'occurred_on' => now()->subDays(30 - $i)->toDateString(),
                'note' => 'Ration quotidienne',
            ]);
        }

        // La provende passe volontairement sous son seuil : l'alerte de
        // réapprovisionnement du tableau de bord est ainsi visible.
        $provende->movements()->create([
            'type' => 'sortie', 'farm_batch_id' => $bande->id,
            'quantity' => 45, 'qty_after' => 0,
            'occurred_on' => now()->subDays(20)->toDateString(),
        ]);

        // Le stock découle du rejeu de l'historique, jamais d'un incrément.
        $mais->recomputeStock();
        $provende->recomputeStock();

        // ── Suivi vétérinaire ───────────────────────────────────
        HealthEvent::create([
            'farm_batch_id' => $bande->id, 'type' => 'vaccination',
            'label' => 'Vaccination Newcastle', 'medicine' => 'Vaccin ND',
            'dose' => '1 goutte / sujet',
            'occurred_on' => now()->subDays(25)->toDateString(),
            'next_due_on' => now()->addDays(6)->toDateString(),
        ]);

        HealthEvent::create([
            'farm_batch_id' => $bande->id, 'type' => 'mortalite',
            'label' => 'Mortalité de démarrage', 'quantity' => 12,
            'occurred_on' => now()->subDays(28)->toDateString(),
            'note' => 'Coup de chaleur.',
        ]);

        // L'effectif vivant se dérive des mortalités enregistrées.
        $bande->recomputeHeadcount();

        $this->command->info('Démo ferme : 3 ateliers, 2 bandes, 1 animal, 2 aliments, 12 mouvements, 2 événements sanitaires.');
        $this->command->info("Effectif de la bande DEMO-B-001 : {$bande->fresh()->current_qty} / 500");
        $this->command->info("Stock maïs : {$mais->fresh()->current_qty} kg — provende : {$provende->fresh()->current_qty} kg (sous le seuil, alerte visible)");
    }
}
