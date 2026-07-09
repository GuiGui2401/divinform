<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farm_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_unit_id')->constrained('farm_units')->cascadeOnDelete();

            // Bande rattachée à un produit du catalogue : le stock vendable du
            // produit est la somme des bandes « disponible » qui le visent.
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();

            $table->string('code', 40)->unique();
            $table->string('species', 60);
            $table->string('breed', 80)->nullable();

            $table->date('started_on');
            $table->date('expected_end_on')->nullable();

            $table->unsignedInteger('initial_qty');
            $table->unsignedInteger('current_qty');
            $table->unsignedInteger('avg_weight_g')->nullable();

            $table->string('status', 20)->default('en_cours'); // en_cours|disponible|termine
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['farm_unit_id', 'status']);
            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farm_batches');
    }
};
