<?php

namespace Azuriom\Plugin\Tasks\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tasks\Models\Status;
use Azuriom\Plugin\Tasks\Requests\StatusRequest;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the statuses.
     */
    public function index()
    {
        $statuses = Status::paginate(15);

        return view('tasks::admin.statuses.index', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new status.
     */
    public function create()
    {
        return view('tasks::admin.statuses.create');
    }

    /**
     * Store a newly created status in storage.
     */
    public function store(StatusRequest $request)
    {
        Status::create($request->validated());

        return redirect()->route('tasks.admin.statuses.index')
            ->with('success', trans('tasks::admin.statuses.created'));
    }

    /**
     * Show the form for editing the specified status.
     */
    public function edit(Status $status)
    {
        return view('tasks::admin.statuses.edit', [
            'status' => $status,
        ]);
    }

    /**
     * Update the specified status in storage.
     */
    public function update(StatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        return redirect()->route('tasks.admin.statuses.index')
            ->with('success', trans('tasks::admin.statuses.updated'));
    }

    /**
     * Remove the specified status from storage.
     */
    public function destroy(Status $status)
    {
        if ($status->tasks()->count() > 0) {
            return redirect()->route('tasks.admin.statuses.index')
                ->with('error', trans('tasks::admin.statuses.delete_error'));
        }

        $status->delete();

        return redirect()->route('tasks.admin.statuses.index')
            ->with('success', trans('tasks::admin.statuses.deleted'));
    }
}
