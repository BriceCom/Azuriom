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
        Schema::create('tasks_task_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks_tasks')->cascadeOnDelete();
            $table->foreignId('related_task_id')->constrained('tasks_tasks')->cascadeOnDelete();

            $table->unique(['task_id', 'related_task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_task_relations');
    }
};
