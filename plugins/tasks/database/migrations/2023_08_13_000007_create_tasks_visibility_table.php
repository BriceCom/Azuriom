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
        Schema::create('tasks_visibility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks_tasks')->cascadeOnDelete();
            $table->unsignedInteger('role_id');

            $table->unique(['task_id', 'role_id']);

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_visibility');
    }
};
