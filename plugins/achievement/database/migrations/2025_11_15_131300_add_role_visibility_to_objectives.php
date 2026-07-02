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
        Schema::table('achievement_objectives', function (Blueprint $table) {
            $table->enum('visibility', ['public', 'role'])->default('public')->after('is_enabled');
        });

        Schema::create('achievement_objective_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('objective_id');
            $table->unsignedInteger('role_id');
            $table->timestamps();

            $table->foreign('objective_id')->references('id')->on('achievement_objectives')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unique(['objective_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_objective_roles');

        Schema::table('achievement_objectives', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
