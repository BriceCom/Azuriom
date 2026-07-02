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
        if (! Schema::hasTable('daily_reward_claims')) {
            Schema::create('daily_reward_claims', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('day_number');
                $table->unsignedInteger('streak_before');
                $table->unsignedInteger('streak_after');
                $table->json('rewards_snapshot')->nullable();
                $table->timestamp('claimed_at');
                $table->timestamps();

                $table->index(['user_id', 'claimed_at']);
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reward_claims');
    }
};
