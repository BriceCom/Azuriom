<?php

namespace Azuriom\Plugin\achievement\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Image;
use Azuriom\Models\Setting;
use Azuriom\Models\User;
use Azuriom\Plugin\Achievement\Models\UserTrophyPoints;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('achievement::admin.settings', [
            'trophyName' => setting('achievement.trophy_name', 'Trophy'),
            'trophyIcon' => setting('achievement.trophy_icon', 'bi bi-trophy'),
            'trophyImage' => setting('achievement.trophy_image'),
            'leaderboardTitle' => setting('achievement.leaderboard_title', 'Leaderboard'),
            'images' => Image::all(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $validated = $this->validate($request, [
            'trophy_name' => ['required', 'string', 'max:50'],
            'trophy_icon' => ['nullable', 'string', 'max:100'],
            'trophy_image' => ['nullable', 'string', 'max:100'],
            'leaderboard_title' => ['required', 'string', 'max:100'],
        ]);

        $settings = [
            'achievement.trophy_name' => $validated['trophy_name'],
            'achievement.trophy_icon' => $validated['trophy_icon'],
            'achievement.trophy_image' => $validated['trophy_image'] ?: null,
            'achievement.leaderboard_title' => $validated['leaderboard_title'],
        ];

        Setting::updateSettings($settings);

        return redirect()->route('achievement.admin.settings')
            ->with('success', trans('admin.settings.status.updated'));
    }

    /**
     * Reset all players' trophy points.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetAll()
    {
        UserTrophyPoints::query()->update(['trophy_points' => 0]);

        return redirect()->route('achievement.admin.settings')
            ->with('success', trans('achievement::admin.settings.reset_all_success'));
    }

    /**
     * Reset specific player's trophy points.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPlayer(Request $request)
    {
        $validated = $this->validate($request, [
            'player_name' => ['required', 'string', 'max:25'],
            'reset_amount' => ['nullable', 'integer', 'min:0'],
        ]);

        $user = User::where('name', $validated['player_name'])->first();

        if (! $user) {
            return redirect()->route('achievement.admin.settings')
                ->with('error', trans('achievement::admin.settings.player_not_found', ['name' => $validated['player_name']]));
        }

        $trophyRecord = UserTrophyPoints::where('user_id', $user->id)->first();

        if (! $trophyRecord) {
            return redirect()->route('achievement.admin.settings')
                ->with('info', trans('achievement::admin.settings.player_no_points', ['name' => $validated['player_name']]));
        }

        if ($validated['reset_amount'] !== null) {
            $trophyRecord->update(['trophy_points' => $validated['reset_amount']]);
            $message = trans('achievement::admin.settings.reset_player_amount_success', [
                'name' => $validated['player_name'],
                'amount' => $validated['reset_amount']
            ]);
        } else {
            $trophyRecord->update(['trophy_points' => 0]);
            $message = trans('achievement::admin.settings.reset_player_success', ['name' => $validated['player_name']]);
        }

        return redirect()->route('achievement.admin.settings')
            ->with('success', $message);
    }
}
