<?php

namespace Azuriom\Plugin\SpinWheel\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\SpinWheel\Models\Laps;
use Azuriom\Plugin\SpinWheel\Models\Rewards;


class SpinWheelHomeController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()) {
            $lastFreeSpins = Laps::where('user_id', $request->user()->id)->where('spin_price', 0.00)->latest()->first();
            if(!empty($lastFreeSpins)) {
                $freeSpin = $lastFreeSpins->created_at->addMinutes((int) setting('spin.freeSpin.delay'));
                $hasFreeSpin = $freeSpin < Carbon::now() ? true : $freeSpin->diffForHumans(null, false, false, 2);
            } else {
                $hasFreeSpin = true;
            }
        } else {
            $hasFreeSpin = false;
        }

        $laps = [];

        Laps::latest()->take(setting('spin.homeWins', 10))->get()->load("player");

        foreach (Laps::latest()->take(setting('spin.homeWins', 10))->get() as $lap)
        {
            array_push($laps, (object) [
                'id' =>$lap->id,
                'name' => $lap->player->name,
                'reward_name' => $lap->reward_name,
            ]);
        }

        $rewards = Rewards::where('is_enabled', true);
        return view('spin-wheel::index', [
            'rewards' => setting('spin.ordering', 1) ? $rewards->orderBy('chances', 'desc')->get() : $rewards->get(),
            'laps' => $laps,
            'freeSpin' => $hasFreeSpin,
        ]);
    }
}
