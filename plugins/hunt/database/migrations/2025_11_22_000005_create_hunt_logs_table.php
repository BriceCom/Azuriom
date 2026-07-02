<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunt_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hunt_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('reward_id')->nullable();
            $table->decimal('money_received', 10, 2)->default(0);
            $table->json('commands_executed')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('hunt_id')->references('id')->on('hunt_hunts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reward_id')->references('id')->on('hunt_rewards')->onDelete('set null');

            $table->index(['hunt_id', 'user_id', 'created_at']);
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
            $table->index('session_id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hunt_logs');
    }
};
