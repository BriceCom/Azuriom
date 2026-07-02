<?php

namespace Azuriom\Plugin\SpinWheel\Controllers\Admin;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\SpinWheel\Models\Laps;
use Azuriom\Plugin\SpinWheel\Models\Rewards;

class StatisticsController extends Controller
{
    public function index()
    {
        $laps = Laps::all();
        $rewards = Rewards::all();

        $statsRewards = [];
        foreach($rewards as $reward) {
            $count = Laps::where('reward_id', $reward->id)->count();
            array_push($statsRewards, (object) [
                "reward" => $reward,
                "count" => $count,
                "probability" => $count !== 0 ? round(($count * 100)/$laps->count(), 2) : 0,
            ]);
        }

        return view('spin-wheel::admin.statistics', [
            'laps' => Laps::latest()->paginate(10),
            'rewardsCount' => $rewards->count(),
            'spinsCount' => $laps->count(),
            'totalMoneyBet' => $laps->sum('spin_price'),
            'totalMoneyGived' => $laps->sum('money_added'),
            'statsRewards' => $statsRewards,
        ]);
    }

    public function destroy()
    {
        Laps::truncate();
        return redirect()->route('spin-wheel.admin.statistics.index')->with('success', trans('spin-wheel::admin.pages.statistics.truncate.notifs.success'));
    }
}
