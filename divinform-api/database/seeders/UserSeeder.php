<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@medex65.com'],
            [
                'name'     => 'Administrateur Principal',
                'password' => Hash::make('Admin@2025'),
                'role'     => 'super_admin',
                'active'   => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'products@medex65.com'],
            [
                'name'     => 'Gestionnaire Produits',
                'password' => Hash::make('Editor@2025'),
                'role'     => 'editor',
                'active'   => true,
            ]
        );

        $this->command->info('✅ Utilisateurs créés.');
    }
}
