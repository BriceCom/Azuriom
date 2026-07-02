<?php

namespace Azuriom\Plugin\Tasks\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\Tasks\Models\Status;
use Azuriom\Plugin\Tasks\Requests\SettingsUpdateRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the plugin settings.
     */
    public function index()
    {
        $statuses = Status::all();

        $pendingStatuses = json_decode(setting('tasks.pending_statuses', '[]'), true) ?? [];
        $inProgressStatuses = json_decode(setting('tasks.in_progress_statuses', '[]'), true) ?? [];
        $completedStatuses = json_decode(setting('tasks.completed_statuses', '[]'), true) ?? [];

        return view('tasks::admin.settings', [
            'statuses' => $statuses,
            'pendingStatuses' => $pendingStatuses,
            'inProgressStatuses' => $inProgressStatuses,
            'completedStatuses' => $completedStatuses,
        ]);
    }

    /**
     * Update the plugin settings.
     */
    public function update(SettingsUpdateRequest $request)
    {
        $validated = $request->validated();

        Setting::updateSettings([
            'tasks.pending_statuses' => json_encode($validated['pending_statuses'] ?? []),
            'tasks.in_progress_statuses' => json_encode($validated['in_progress_statuses'] ?? []),
            'tasks.completed_statuses' => json_encode($validated['completed_statuses'] ?? []),
        ]);

        return redirect()->route('tasks.admin.settings')
            ->with('success', trans('tasks::admin.settings.updated'));
    }

}
