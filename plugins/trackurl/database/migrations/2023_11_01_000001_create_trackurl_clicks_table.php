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
        Schema::create('trackurl_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('trackurl_links')->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackurl_clicks');
    }
};
