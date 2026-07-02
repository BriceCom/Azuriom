<?php

namespace Azuriom\Plugin\SpinWheel\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Plugin\SpinWheel\Models\Rewards;
use Azuriom\Plugin\SpinWheel\Requests\RewardsRequest;

class RewardsController extends Controller
{
    private function scratchGameData(): array
    {
        $cards = [];

        $scratchGameEnabled = plugins()->isEnabled('scratch-game');

        if ($scratchGameEnabled) {
            $cards = scratch_game_available_cards();
        }

        return [
            'scratchGameEnabled' => $scratchGameEnabled,
            'scratchCards' => $cards,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('spin-wheel::admin.rewards.index', [
            'rewards' => Rewards::all(),
            'servers' => Server::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('spin-wheel::admin.rewards.create', array_merge([
            'servers' => Server::all(),
        ], $this->scratchGameData()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Azuriom\Plugin\SpinWheel\Requests\RewardsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RewardsRequest $request)
    {
        Rewards::create($request->validated());

        return redirect()->route('spin-wheel.admin.rewards.index')
            ->with('success', trans("spin-wheel::admin.pages.rewards.notifs.created"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Azuriom\Models\Rewards $rewards
     * @return \Illuminate\Http\Response
     */
    public function edit(Rewards $reward)
    {
        return view('spin-wheel::admin.rewards.edit', array_merge([
            'reward' => $reward,
            'servers' => Server::all(),
        ], $this->scratchGameData()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Azuriom\Models\Rewards $rewards
     * @return \Illuminate\Http\Response
     */
    public function update(RewardsRequest $request, Rewards $reward)
    {
        $reward->update($request->validated());

        return redirect()->route('spin-wheel.admin.rewards.index')
            ->with('success', trans("spin-wheel::admin.pages.rewards.notifs.updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Azuriom\Models\Rewards $rewards
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rewards $reward)
    {
        $reward->delete();

        return redirect()->route('spin-wheel.admin.rewards.index')
            ->with('success', trans("spin-wheel::admin.pages.rewards.notifs.deleted"));
    }
}
