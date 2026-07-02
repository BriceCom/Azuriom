<?php

namespace Azuriom\Plugin\DailyReward\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Setting;
use Azuriom\Plugin\DailyReward\Requests\Admin\DailyRewardSettingsRequest;
use Azuriom\Plugin\DailyReward\Services\DailyRewardService;

class SettingController extends Controller
{
    public function __construct(private readonly DailyRewardService $service)
    {
    }

    /**
     * Display plugin settings.
     */
    public function show()
    {
        return view('daily-reward::admin.settings', [
            'enabled' => setting('daily_reward.enabled', true),
            'resetMode' => setting('daily_reward.reset_mode', 'midnight'),
            'cycleLength' => setting('daily_reward.cycle_length', 7),
            'defaultMoney' => setting('daily_reward.default_money', 100),
            'webhook' => setting('daily_reward.webhook'),
            'mailNotifications' => setting('daily_reward.mail_notifications', false),
            'publicLeaderboard' => setting('daily_reward.public_leaderboard', true),
            'mailEnabled' => config('mail.default') !== 'array',
        ]);
    }

    /**
     * Update plugin settings.
     */
    public function save(DailyRewardSettingsRequest $request)
    {
        $validated = $request->validated();

        $settings = [
            'daily_reward.enabled' => $validated['enabled'],
            'daily_reward.reset_mode' => $validated['reset_mode'],
            'daily_reward.cycle_length' => $validated['cycle_length'],
            'daily_reward.default_money' => $validated['default_money'],
            'daily_reward.webhook' => $validated['webhook'],
            'daily_reward.mail_notifications' => $validated['mail_notifications'],
            'daily_reward.public_leaderboard' => $validated['public_leaderboard'],
        ];

        $old = Setting::updateSettings($settings);

        ActionLog::log('daily-reward.settings.updated')?->createEntries($old, $settings);

        $this->service->synchronizeDays(
            (int) $validated['cycle_length'],
            (float) $validated['default_money'],
            (bool) $validated['sync_rewards'],
        );

        return to_route('daily-reward.admin.settings')
            ->with('success', trans('admin.settings.updated'));
    }
}
