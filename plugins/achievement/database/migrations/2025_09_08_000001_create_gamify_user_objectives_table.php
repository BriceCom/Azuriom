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
        Schema::create('achievement_user_objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('objective_id');
            $table->unsignedInteger('progress')->default(0);
            $table->unsignedInteger('trophy_points')->default(0);
            $table->enum('status', ['in_progress', 'completed', 'claimed'])->default('in_progress');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('objective_id')->references('id')->on('achievement_objectives')->onDelete('cascade');

            $table->unique(['user_id', 'objective_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_user_objectives');
    }
};
