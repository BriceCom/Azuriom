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
        if (! Schema::hasTable('daily_reward_rewards')) {
            Schema::create('daily_reward_rewards', function (Blueprint $table) {
                $table->id();
                $table->foreignId('day_id')->constrained('daily_reward_days')->cascadeOnDelete();
                $table->string('name');
                $table->string('type', 32);
                $table->decimal('money', 10, 2)->nullable();
                $table->json('commands')->nullable();
                $table->boolean('need_online')->default(false);
                $table->boolean('is_enabled')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('daily_reward_reward_server')) {
            Schema::create('daily_reward_reward_server', function (Blueprint $table) {
                $table->unsignedBigInteger('reward_id');
                $table->unsignedInteger('server_id');
                $table->unique(['reward_id', 'server_id']);

                $table->foreign('reward_id')->references('id')->on('daily_reward_rewards')->cascadeOnDelete();
                $table->foreign('server_id')->references('id')->on('servers')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reward_reward_server');
        Schema::dropIfExists('daily_reward_rewards');
    }
};
