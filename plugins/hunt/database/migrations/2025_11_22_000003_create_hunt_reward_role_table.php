<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunt_reward_role', function (Blueprint $table) {
            $table->unsignedInteger('reward_id');
            $table->unsignedInteger('role_id');

            $table->foreign('reward_id')->references('id')->on('hunt_rewards')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->primary(['reward_id', 'role_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hunt_reward_role');
    }
};
