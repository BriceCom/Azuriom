<?php

namespace Azuriom\Plugin\Tasks\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tasks\Models\Task;
use Azuriom\Plugin\Tasks\Models\Status;
use Azuriom\Plugin\Tasks\Models\Tag;
use Azuriom\Support\Charts;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Show the tasks statistics page.
     */
    public function index()
    {
        $pendingStatusIds = json_decode(setting('tasks.pending_statuses', '[]'), true) ?? [];
        $inProgressStatusIds = json_decode(setting('tasks.in_progress_statuses', '[]'), true) ?? [];
        $completedStatusIds = json_decode(setting('tasks.completed_statuses', '[]'), true) ?? [];

        $totalTasks = Task::count();
        $completedTasks = empty($completedStatusIds)
            ? Task::whereHas('status', function ($query) {
                $query->where('name', 'Completed');
              })->count()
            : Task::whereIn('status_id', $completedStatusIds)->count();
        $inProgressTasks = empty($inProgressStatusIds)
            ? Task::whereHas('status', function ($query) {
                $query->where('name', 'In Progress');
              })->count()
            : Task::whereIn('status_id', $inProgressStatusIds)->count();
        $pendingTasks = empty($pendingStatusIds)
            ? Task::whereHas('status', function ($query) {
                $query->where('name', 'Pending');
              })->count()
            : Task::whereIn('status_id', $pendingStatusIds)->count();
        $overdueTasks = Task::where('limited_at', '<', now())->count();

        $recentTasks = Task::where('created_at', '>=', now()->subDays(30))->count();
        $recentCompletedTasks = empty($completedStatusIds)
            ? Task::whereHas('status', function ($query) {
                $query->where('name', 'Completed');
              })->where('updated_at', '>=', now()->subDays(30))->count()
            : Task::whereIn('status_id', $completedStatusIds)
                ->where('updated_at', '>=', now()->subDays(30))->count();

        $topTags = Tag::withCount('tasks')
            ->orderBy('tasks_count', 'desc')
            ->limit(5)
            ->get();

        $tasksByStatus = Status::withCount('tasks')
            ->orderBy('tasks_count', 'desc')
            ->get();

        $monthlyStats = Charts::countByMonths(Task::query(), 'created_at');
        $monthlyCompletedStats = empty($completedStatusIds)
            ? Charts::countByMonths(Task::whereHas('status', function ($query) {
                $query->where('name', 'Completed');
              }), 'updated_at')
            : Charts::countByMonths(Task::whereIn('status_id', $completedStatusIds), 'updated_at');

        return view('tasks::admin.statistics', compact(
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'pendingTasks',
            'overdueTasks',
            'recentTasks',
            'recentCompletedTasks',
            'topTags',
            'tasksByStatus',
            'monthlyStats',
            'monthlyCompletedStats'
        ));
    }
}
