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
        Schema::create('suggest_comment_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('comment_id');
            $table->unsignedInteger('user_id');
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('suggest_suggestion_comments')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['comment_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_comment_votes');
    }
};
