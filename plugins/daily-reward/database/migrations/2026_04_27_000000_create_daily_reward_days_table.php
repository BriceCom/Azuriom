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
        if (! Schema::hasTable('daily_reward_days')) {
            Schema::create('daily_reward_days', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('day_number')->unique();
                $table->string('label')->nullable();
                $table->boolean('is_enabled')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reward_days');
    }
};
