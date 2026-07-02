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
        Schema::create('suggest_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suggestion_id')->constrained('suggest_suggestions')->cascadeOnDelete();
            $table->unsignedInteger('user_id');
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_votes');
    }
};
