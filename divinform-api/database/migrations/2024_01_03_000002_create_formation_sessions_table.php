<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')
                  ->constrained('formations')
                  ->cascadeOnDelete();

            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->string('location', 200)->nullable();

            $table->unsignedSmallInteger('seats')->default(0);       // 0 = non plafonné
            $table->unsignedSmallInteger('seats_taken')->default(0);
            $table->boolean('registration_open')->default(true);
            $table->timestamps();

            $table->index(['formation_id', 'starts_on']);
            $table->index('registration_open');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_sessions');
    }
};
