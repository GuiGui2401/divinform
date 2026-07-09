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
                'name'        => 'Imagerie Médicale',
                'slug'        => 'imagerie-medicale',
                'icon'        => '🫀',
                'description' => 'Équipements d\'imagerie haute performance pour un diagnostic précis',
                'color'       => '#1A6FC4',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Laboratoire Médical',
                'slug'        => 'laboratoire-medical',
                'icon'        => '🔬',
                'description' => 'Solutions complètes pour l\'analyse biologique et clinique',
                'color'       => '#27AE60',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Mobilier Hospitalier',
                'slug'        => 'mobilier-hospitalier',
                'icon'        => '🏥',
                'description' => 'Équipements ergonomiques et certifiés pour les espaces de soins',
                'color'       => '#0A3D8F',
                'sort_order'  => 3,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->command->info('✅ Catégories créées.');
    }
}
