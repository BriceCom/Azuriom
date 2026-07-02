<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scratch_game_reward_server', function (Blueprint $table) {
            $table->unsignedInteger('reward_id');
            $table->unsignedInteger('server_id');

            $table->foreign('reward_id')->references('id')->on('scratch_game_rewards')->onDelete('cascade');
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');

            $table->primary(['reward_id', 'server_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scratch_game_reward_server');
    }
};
