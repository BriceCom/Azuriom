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
        Schema::create('suggest_suggestion_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('suggestion_id')->constrained('suggest_suggestions')->cascadeOnDelete();
            $table->unsignedInteger('author_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_suggestion_comments');
    }
};
