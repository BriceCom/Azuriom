<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunt_user_daily', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hunt_id');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->integer('claims_count')->default(0);
            $table->decimal('money_received_today', 10, 2)->default(0);
            $table->dateTime('last_claim_at')->nullable();
            $table->dateTime('cooldown_until')->nullable();
            $table->timestamps();

            $table->foreign('hunt_id')->references('id')->on('hunt_hunts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['hunt_id', 'user_id', 'date']);
            $table->index(['user_id', 'date']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hunt_user_daily');
    }
};
