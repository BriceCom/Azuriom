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
        Schema::table('suggest_discord_webhook_settings', function (Blueprint $table) {
            // Custom colors for different webhook types
            $table->string('color_created')->default('#00ff00')->after('send_on_refuse');
            $table->string('color_accepted')->default('#0099ff')->after('color_created');
            $table->string('color_refused')->default('#ff0000')->after('color_accepted');

            // Custom text templates
            $table->text('template_created')->nullable()->after('color_refused');
            $table->text('template_accepted')->nullable()->after('template_created');
            $table->text('template_refused')->nullable()->after('template_accepted');

            // Custom webhook appearance
            $table->string('custom_username')->nullable()->after('template_refused');
            $table->string('custom_avatar_url')->nullable()->after('custom_username');

            // Content customization
            $table->boolean('show_author')->default(true)->after('custom_avatar_url');
            $table->boolean('show_category')->default(true)->after('show_author');
            $table->boolean('show_votes')->default(true)->after('show_category');
            $table->boolean('show_description')->default(true)->after('show_votes');

            // Advanced settings
            $table->integer('description_length')->default(200)->after('show_description');
            $table->json('custom_variables')->nullable()->after('description_length');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggest_discord_webhook_settings', function (Blueprint $table) {
            $table->dropColumn([
                'color_created',
                'color_accepted',
                'color_refused',
                'template_created',
                'template_accepted',
                'template_refused',
                'custom_username',
                'custom_avatar_url',
                'show_author',
                'show_category',
                'show_votes',
                'show_description',
                'description_length',
                'custom_variables'
            ]);
        });
    }
};
