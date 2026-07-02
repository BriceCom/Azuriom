<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scratch_game_cards', function (Blueprint $table) {
            $table->unsignedInteger('free_interval_hours')->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('scratch_game_cards', function (Blueprint $table) {
            $table->dropColumn('free_interval_hours');
        });
    }
};
