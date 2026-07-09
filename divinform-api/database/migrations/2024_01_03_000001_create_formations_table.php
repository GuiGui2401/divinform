<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->string('summary', 300);
            $table->text('description')->nullable();

            // Pédagogie
            $table->string('level', 20)->default('debutant');   // debutant | intermediaire | avance
            $table->string('duration', 60)->nullable();          // « 5 jours », « 3 mois »…
            $table->text('prerequisites')->nullable();
            $table->json('objectives')->nullable();              // ["Objectif 1", …]
            $table->json('program')->nullable();                 // [{"title": …, "detail": …}]
            $table->string('certification', 150)->nullable();

            // Tarif : nullable = « nous consulter »
            $table->unsignedInteger('price')->nullable();
            $table->string('currency', 8)->default('FCFA');

            // Vitrine
            $table->json('images')->nullable();
            $table->string('badge', 30)->nullable();
            $table->string('badge_color', 10)->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('contact_count')->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['active', 'sort_order']);
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
