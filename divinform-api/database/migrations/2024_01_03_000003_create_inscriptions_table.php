<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();

            // On conserve la demande même si la formation est supprimée.
            $table->foreignId('formation_id')
                  ->nullable()
                  ->constrained('formations')
                  ->nullOnDelete();
            $table->foreignId('formation_session_id')
                  ->nullable()
                  ->constrained('formation_sessions')
                  ->nullOnDelete();

            // Titre figé au moment de la demande : reste lisible si la formation disparaît.
            $table->string('formation_title', 200)->nullable();

            $table->string('name', 120);
            $table->string('phone', 30);
            $table->string('email', 120)->nullable();
            $table->text('message')->nullable();

            $table->string('status', 20)->default('nouvelle'); // nouvelle|contactee|confirmee|annulee
            $table->text('admin_note')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('formation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
