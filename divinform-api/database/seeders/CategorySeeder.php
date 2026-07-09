<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Produits Laitiers',
                'slug'        => 'produits-laitiers',
                'icon'        => '🥛',
                'description' => 'Lait cru, beurre baratté et fromages fermiers issus de nos vaches élevées au pâturage.',
                'color'       => '#6BA83A',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Viandes & Charcuterie',
                'slug'        => 'viandes-charcuterie',
                'icon'        => '🥩',
                'description' => 'Viandes fermières et charcuterie artisanale de nos élevages respectueux du bien-être animal.',
                'color'       => '#8B5E34',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Œufs & Volaille',
                'slug'        => 'oeufs-volaille',
                'icon'        => '🥚',
                'description' => 'Œufs frais de poules élevées en plein air et volailles fermières nourries aux céréales.',
                'color'       => '#D9A441',
                'sort_order'  => 3,
            ],
            [
                'name'        => "Animaux d'Élevage",
                'slug'        => 'animaux-elevage',
                'icon'        => '🐄',
                'description' => 'Notre cheptel : vaches, brebis et volailles élevés dans le respect de la nature et des saisons.',
                'color'       => '#4A7C2F',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Laine & Fibres',
                'slug'        => 'laine-fibres',
                'icon'        => '🐑',
                'description' => 'Laine naturelle de nos moutons, lavée et cardée à la ferme pour vos travaux et créations.',
                'color'       => '#A3B18A',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Visites & Activités',
                'slug'        => 'visites-activites',
                'icon'        => '🚜',
                'description' => 'Visites de la ferme, vente directe et découverte de notre agriculture régénérative.',
                'color'       => '#5B6E2F',
                'sort_order'  => 6,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->command->info('✅ Catégories de la ferme créées.');
    }
}
