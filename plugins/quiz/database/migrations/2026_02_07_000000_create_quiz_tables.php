<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('question');
            $blueprint->integer('reward')->default(0);
            $blueprint->date('activation_date')->unique();
            $blueprint->boolean('is_active')->default(true);
            $blueprint->timestamps();
        });

        Schema::create('quiz_answers', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
            $blueprint->string('answer');
            $blueprint->boolean('is_correct')->default(false);
            $blueprint->timestamps();
        });

        Schema::create('quiz_responses', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedInteger('user_id');
            $blueprint->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
            $blueprint->foreignId('answer_id')->constrained('quiz_answers')->cascadeOnDelete();
            $blueprint->timestamps();

            $blueprint->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $blueprint->unique(['user_id', 'question_id']);
        });

        Schema::create('quiz_user_scores', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedInteger('user_id');
            $blueprint->integer('score')->default(0);
            $blueprint->timestamps();

            $blueprint->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $blueprint->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_user_scores');
        Schema::dropIfExists('quiz_responses');
        Schema::dropIfExists('quiz_answers');
        Schema::dropIfExists('quiz_questions');
    }
};
