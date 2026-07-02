<?php

namespace Azuriom\Plugin\Trackurl\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Trackurl\Models\Link;
use Azuriom\Plugin\Trackurl\Requests\LinkRequest;
use Azuriom\Plugin\Trackurl\Requests\ToggleBlockRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    /**
     * Display a listing of the links.
     */
    public function index()
    {
        $links = Link::with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('trackurl::admin.index', ['links' => $links]);
    }

    /**
     * Show the form for creating a new link.
     */
    public function create()
    {
        return view('trackurl::admin.create');
    }

    /**
     * Store a newly created link in storage.
     */
    public function store(LinkRequest $request)
    {
        $validated = $request->validated();

        // Generate a random short code if none was provided
        if (empty($validated['short_code'])) {
            $validated['short_code'] = Str::random(6);
        }

        $link = Link::create(array_merge($validated, [
            'user_id' => Auth::id(),
        ]));

        // Log the action
        ActionLog::log('trackurl-links.created', $link);

        return redirect()->route('trackurl.admin.index')
            ->with('success', trans('trackurl::admin.links.created'));
    }

    /**
     * Show the form for editing the specified link.
     */
    public function edit(Link $link)
    {
        return view('trackurl::admin.edit', ['link' => $link]);
    }

    /**
     * Update the specified link in storage.
     */
    public function update(LinkRequest $request, Link $link)
    {
        $link->update($request->validated());

        // Log the action
        ActionLog::log('trackurl-links.updated', $link);

        return redirect()->route('trackurl.admin.index')
            ->with('success', trans('trackurl::admin.links.updated'));
    }

    /**
     * Remove the specified link from storage.
     */
    public function destroy(Link $link)
    {
        // Log the action before deleting
        ActionLog::log('trackurl-links.deleted', $link);

        $link->delete();

        return redirect()->route('trackurl.admin.index')
            ->with('success', trans('trackurl::admin.links.deleted'));
    }

    /**
     * Display the statistics for the specified link.
     */
    public function stats(Link $link)
    {
        $link->load('clicks');

        // Count clicks by day for the last 30 days
        $dailyClicks = $link->clicks()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Get clicks for different time periods
        $now = now();
        $clicksToday = $link->clicks()->whereDate('created_at', $now->toDateString())->count();

        $startOfWeek = now()->startOfWeek();
        $clicksThisWeek = $link->clicks()->where('created_at', '>=', $startOfWeek->toDateTimeString())->count();

        $clicksThisMonth = $link->clicks()->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $totalClicks = $link->clicks()->count();

        // Get unique visitors (by session)
        $uniqueVisitors = $link->clicks()->distinct('session_id')->count('session_id');

        return view('trackurl::admin.stats', [
            'link' => $link,
            'dailyClicks' => $dailyClicks,
            'clicksToday' => $clicksToday,
            'clicksThisWeek' => $clicksThisWeek,
            'clicksThisMonth' => $clicksThisMonth,
            'totalClicks' => $totalClicks,
            'uniqueVisitors' => $uniqueVisitors,
        ]);
    }

    /**
     * Toggle the blocked status of the specified link.
     */
    public function toggleBlock(ToggleBlockRequest $request, Link $link)
    {
        $link->update(['blocked' => !$link->blocked]);

        // Log the action with the status change
        $action = $link->blocked ? 'trackurl-links.blocked' : 'trackurl-links.unblocked';
        ActionLog::log($action, $link);

        $message = $link->blocked ? 'blocked' : 'unblocked';

        return redirect()->route('trackurl.admin.index')
            ->with('success', trans('trackurl::admin.links.' . $message));
    }
}
