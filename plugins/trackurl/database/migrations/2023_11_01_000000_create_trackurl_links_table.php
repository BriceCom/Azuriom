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
        Schema::create('trackurl_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_code')->unique();
            $table->text('destination_url');
            $table->unsignedInteger('user_id');
            $table->boolean('blocked')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackurl_links');
    }
};
