<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Comptes d'administration.
 *
 * Aucun mot de passe n'est écrit en dur : ils viennent de l'environnement,
 * ou sont générés aléatoirement et affichés UNE SEULE FOIS dans la console
 * de la personne qui lance le seeder.
 *
 *     ADMIN_PASSWORD='…' EDITOR_PASSWORD='…' php artisan db:seed --class=UserSeeder
 *
 * `firstOrCreate` ne touche jamais à un compte existant : relancer ce seeder
 * ne réinitialise aucun mot de passe.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createUser(
            email: env('ADMIN_EMAIL', 'admin@divinform.com'),
            name: 'Administrateur Principal',
            role: 'super_admin',
            password: env('ADMIN_PASSWORD'),
        );

        $this->createUser(
            email: env('EDITOR_EMAIL', 'gestion@divinform.com'),
            name: 'Gestionnaire du site',
            role: 'editor',
            password: env('EDITOR_PASSWORD'),
        );
    }

    private function createUser(string $email, string $name, string $role, ?string $password): void
    {
        if (User::where('email', $email)->exists()) {
            $this->command->line("  Compte déjà présent, inchangé : {$email}");
            return;
        }

        $generated = $password === null;
        $password ??= Str::password(16, symbols: false);

        User::create([
            'email'    => $email,
            'name'     => $name,
            'password' => Hash::make($password),
            'role'     => $role,
            'active'   => true,
        ]);

        $this->command->info("  Compte créé : {$email} ({$role})");

        if ($generated) {
            $this->command->warn("  Mot de passe généré : {$password}");
            $this->command->warn('  Notez-le maintenant : il ne sera plus jamais affiché.');
        }
    }
}
