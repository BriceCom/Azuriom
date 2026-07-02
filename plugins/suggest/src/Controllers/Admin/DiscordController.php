<?php

namespace Azuriom\Plugin\Suggest\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\DiscordWebhookSetting;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Requests\DiscordWebhookRequest;
use Azuriom\Plugin\Suggest\Requests\DiscordWebhookTestRequest;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;

class DiscordController extends Controller
{
    /**
     * Show the Discord webhook configuration page.
     */
    public function show()
    {
        $settings = DiscordWebhookSetting::getInstance();

        return view('suggest::admin.discord', [
            'webhookUrl' => $settings->webhook_url ?? '',
            'enabled' => $settings->enabled,
            'sendOnCreate' => $settings->send_on_create,
            'sendOnAccept' => $settings->send_on_accept,
            'sendOnRefuse' => $settings->send_on_refuse,

            'colorCreated' => $settings->color_created ?? '#00ff00',
            'colorAccepted' => $settings->color_accepted ?? '#0099ff',
            'colorRefused' => $settings->color_refused ?? '#ff0000',

            'templateCreated' => $settings->template_created ?? '',
            'templateAccepted' => $settings->template_accepted ?? '',
            'templateRefused' => $settings->template_refused ?? '',

            'customUsername' => $settings->custom_username ?? '',
            'customAvatarUrl' => $settings->custom_avatar_url ?? '',

            'showAuthor' => $settings->show_author ?? true,
            'showCategory' => $settings->show_category ?? true,
            'showVotes' => $settings->show_votes ?? true,
            'showDescription' => $settings->show_description ?? true,

            'descriptionLength' => $settings->description_length ?? 200,
            'customVariables' => $settings->custom_variables ?? [],
        ]);
    }

    /**
     * Save the Discord webhook configuration.
     */
    public function save(DiscordWebhookRequest $request)
    {
        $settings = DiscordWebhookSetting::getInstance();
        $settings->update($request->validated());

        return redirect()->route('suggest.admin.discord.index')
            ->with('success', trans('admin.settings.updated'));
    }

    /**
     * Test the Discord webhook.
     */
    public function test(DiscordWebhookTestRequest $request)
    {
        $webhookUrl = $request->input('webhook_url');

        try {
            $embed = Embed::create()
                ->title('Test Webhook')
                ->description('This is a test message from the Suggest plugin.')
                ->color('#00ff00')
                ->timestamp(now());

            $webhook = DiscordWebhook::create()
                ->content('🧪 **Test Message**')
                ->addEmbed($embed);

            $response = $webhook->send($webhookUrl);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Webhook test successful!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Webhook test failed: ' . $response->body(),
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Webhook test failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send a Discord webhook for a suggestion.
     */
    public static function sendSuggestionWebhook(Suggestion $suggestion, string $action = 'created')
    {
        $settings = DiscordWebhookSetting::getInstance();

        if (!$settings->shouldSendForAction($action)) {
            return;
        }

        $webhookUrl = $settings->webhook_url;

        try {
            $color = $settings->getColorForAction($action);

            $variables = [
                'title' => $suggestion->title,
                'author' => $suggestion->user->name,
                'category' => $suggestion->category->name ?? 'None',
                'status' => ucfirst($suggestion->status),
                'votes' => $suggestion->votes_count ?? 0,
                'url' => route('suggest.show', $suggestion),
                'description' => $suggestion->stripped_content,
                'refusal_reason' => strip_tags($suggestion->refusal_reason) ?? '',
            ];

            $template = $settings->getTemplateForAction($action);
            $content = $template
                ? $settings->replaceVariables($template, $variables)
                : '📝 **' . $settings->getDefaultActionText($action) . '**';

            $embed = Embed::create()
                ->title($suggestion->title)
                ->color($color)
                ->url(route('suggest.show', $suggestion))
                ->timestamp($suggestion->created_at);

            if ($settings->show_description) {
                $descLength = $settings->description_length ?? 200;
                $description = strlen($suggestion->stripped_content) > $descLength
                    ? substr($suggestion->stripped_content, 0, $descLength) . '...'
                    : $suggestion->stripped_content;
                $embed->description($description);
            }

            if ($settings->show_author) {
                $embed->author($suggestion->user->name, null, $suggestion->user->getAvatar());
            }

            if ($settings->show_category) {
                $embed->addField('Category', $suggestion->category->name ?? 'None', true);
            }

            if ($settings->show_votes) {
                $embed->addField('Votes', $suggestion->votes_count ?? 0, true);
            }

            $embed->addField('Status', ucfirst($suggestion->status), true);

            if ($suggestion->status === 'rejected' && $suggestion->refusal_reason) {
                $embed->addField('Refusal Reason', strip_tags($suggestion->refusal_reason));
            }

            $webhook = DiscordWebhook::create()->content($content)->addEmbed($embed);

            if ($settings->custom_username) {
                $webhook->username($settings->custom_username);
            }

            if ($settings->custom_avatar_url) {
                $webhook->avatarUrl($settings->custom_avatar_url);
            }

            $webhook->send($webhookUrl, false);
        } catch (\Exception $e) {
            logger()->error('Discord webhook failed: ' . $e->getMessage());
        }
    }
}
