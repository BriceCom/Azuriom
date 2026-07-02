<?php

namespace Azuriom\Plugin\DailyReward\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Plugin\DailyReward\Models\DailyRewardDay;
use Azuriom\Plugin\DailyReward\Models\DailyRewardReward;
use Azuriom\Plugin\DailyReward\Requests\Admin\RewardRequest;
use Illuminate\Support\Arr;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('daily-reward::admin.rewards.index', [
            'rewards' => DailyRewardReward::query()
                ->with(['day', 'servers'])
                ->orderBy('day_id')
                ->latest('id')
                ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daily-reward::admin.rewards.create', [
            'days' => DailyRewardDay::query()->orderBy('day_number')->get(),
            'servers' => Server::executable()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RewardRequest $request)
    {
        $reward = DailyRewardReward::query()->create(Arr::except($request->validated(), ['servers']));

        $reward->servers()->sync($request->input('servers', []));

        return to_route('daily-reward.admin.rewards.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyRewardReward $reward)
    {
        return view('daily-reward::admin.rewards.edit', [
            'reward' => $reward->load('servers'),
            'days' => DailyRewardDay::query()->orderBy('day_number')->get(),
            'servers' => Server::executable()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RewardRequest $request, DailyRewardReward $reward)
    {
        $reward->update(Arr::except($request->validated(), ['servers']));

        $reward->servers()->sync($request->input('servers', []));

        return to_route('daily-reward.admin.rewards.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(DailyRewardReward $reward)
    {
        $reward->delete();

        return to_route('daily-reward.admin.rewards.index')
            ->with('success', trans('messages.status.success'));
    }
}
