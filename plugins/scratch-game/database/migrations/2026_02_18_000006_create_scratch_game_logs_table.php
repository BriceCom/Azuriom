<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scratch_game_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('card_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('reward_id')->nullable();
            $table->decimal('price_paid', 10, 2)->default(0);
            $table->decimal('money_given', 10, 2)->default(0);
            $table->json('commands_executed')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('scratch_game_cards')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reward_id')->references('id')->on('scratch_game_rewards')->onDelete('set null');

            $table->index(['card_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scratch_game_logs');
    }
};
