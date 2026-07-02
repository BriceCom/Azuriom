<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scratch_game_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->decimal('chance', 5, 2)->default(100.00);
            $table->decimal('money', 10, 2)->nullable();
            $table->json('commands')->nullable();
            $table->boolean('need_online')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scratch_game_rewards');
    }
};
