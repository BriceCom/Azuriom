<?php

namespace Azuriom\Plugin\DailyReward\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyRewardClaimed extends Notification
{
    public function __construct(
        private readonly int $dayNumber,
        private readonly int $streak,
        private readonly float $money,
        private readonly int $commandsCount
    ) {
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(trans('daily-reward::messages.mails.claim.subject', [
                'name' => site_name(),
            ]))
            ->line(trans('daily-reward::messages.mails.claim.line', [
                'day' => $this->dayNumber,
                'streak' => $this->streak,
                'money' => $this->money,
                'commands' => $this->commandsCount,
            ]))
            ->action(trans('daily-reward::messages.mails.claim.action'), route('daily-reward.index'));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
}
