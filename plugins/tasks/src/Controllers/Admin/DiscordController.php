<?php

namespace Azuriom\Plugin\Tasks\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tasks\Models\DiscordWebhookSetting;
use Azuriom\Plugin\Tasks\Requests\DiscordWebhookRequest;
use Azuriom\Plugin\Tasks\Requests\DiscordWebhookTestRequest;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    /**
     * Display the Discord webhook configuration page.
     */
    public function index()
    {
        $discordSettings = DiscordWebhookSetting::getInstance();

        return view('tasks::admin.discord', [
            'discord' => $discordSettings,
        ]);
    }

    /**
     * Update the Discord webhook configuration.
     */
    public function update(DiscordWebhookRequest $request)
    {
        $validated = $request->validated();

        $discordSettings = DiscordWebhookSetting::getInstance();
        $discordSettings->update([
            'enabled' => $request->has('discord_enabled'),
            'webhook_url' => $validated['discord_webhook_url'] ?? null,
            'webhook_url_created' => $validated['discord_webhook_url_created'] ?? null,
            'webhook_url_started' => $validated['discord_webhook_url_started'] ?? null,
            'webhook_url_completed' => $validated['discord_webhook_url_completed'] ?? null,
            'webhook_url_archived' => $validated['discord_webhook_url_archived'] ?? null,
            'webhook_url_comment' => $validated['discord_webhook_url_comment'] ?? null,
            'webhook_url_logs' => $validated['discord_webhook_url_logs'] ?? null,
            'send_on_created' => $validated['discord_send_on_created'] ?? false,
            'send_on_started' => $validated['discord_send_on_started'] ?? false,
            'send_on_completed' => $validated['discord_send_on_completed'] ?? false,
            'send_on_archived' => $validated['discord_send_on_archived'] ?? false,
            'send_on_comment' => $validated['discord_send_on_comment'] ?? false,
            'send_on_logs' => $validated['discord_send_on_logs'] ?? false,
            'color_created' => $validated['discord_color_created'] ?? '#00ff00',
            'color_started' => $validated['discord_color_started'] ?? '#0099ff',
            'color_completed' => $validated['discord_color_completed'] ?? '#00ff00',
            'color_archived' => $validated['discord_color_archived'] ?? '#666666',
            'color_comment' => $validated['discord_color_comment'] ?? '#ff9900',
            'color_logs' => $validated['discord_color_logs'] ?? '#ff00ff',
            'template_created' => $validated['discord_template_created'] ?? null,
            'template_started' => $validated['discord_template_started'] ?? null,
            'template_completed' => $validated['discord_template_completed'] ?? null,
            'template_archived' => $validated['discord_template_archived'] ?? null,
            'template_comment' => $validated['discord_template_comment'] ?? null,
            'template_logs' => $validated['discord_template_logs'] ?? null,
            'custom_username' => $validated['discord_custom_username'] ?? null,
            'custom_avatar_url' => $validated['discord_custom_avatar_url'] ?? null,
            'show_author' => $validated['discord_show_author'] ?? true,
            'show_assignees' => $validated['discord_show_assignees'] ?? true,
            'show_tags' => $validated['discord_show_tags'] ?? true,
            'show_description' => $validated['discord_show_description'] ?? true,
            'description_length' => $validated['discord_description_length'] ?? 200,
        ]);

        return redirect()->route('tasks.admin.discord.index')
            ->with('success', trans('admin.settings.updated'));
    }

    /**
     * Test the Discord webhook.
     */
    public function testWebhook(DiscordWebhookTestRequest $request)
    {
        $webhookUrl = $request->input('webhook_url');

        try {
            $embed = Embed::create()
                ->title('Test Webhook')
                ->description('This is a test message from the Tasks plugin.')
                ->color('#00ff00')
                ->timestamp(now());

            $webhook = DiscordWebhook::create()
                ->content('🧪 **Test Message**')
                ->addEmbed($embed);

            $response = $webhook->send($webhookUrl);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => trans('tasks::admin.settings.discord.test_success'),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => trans('tasks::admin.settings.discord.test_failed') . ': ' . $response->body(),
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('tasks::admin.settings.discord.test_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }
}
