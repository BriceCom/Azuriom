<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->string('difficulty')->default('easy')->after('question');
            $table->unsignedInteger('time_limit')->nullable()->after('reward');
        });

        Schema::table('quiz_responses', function (Blueprint $table) {
            $table->string('status')->nullable()->after('answer_id');
            $table->json('reward_payload')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('quiz_responses', function (Blueprint $table) {
            $table->dropColumn(['status', 'reward_payload']);
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropColumn(['difficulty', 'time_limit']);
        });
    }
};
