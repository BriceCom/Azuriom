<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scratch_game_card_role', function (Blueprint $table) {
            $table->unsignedInteger('card_id');
            $table->unsignedInteger('role_id');

            $table->foreign('card_id')->references('id')->on('scratch_game_cards')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->primary(['card_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scratch_game_card_role');
    }
};
