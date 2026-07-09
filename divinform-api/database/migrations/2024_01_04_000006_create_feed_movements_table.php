<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Un mouvement de stock. Une ration distribuée à une bande est simplement
     * un mouvement de type « sortie » portant un farm_batch_id : stocks et
     * alimentation partagent la même source de vérité, et l'indice de
     * consommation se calcule en sommant les sorties d'une bande.
     */
    public function up(): void
    {
        Schema::create('feed_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_item_id')->constrained('feed_items')->cascadeOnDelete();
            $table->foreignId('farm_batch_id')->nullable()->constrained('farm_batches')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('type', 12);              // entree|sortie|perte|ajustement
            $table->decimal('quantity', 12, 3);
            $table->decimal('qty_after', 12, 3);     // stock après le mouvement (piste d'audit)
            $table->unsignedInteger('unit_cost')->nullable();
            $table->date('occurred_on');
            $table->string('note', 255)->nullable();
            $table->timestamps();

            $table->index(['feed_item_id', 'occurred_on']);
            $table->index('farm_batch_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_movements');
    }
};
