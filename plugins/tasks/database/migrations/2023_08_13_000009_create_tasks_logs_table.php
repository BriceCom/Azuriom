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
        Schema::create('tasks_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks_tasks')->cascadeOnDelete();
            $table->string('action');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_logs');
    }
};
