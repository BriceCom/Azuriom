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
        Schema::create('tasks_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('status_id')->nullable()->constrained('tasks_statuses')->nullOnDelete();
            $table->unsignedInteger('author_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('limited_at')->nullable();
            $table->unsignedInteger('priority')->default(0);
            $table->boolean('is_private')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_tasks');
    }
};
