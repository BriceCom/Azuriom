<?php

namespace Azuriom\Plugin\DailyReward\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\DailyReward\Models\DailyRewardUserState;

class LeaderboardController extends Controller
{
    /**
     * Display the public leaderboard.
     */
    public function index()
    {
        abort_unless(setting('daily_reward.public_leaderboard', true), 404);

        return view('daily-reward::leaderboard', [
            'current' => DailyRewardUserState::query()
                ->with('user')
                ->orderByDesc('streak_count')
                ->orderByDesc('max_streak')
                ->limit(50)
                ->get(),
            'best' => DailyRewardUserState::query()
                ->with('user')
                ->orderByDesc('max_streak')
                ->orderByDesc('streak_count')
                ->limit(50)
                ->get(),
        ]);
    }
}
