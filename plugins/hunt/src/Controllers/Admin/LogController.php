<?php

namespace Azuriom\Plugin\Hunt\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the hunt logs.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $hunt_id = $request->input('hunt_id');
        $user_id = $request->input('user_id');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $logs = HuntLog::with(['hunt', 'user', 'reward'])
            ->when($search, function (Builder $query, $search) {
                $query->whereHas('user', function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhereHas('hunt', function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->when($hunt_id, fn (Builder $query) => $query->where('hunt_id', $hunt_id))
            ->when($user_id, fn (Builder $query) => $query->where('user_id', $user_id))
            ->when($date_from, fn (Builder $query) => $query->whereDate('created_at', '>=', $date_from))
            ->when($date_to, fn (Builder $query) => $query->whereDate('created_at', '<=', $date_to))
            ->latest()
            ->paginate(50);

        $statsQuery = HuntLog::query()
            ->when($hunt_id, fn (Builder $query) => $query->where('hunt_id', $hunt_id))
            ->when($user_id, fn (Builder $query) => $query->where('user_id', $user_id))
            ->when($date_from, fn (Builder $query) => $query->whereDate('created_at', '>=', $date_from))
            ->when($date_to, fn (Builder $query) => $query->whereDate('created_at', '<=', $date_to));

        $stats = [
            'total_logs' => $statsQuery->count(),
            'total_money' => $statsQuery->sum('money_received'),
            'unique_users' => $statsQuery->distinct('user_id')->count(),
            'unique_hunts' => $statsQuery->distinct('hunt_id')->count(),
        ];

        $hunts = Hunt::orderBy('name')->get(['id', 'name']);
        $recentUsers = User::whereIn('id',
            HuntLog::select('user_id', 'created_at')
                ->distinct('user_id')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->pluck('user_id')
        )->orderBy('name')->get(['id', 'name']);

        return view('hunt::admin.logs.index', [
            'search' => $search,
            'hunt_id' => $hunt_id,
            'user_id' => $user_id,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'logs' => $logs,
            'stats' => $stats,
            'hunts' => $hunts,
            'recentUsers' => $recentUsers,
        ]);
    }

    /**
     * Show detailed log information.
     */
    public function show(HuntLog $log)
    {
        $log->load(['hunt', 'user', 'reward.roles', 'reward.servers']);

        $userHuntLogs = HuntLog::where('hunt_id', $log->hunt_id)
            ->where('user_id', $log->user_id)
            ->where('id', '!=', $log->id)
            ->latest()
            ->limit(10)
            ->get();

        $userStats = HuntLog::getUserStats($log->hunt, $log->user);

        return view('hunt::admin.logs.show', [
            'log' => $log,
            'userHuntLogs' => $userHuntLogs,
            'userStats' => $userStats,
        ]);
    }



    /**
     * Get statistics for dashboard.
     */
    public function statistics(Request $request)
    {
        $period = $request->input('period', '7');
        $startDate = Carbon::now()->subDays($period);

        $stats = [
            'total_claims' => HuntLog::where('created_at', '>=', $startDate)->count(),
            'total_money' => HuntLog::where('created_at', '>=', $startDate)->sum('money_received'),
            'unique_users' => HuntLog::where('created_at', '>=', $startDate)->distinct('user_id')->count(),
            'active_hunts' => HuntLog::where('created_at', '>=', $startDate)->distinct('hunt_id')->count(),
        ];

        $dailyStats = HuntLog::selectRaw('DATE(created_at) as date, COUNT(*) as claims, SUM(money_received) as money')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topHunts = HuntLog::selectRaw('hunt_id, COUNT(*) as claims')
            ->with('hunt')
            ->where('created_at', '>=', $startDate)
            ->groupBy('hunt_id')
            ->orderByDesc('claims')
            ->limit(10)
            ->get();

        $topUsers = HuntLog::selectRaw('user_id, COUNT(*) as claims, SUM(money_received) as money')
            ->with('user')
            ->where('created_at', '>=', $startDate)
            ->groupBy('user_id')
            ->orderByDesc('claims')
            ->limit(10)
            ->get();

        return response()->json([
            'stats' => $stats,
            'daily' => $dailyStats,
            'top_hunts' => $topHunts,
            'top_users' => $topUsers,
        ]);
    }
}
