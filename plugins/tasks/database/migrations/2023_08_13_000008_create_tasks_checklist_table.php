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
        Schema::create('tasks_checklist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks_tasks')->cascadeOnDelete();
            $table->string('title');
            $table->boolean('completed')->default(false);
            $table->unsignedInteger('completed_by')->nullable();
            $table->timestamps();

            $table->foreign('completed_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_checklist');
    }
};
