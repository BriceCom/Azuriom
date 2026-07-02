<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scratch_game_card_reward', function (Blueprint $table) {
            $table->unsignedInteger('card_id');
            $table->unsignedInteger('reward_id');

            $table->foreign('card_id')->references('id')->on('scratch_game_cards')->onDelete('cascade');
            $table->foreign('reward_id')->references('id')->on('scratch_game_rewards')->onDelete('cascade');

            $table->primary(['card_id', 'reward_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scratch_game_card_reward');
    }
};
