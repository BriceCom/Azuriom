<?php

namespace Azuriom\Plugin\DailyReward\Services;

use Azuriom\Azuriom;
use Azuriom\Models\User;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;

class DiscordWebhookNotifier
{
    /**
     * Send the claim event to the configured Discord webhook.
     */
    public function sendClaim(User $user, int $dayNumber, int $streak, float $money, int $commandsCount): void
    {
        $webhookUrl = setting('daily_reward.webhook');

        if ($webhookUrl === null || $webhookUrl === '') {
            return;
        }

        $embed = Embed::create()
            ->title(trans('daily-reward::messages.webhook.claimed'))
            ->author($user->name, null, $user->getAvatar())
            ->addField(trans('daily-reward::messages.webhook.fields.player'), $user->name)
            ->addField(trans('daily-reward::messages.webhook.fields.day'), (string) $dayNumber, true)
            ->addField(trans('daily-reward::messages.webhook.fields.streak'), (string) $streak, true)
            ->addField(trans('daily-reward::messages.webhook.fields.money'), (string) $money, true)
            ->addField(trans('daily-reward::messages.webhook.fields.commands'), (string) $commandsCount, true)
            ->url(route('daily-reward.index'))
            ->color('#0d6efd')
            ->footer('Azuriom v'.Azuriom::version())
            ->timestamp(now());

        $webhook = DiscordWebhook::create()->addEmbed($embed);

        rescue(fn () => $webhook->send($webhookUrl));
    }
}
