<?php

namespace Azuriom\Plugin\ScratchGame\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Plugin\ScratchGame\Models\ScratchReward;
use Azuriom\Plugin\ScratchGame\Requests\RewardRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RewardController extends Controller
{
    /**
     * Display a listing of rewards.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $rewards = ScratchReward::with(['cards', 'servers'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->when($status === 'enabled', fn (Builder $query) => $query->where('is_enabled', true))
            ->when($status === 'disabled', fn (Builder $query) => $query->where('is_enabled', false))
            ->latest()
            ->paginate();

        return view('scratch-game::admin.rewards.index', [
            'search' => $search,
            'status' => $status,
            'rewards' => $rewards,
        ]);
    }

    /**
     * Show the form for creating a new reward.
     */
    public function create()
    {
        return view('scratch-game::admin.rewards.create', [
            'servers' => Server::executable()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created reward.
     */
    public function store(RewardRequest $request)
    {
        $data = Arr::except($request->validated(), ['servers', 'image']);

        $reward = ScratchReward::create($data);

        if ($request->hasFile('image')) {
            $reward->storeImage($request->file('image'), true);
        }

        $reward->servers()->sync($request->input('servers', []));

        return to_route('scratch-game.admin.rewards.index')
            ->with('success', trans('scratch-game::admin.rewards.status.created'));
    }

    /**
     * Show the form for editing the specified reward.
     */
    public function edit(ScratchReward $reward)
    {
        $reward->load(['servers', 'cards']);

        return view('scratch-game::admin.rewards.edit', [
            'reward' => $reward,
            'servers' => Server::executable()->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified reward.
     */
    public function update(RewardRequest $request, ScratchReward $reward)
    {
        $data = Arr::except($request->validated(), ['servers', 'image']);

        $reward->update($data);

        if ($request->hasFile('image')) {
            $reward->storeImage($request->file('image'), true);
        }

        $reward->servers()->sync($request->input('servers', []));

        return to_route('scratch-game.admin.rewards.index')
            ->with('success', trans('scratch-game::admin.rewards.status.updated'));
    }

    /**
     * Remove the specified reward.
     */
    public function destroy(ScratchReward $reward)
    {
        $reward->delete();

        return to_route('scratch-game.admin.rewards.index')
            ->with('success', trans('scratch-game::admin.rewards.status.deleted'));
    }

    /**
     * Toggle reward enabled status.
     */
    public function toggleEnabled(ScratchReward $reward)
    {
        $reward->update(['is_enabled' => ! $reward->is_enabled]);

        $message = $reward->is_enabled
            ? trans('scratch-game::admin.rewards.status.enabled')
            : trans('scratch-game::admin.rewards.status.disabled');

        return back()->with('success', $message);
    }
}
