<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scratch_game_logs', function (Blueprint $table) {
            $table->dateTime('claimed_at')->nullable()->after('user_agent');
            $table->index('claimed_at');
        });
    }

    public function down(): void
    {
        Schema::table('scratch_game_logs', function (Blueprint $table) {
            $table->dropIndex(['claimed_at']);
            $table->dropColumn('claimed_at');
        });
    }
};
