<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120)->unique();
            $table->string('unit', 10)->default('kg');       // kg | sac | L
            $table->decimal('current_qty', 12, 3)->default(0);
            $table->decimal('alert_threshold', 12, 3)->default(0); // 0 = pas d'alerte
            $table->unsignedInteger('unit_cost')->nullable();      // FCFA par unité
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_items');
    }
};
