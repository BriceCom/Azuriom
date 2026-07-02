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
        Schema::create('webhook_manager_webhook_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 20)->default('discord');
            $table->string('url', 2048);
            $table->string('bot_name', 80)->nullable();
            $table->string('bot_avatar', 2048)->nullable();
            $table->string('default_color', 7)->nullable();
            $table->timestamps();
        });

        Schema::create('webhook_manager_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('service_id')
                ->constrained('webhook_manager_webhook_services');
            $table->string('event')->index();
            $table->json('payload_template');
            $table->json('headers')->nullable();
            $table->string('secret')->nullable();
            $table->unsignedSmallInteger('timeout')->default(5);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('webhook_manager_webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_id')
                ->constrained('webhook_manager_webhooks')
                ->cascadeOnDelete();
            $table->string('event')->index();
            $table->json('payload_sent');
            $table->json('headers_sent')->nullable();
            $table->unsignedSmallInteger('response_status')->nullable();
            $table->text('response_body')->nullable();
            $table->timestamp('sent_at')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_manager_webhook_logs');
        Schema::dropIfExists('webhook_manager_webhooks');
        Schema::dropIfExists('webhook_manager_webhook_services');
    }
};
