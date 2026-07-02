<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunt_hunts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('priority')->default(0);
            $table->integer('max_per_day')->default(1);
            $table->integer('global_cap')->nullable();
            $table->decimal('spawn_rate', 5, 2)->default(10.00);
            $table->integer('cooldown_minutes')->default(30);
            $table->integer('spawn_delay_seconds')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hunt_hunts');
    }
};
