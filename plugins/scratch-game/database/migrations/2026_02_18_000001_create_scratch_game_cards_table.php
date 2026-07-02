<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scratch_game_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cover_image')->nullable();
            $table->string('background_image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scratch_game_cards');
    }
};
