<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('scratch_game_cards', 'free_interval_minutes')) {
            Schema::table('scratch_game_cards', function (Blueprint $table) {
                $table->unsignedInteger('free_interval_minutes')->nullable()->after('price');
            });
        }

        if (Schema::hasColumn('scratch_game_cards', 'free_interval_hours')) {
            DB::table('scratch_game_cards')
                ->whereNotNull('free_interval_hours')
                ->update([
                    'free_interval_minutes' => DB::raw('free_interval_hours * 60'),
                ]);

            Schema::table('scratch_game_cards', function (Blueprint $table) {
                $table->dropColumn('free_interval_hours');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('scratch_game_cards', 'free_interval_hours')) {
            Schema::table('scratch_game_cards', function (Blueprint $table) {
                $table->unsignedInteger('free_interval_hours')->nullable()->after('price');
            });
        }

        if (Schema::hasColumn('scratch_game_cards', 'free_interval_minutes')) {
            DB::table('scratch_game_cards')
                ->whereNotNull('free_interval_minutes')
                ->update([
                    'free_interval_hours' => DB::raw('FLOOR(free_interval_minutes / 60)'),
                ]);

            Schema::table('scratch_game_cards', function (Blueprint $table) {
                $table->dropColumn('free_interval_minutes');
            });
        }
    }
};
