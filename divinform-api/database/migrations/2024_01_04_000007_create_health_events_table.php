<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Suivi vétérinaire. Une mortalité est un événement de type « mortalite »
     * dont `quantity` décrémente l'effectif de la bande (ou passe l'animal
     * individuel en statut « mort »).
     */
    public function up(): void
    {
        Schema::create('health_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_batch_id')->nullable()->constrained('farm_batches')->cascadeOnDelete();
            $table->foreignId('farm_animal_id')->nullable()->constrained('farm_animals')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('type', 15);            // traitement|vaccination|visite|mortalite
            $table->string('label', 150);
            $table->string('medicine', 120)->nullable();
            $table->string('dose', 60)->nullable();
            $table->unsignedInteger('quantity')->nullable();  // nb d'animaux concernés (mortalité)

            $table->date('occurred_on');
            $table->date('next_due_on')->nullable();          // rappel de vaccination
            $table->date('withdrawal_until')->nullable();     // délai d'attente avant consommation

            $table->unsignedInteger('cost')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['type', 'occurred_on']);
            $table->index('farm_batch_id');
            $table->index('next_due_on');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_events');
    }
};
