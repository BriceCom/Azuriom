<?php

namespace Azuriom\Plugin\DailyReward\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\DailyReward\Models\DailyRewardClaim;
use Azuriom\Plugin\DailyReward\Models\DailyRewardDay;
use Azuriom\Plugin\DailyReward\Services\DailyRewardService;
use Illuminate\Http\Request;

class DailyRewardController extends Controller
{
    public function __construct(private readonly DailyRewardService $service)
    {
    }

    /**
     * Show daily reward page.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $days = DailyRewardDay::query()
            ->enabled()
            ->orderBy('day_number')
            ->with(['rewards' => fn ($query) => $query->enabled()->with('servers')])
            ->get();

        if ($days->isEmpty()) {
            $this->service->synchronizeDays(
                max(1, (int) setting('daily_reward.cycle_length', 7)),
                (float) setting('daily_reward.default_money', 100),
                false
            );

            $days = DailyRewardDay::query()
                ->enabled()
                ->orderBy('day_number')
                ->with(['rewards' => fn ($query) => $query->enabled()->with('servers')])
                ->get();
        }

        $status = $user ? $this->service->getStatus($user) : null;
        $claimedDays = collect();

        if ($user !== null) {
            $claimedDays = DailyRewardClaim::query()
                ->where('user_id', $user->id)
                ->orderByDesc('claimed_at')
                ->limit(max(7, (int) setting('daily_reward.cycle_length', 7)))
                ->pluck('day_number');
        }

        return view('daily-reward::index', [
            'enabled' => setting('daily_reward.enabled', true),
            'leaderboardEnabled' => setting('daily_reward.public_leaderboard', true),
            'days' => $days,
            'status' => $status,
            'claimedDays' => $claimedDays,
        ]);
    }

    /**
     * Claim current daily reward.
     */
    public function claim(Request $request)
    {
        $user = $request->user();

        abort_if($user === null, 403);

        $result = $this->service->claim($user);

        if (! ($result['success'] ?? false)) {
            return to_route('daily-reward.index')
                ->with('error', $result['message'] ?? trans('messages.status.error'));
        }

        $summary = $result['summary'] ?? [];
        $money = (float) ($summary['money'] ?? 0);
        $commandsCount = count($summary['commands'] ?? []);

        $message = trans('daily-reward::messages.claim.success_feedback', [
            'day' => $result['day_number'],
            'streak' => $result['streak'],
            'money' => $money,
            'commands' => $commandsCount,
        ]);

        return to_route('daily-reward.index')->with('success', $message);
    }
}
