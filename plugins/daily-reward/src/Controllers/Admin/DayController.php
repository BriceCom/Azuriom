<?php

namespace Azuriom\Plugin\DailyReward\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\DailyReward\Models\DailyRewardDay;
use Azuriom\Plugin\DailyReward\Requests\Admin\DayRequest;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('daily-reward::admin.days.index', [
            'days' => DailyRewardDay::query()
                ->withCount('rewards')
                ->orderBy('day_number')
                ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daily-reward::admin.days.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DayRequest $request)
    {
        DailyRewardDay::query()->create($request->validated());

        return to_route('daily-reward.admin.days.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyRewardDay $day)
    {
        return view('daily-reward::admin.days.edit', [
            'day' => $day,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DayRequest $request, DailyRewardDay $day)
    {
        $day->update($request->validated());

        return to_route('daily-reward.admin.days.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(DailyRewardDay $day)
    {
        $day->delete();

        return to_route('daily-reward.admin.days.index')
            ->with('success', trans('messages.status.success'));
    }
}
