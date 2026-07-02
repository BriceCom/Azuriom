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
        if (! Schema::hasTable('daily_reward_user_states')) {
            Schema::create('daily_reward_user_states', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id')->unique();
                $table->unsignedInteger('streak_count')->default(0);
                $table->unsignedInteger('max_streak')->default(0);
                $table->unsignedInteger('next_day_number')->default(1);
                $table->timestamp('last_claim_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reward_user_states');
    }
};
