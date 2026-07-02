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
        Schema::create('suggest_discord_webhook_settings', function (Blueprint $table) {
            $table->id();
            $table->string('webhook_url')->nullable();
            $table->boolean('enabled')->default(false);
            $table->boolean('send_on_create')->default(false);
            $table->boolean('send_on_accept')->default(false);
            $table->boolean('send_on_refuse')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_discord_webhook_settings');
    }
};
