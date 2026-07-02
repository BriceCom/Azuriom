<?php

namespace Azuriom\Plugin\Hunt\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntLog;
use Azuriom\Plugin\Hunt\Models\HuntReward;
use Azuriom\Plugin\Hunt\Requests\HuntRequest;
use Azuriom\Support\Charts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HuntController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $now = now();

        $hunts = Hunt::with(['rewards', 'logs'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->when($status, function (Builder $query, string $status) use ($now) {
                if ($status === 'active') {
                    $query->where('is_archived', false)
                        ->where('is_active', true)
                        ->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now);

                    return;
                }

                if ($status === 'archived') {
                    $query->where('is_archived', true);

                    return;
                }

                if ($status === 'inactive') {
                    $query->where('is_archived', false)
                        ->where(function (Builder $nested) use ($now) {
                            $nested->where('is_active', false)
                                ->orWhere('start_date', '>', $now)
                                ->orWhere('end_date', '<', $now);
                        });
                }
            })
            ->byPriority()
            ->paginate();

        $currentHunt = Hunt::getCurrentHunt();

        $totalClaims = HuntLog::count();
        $totalClaimsMonth = HuntLog::where('created_at', '>', now()->startOfMonth())->count();
        $totalClaimsWeek = HuntLog::where('created_at', '>', now()->startOfWeek())->count();
        $totalClaimsDay = HuntLog::where('created_at', '>', today())->count();

        return view('hunt::admin.hunts.index', [
            'search' => $search,
            'status' => $status,
            'hunts' => $hunts,
            'currentHunt' => $currentHunt,
            'huntsCount' => Hunt::count(),
            'activeHuntsCount' => Hunt::active()->count(),
            'totalClaims' => $totalClaims,
            'totalClaimsMonth' => $totalClaimsMonth,
            'totalClaimsWeek' => $totalClaimsWeek,
            'totalClaimsDay' => $totalClaimsDay,
            'claimsPerMonths' => Charts::countByMonths(HuntLog::query()),
            'claimsPerDays' => Charts::countByDays(HuntLog::query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rewards = HuntReward::orderBy('name')->get();

        return view('hunt::admin.hunts.create', [
            'rewards' => $rewards,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HuntRequest $request)
    {
        $hunt = Hunt::create(Arr::except($request->validated(), 'rewards'));

        if ($request->hasFile('image')) {
            $hunt->storeImage($request->file('image'), true);
        }

        $hunt->rewards()->sync($request->input('rewards', []));

        return to_route('hunt.admin.hunts.index')
            ->with('success', trans('hunt::admin.hunts.status.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hunt $hunt)
    {
        $hunt->load(['rewards', 'logs']);

        $rewards = HuntReward::orderBy('name')->get();

        return view('hunt::admin.hunts.edit', [
            'hunt' => $hunt,
            'rewards' => $rewards,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HuntRequest $request, Hunt $hunt)
    {
        $data = $request->validated();
        if ($hunt->exists) {
            $data = Arr::except($data, ['start_date', 'end_date', 'rewards']);
        } else {
            $data = Arr::except($data, 'rewards');
        }

        $hunt->update($data);

        if ($request->hasFile('image')) {
            $hunt->storeImage($request->file('image'), true);
        }

        $hunt->rewards()->sync($request->input('rewards', []));

        return to_route('hunt.admin.hunts.index')
            ->with('success', trans('hunt::admin.hunts.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hunt $hunt)
    {
        $hunt->delete();

        return to_route('hunt.admin.hunts.index')
            ->with('success', trans('hunt::admin.hunts.status.deleted'));
    }

    /**
     * Archive hunt.
     */
    public function archive(Hunt $hunt)
    {
        $hunt->update(['is_archived' => true, 'is_active' => false]);

        return back()->with('success', trans('hunt::admin.hunts.status.archived'));
    }

    /**
     * Restore archived hunt.
     */
    public function restore(Hunt $hunt)
    {
        $hunt->update(['is_archived' => false]);

        return back()->with('success', trans('hunt::admin.hunts.status.restored'));
    }

    /**
     * Show hunt statistics and leaderboard.
     */
    public function show(Hunt $hunt)
    {
        $hunt->load(['rewards']);

        $stats = HuntLog::getHuntStats($hunt);
        $leaderboard = HuntLog::getLeaderboard($hunt, 20);
        $recentLogs = HuntLog::forHunt($hunt)->limit(50)->get();

        return view('hunt::admin.hunts.show', [
            'hunt' => $hunt,
            'stats' => $stats,
            'leaderboard' => $leaderboard,
            'recentLogs' => $recentLogs,
        ]);
    }
}
