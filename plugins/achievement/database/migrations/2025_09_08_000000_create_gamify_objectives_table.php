<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('achievement_objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('hook');
            $table->string('trigger');
            $table->unsignedInteger('amount');
            $table->text('description');
            $table->json('rewards')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_objectives');
    }
};
