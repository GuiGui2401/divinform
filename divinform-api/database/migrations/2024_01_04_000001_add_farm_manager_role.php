<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `role` était un enum MySQL : ajouter une valeur imposait une migration de
     * schéma. On passe en varchar, la liste faisant foi dans App\Models\User::ROLES
     * et dans la validation du contrôleur.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('editor')->change();
        });
    }

    public function down(): void
    {
        // Les comptes « fermier » deviendraient invalides : on les repasse en viewer.
        \Illuminate\Support\Facades\DB::table('users')
            ->where('role', 'farm_manager')
            ->update(['role' => 'viewer']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'editor', 'viewer'])->default('editor')->change();
        });
    }
};
