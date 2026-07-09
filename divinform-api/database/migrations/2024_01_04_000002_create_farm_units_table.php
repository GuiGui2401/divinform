<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farm_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 20)->default('autre'); // aviculture|pisciculture|porcin|cuniculture|autre
            $table->string('location', 150)->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farm_units');
    }
};
