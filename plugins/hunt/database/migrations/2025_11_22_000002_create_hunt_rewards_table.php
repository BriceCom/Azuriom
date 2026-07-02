<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunt_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('chances', 5, 2)->default(100.00);
            $table->decimal('money', 10, 2)->nullable();
            $table->json('commands')->nullable();
            $table->unsignedInteger('scratch_card_id')->nullable();
            $table->boolean('need_online')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('hunt_reward_hunt', function (Blueprint $table) {
            $table->unsignedInteger('reward_id');
            $table->unsignedInteger('hunt_id');

            $table->foreign('reward_id')->references('id')->on('hunt_rewards')->onDelete('cascade');
            $table->foreign('hunt_id')->references('id')->on('hunt_hunts')->onDelete('cascade');

            $table->primary(['reward_id', 'hunt_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hunt_reward_hunt');
        Schema::dropIfExists('hunt_rewards');
    }
};
