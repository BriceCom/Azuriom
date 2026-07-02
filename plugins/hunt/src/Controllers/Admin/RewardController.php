<?php

namespace Azuriom\Plugin\Hunt\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Role;
use Azuriom\Models\Server;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntReward;
use Azuriom\Plugin\Hunt\Requests\RewardRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RewardController extends Controller
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
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $hunt_id = $request->input('hunt_id');
        $status = $request->input('status');

        $rewards = HuntReward::with(['hunts', 'roles', 'servers'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->when($hunt_id, function (Builder $query, $huntId) {
                $query->whereHas('hunts', function (Builder $huntQuery) use ($huntId) {
                    $huntQuery->where('hunt_hunts.id', $huntId);
                });
            })
            ->when($status === 'enabled', fn (Builder $query) => $query->where('is_enabled', true))
            ->when($status === 'disabled', fn (Builder $query) => $query->where('is_enabled', false))
            ->latest()
            ->paginate();

        $hunts = Hunt::orderBy('name')->get(['id', 'name']);

        return view('hunt::admin.rewards.index', [
            'search' => $search,
            'hunt_id' => $hunt_id,
            'status' => $status,
            'rewards' => $rewards,
            'hunts' => $hunts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $hunt_id = $request->input('hunt_id');

        $preselectedHuntIds = [];
        if ($hunt_id) {
            $preselectedHuntIds = [Hunt::findOrFail($hunt_id)->id];
        }

        return view('hunt::admin.rewards.create', array_merge([
            'preselectedHuntIds' => $preselectedHuntIds,
            'hunts' => Hunt::orderBy('name')->get(['id', 'name']),
            'roles' => Role::orderBy('name')->get(),
            'servers' => Server::executable()->get(),
        ], $this->scratchGameData()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RewardRequest $request)
    {
        $data = Arr::except($request->validated(), ['roles', 'servers', 'hunt_ids']);

        $reward = HuntReward::create($data);

        $reward->hunts()->sync($request->input('hunt_ids', []));
        $reward->roles()->sync($request->input('roles', []));
        $reward->servers()->sync($request->input('servers', []));

        $redirectHuntId = $request->input('hunt_ids.0');

        return to_route('hunt.admin.rewards.index', $redirectHuntId ? ['hunt_id' => $redirectHuntId] : [])
            ->with('success', trans('hunt::admin.rewards.status.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HuntReward $reward)
    {
        $reward->load(['hunts', 'roles', 'servers']);

        return view('hunt::admin.rewards.edit', array_merge([
            'reward' => $reward,
            'hunts' => Hunt::orderBy('name')->get(['id', 'name']),
            'roles' => Role::orderBy('name')->get(),
            'servers' => Server::executable()->get(),
        ], $this->scratchGameData()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RewardRequest $request, HuntReward $reward)
    {
        $reward->update(Arr::except($request->validated(), ['roles', 'servers', 'hunt_ids']));

        $reward->hunts()->sync($request->input('hunt_ids', []));
        $reward->roles()->sync($request->input('roles', []));
        $reward->servers()->sync($request->input('servers', []));

        $redirectHuntId = $request->input('hunt_ids.0');

        return to_route('hunt.admin.rewards.index', $redirectHuntId ? ['hunt_id' => $redirectHuntId] : [])
            ->with('success', trans('hunt::admin.rewards.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HuntReward $reward)
    {
        $hunt_id = $reward->hunts()->pluck('hunt_hunts.id')->first();
        $reward->delete();

        return to_route('hunt.admin.rewards.index', $hunt_id ? ['hunt_id' => $hunt_id] : [])
            ->with('success', trans('hunt::admin.rewards.status.deleted'));
    }

    /**
     * Toggle reward enabled status.
     */
    public function toggleEnabled(HuntReward $reward)
    {
        $reward->update(['is_enabled' => !$reward->is_enabled]);

        $message = $reward->is_enabled
            ? trans('hunt::admin.rewards.status.enabled')
            : trans('hunt::admin.rewards.status.disabled');

        return back()->with('success', $message);
    }

    /**
     * Clone a reward to another hunt.
     */
    public function clone(Request $request, HuntReward $reward)
    {
        $request->validate([
            'target_hunt_id' => ['required', 'exists:hunt_hunts,id'],
        ]);

        $newReward = $reward->replicate();
        $newReward->name .= ' (Copy)';
        $newReward->save();

        $newReward->hunts()->sync([(int) $request->input('target_hunt_id')]);
        $newReward->roles()->sync($reward->roles->pluck('id'));
        $newReward->servers()->sync($reward->servers->pluck('id'));

        return back()->with('success', trans('hunt::admin.rewards.status.cloned'));
    }

    /**
     * Bulk enable/disable rewards.
     */
    public function bulkToggle(Request $request)
    {
        $request->validate([
            'rewards' => ['required', 'array'],
            'rewards.*' => ['exists:hunt_rewards,id'],
            'action' => ['required', 'in:enable,disable'],
        ]);

        $enabled = $request->input('action') === 'enable';
        $count = HuntReward::whereIn('id', $request->input('rewards'))
            ->update(['is_enabled' => $enabled]);

        $message = $enabled
            ? trans('hunt::admin.rewards.status.bulk_enabled', ['count' => $count])
            : trans('hunt::admin.rewards.status.bulk_disabled', ['count' => $count]);

        return back()->with('success', $message);
    }
}
