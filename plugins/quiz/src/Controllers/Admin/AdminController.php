<?php

namespace Azuriom\Plugin\Quiz\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        return redirect()->route('quiz.admin.questions.index');
    }

    public function showSettings()
    {
        $difficultyRewards = json_decode(setting('quiz.difficulty_rewards', ''), true);
        $difficultyRewards = is_array($difficultyRewards) ? $difficultyRewards : [];

        $defaultDifficultyRewards = [
            'easy' => ['type' => 'points', 'value' => 10],
            'medium' => ['type' => 'points', 'value' => 20],
            'hard' => ['type' => 'points', 'value' => 30],
        ];

        return view('quiz::admin.settings', [
            'leaderboard' => setting('quiz.leaderboard', true),
            'admin_responses' => setting('quiz.admin_responses', false),
            'delay_hours' => (int) setting('quiz.delay_hours', 0),
            'difficulty_rewards' => array_replace_recursive($defaultDifficultyRewards, $difficultyRewards),
            'random_rewards' => json_decode(setting('quiz.random_rewards', '[]'), true) ?: [],
        ]);
    }

    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'leaderboard' => ['boolean'],
            'admin_responses' => ['boolean'],
            'delay_hours' => ['nullable', 'integer', 'min:0'],
            'difficulty_rewards' => ['array'],
            'difficulty_rewards.*.type' => ['required', 'string', 'in:points,money,item'],
            'difficulty_rewards.*.value' => ['nullable', 'string', 'max:255'],
            'random_rewards' => ['array'],
            'random_rewards.*.type' => ['required', 'string', 'in:points,money,item'],
            'random_rewards.*.value' => ['required', 'string', 'max:255'],
            'random_rewards.*.probability' => ['required', 'numeric', 'min:0'],
        ]);

        $randomRewards = collect($validated['random_rewards'] ?? [])
            ->filter(function (array $reward) {
                return $reward['value'] !== '' && (float) $reward['probability'] > 0;
            })
            ->values()
            ->all();

        Setting::updateSettings([
            'quiz.leaderboard' => $request->has('leaderboard'),
            'quiz.admin_responses' => $request->has('admin_responses'),
            'quiz.delay_hours' => (int) ($validated['delay_hours'] ?? 0),
            'quiz.difficulty_rewards' => json_encode($validated['difficulty_rewards'] ?? []),
            'quiz.random_rewards' => json_encode($randomRewards),
        ]);

        return redirect()->route('quiz.admin.settings')->with('success', trans('admin.settings.updated'));
    }
}
