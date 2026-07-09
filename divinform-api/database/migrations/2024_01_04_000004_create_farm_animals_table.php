<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farm_animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_unit_id')->constrained('farm_units')->cascadeOnDelete();
            // Un individu peut être issu d'une bande (ex. truie gardée pour la reproduction).
            $table->foreignId('farm_batch_id')->nullable()->constrained('farm_batches')->nullOnDelete();

            $table->string('tag', 40)->unique();   // boucle / identifiant
            $table->string('name', 80)->nullable();
            $table->string('species', 60);
            $table->string('breed', 80)->nullable();
            $table->string('sex', 1)->nullable();  // M|F

            $table->date('born_on')->nullable();
            $table->date('entered_on')->nullable();

            $table->string('status', 20)->default('actif'); // actif|vendu|reforme|mort
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['farm_unit_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farm_animals');
    }
};
