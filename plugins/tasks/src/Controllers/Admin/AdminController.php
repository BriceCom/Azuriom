<?php

namespace Azuriom\Plugin\Tasks\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Models\Role;
use Azuriom\Plugin\Tasks\Models\Status;
use Azuriom\Plugin\Tasks\Models\Tag;
use Azuriom\Plugin\Tasks\Models\Task;
use Azuriom\Plugin\Tasks\Models\TaskChecklist;
use Azuriom\Plugin\Tasks\Models\TaskComment;
use Azuriom\Plugin\Tasks\Requests\AssigneeRequest;
use Azuriom\Plugin\Tasks\Requests\ChecklistRequest;
use Azuriom\Plugin\Tasks\Requests\CommentRequest;
use Azuriom\Plugin\Tasks\Requests\StatusUpdateRequest;
use Azuriom\Plugin\Tasks\Requests\TaskRequest;
use Azuriom\Plugin\Tasks\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * The task service instance.
     */
    protected TaskService $taskService;

    /**
     * Create a new controller instance.
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $archived = $request->has('archived') && $request->input('archived') === '1';
        $filters = $request->only(['status', 'tag', 'assignee', 'author']);

        $tasks = $this->taskService->getFilteredTasks($filters, $archived);
        $statuses = Status::all();
        $tags = Tag::all();

        // Get all users for author filter
        $users = User::all();

        return view('tasks::admin.index', [
            'tasks' => $tasks,
            'statuses' => $statuses,
            'tags' => $tags,
            'users' => $users,
            'filter' => $filters,
            'archived' => $archived,
        ]);
    }


    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $statuses = Status::all();
        $tags = Tag::all();

        // Get all users for assignees
        $users = User::whereHas('role', function ($q) {
            $q->where('is_admin', true)
                ->orWhereHas('permissions', function ($query) {
                    $query->where('permission', 'tasks.view');
                });
        })->get();

        $roles = Role::all();
        $relatedTasks = Task::all();

        return view('tasks::admin.create', [
            'statuses' => $statuses,
            'tags' => $tags,
            'users' => $users,
            'roles' => $roles,
            'relatedTasks' => $relatedTasks,
        ]);
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(TaskRequest $request)
    {
        $this->taskService->createTask($request->validated());

        return redirect()->route('tasks.admin.index')
            ->with('success', trans('tasks::admin.tasks.created'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $task->load(['tags', 'assignees', 'visibleToRoles', 'relatedTasks', 'checklistItems']);

        $statuses = Status::all();
        $tags = Tag::all();

        // Get all users for assignees
        $users = User::all();

        $roles = Role::all();
        $relatedTasks = Task::where('id', '!=', $task->id)->get();

        return view('tasks::admin.edit', [
            'task' => $task,
            'statuses' => $statuses,
            'tags' => $tags,
            'users' => $users,
            'roles' => $roles,
            'relatedTasks' => $relatedTasks,
        ]);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->taskService->updateTask($task, $request->validated());

        return redirect()->route('tasks.admin.index')
            ->with('success', trans('tasks::admin.tasks.updated'));
    }

    /**
     * Display the specified task.
     */
    public function show($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->load(['author', 'status', 'tags', 'assignees', 'checklistItems', 'relatedTasks', 'logs', 'comments.author']);
        $statuses = Status::all();

        return view('tasks::admin.show', [
            'task' => $task,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Remove the specified task from storage (soft delete / archive).
     */
    public function destroy(Task $task)
    {
        $this->taskService->archiveTask($task);

        return redirect()->route('tasks.admin.index')
            ->with('success', trans('tasks::admin.tasks.archived'));
    }

    /**
     * Restore the specified task from archive.
     */
    public function restore($id)
    {
        $this->taskService->restoreTask($id);

        return redirect()->route('tasks.admin.index', ['archived' => '1'])
            ->with('success', trans('tasks::admin.tasks.restored'));
    }

    /**
     * Force delete the specified task from storage.
     */
    public function forceDelete($id)
    {
        $this->taskService->forceDeleteTask($id);

        return redirect()->route('tasks.admin.index', ['archived' => '1'])
            ->with('success', trans('tasks::admin.tasks.force_deleted'));
    }

    /**
     * Store a new checklist item for the task.
     */
    public function storeChecklist(ChecklistRequest $request, Task $task)
    {
        $checklist = new TaskChecklist($request->validated());
        $checklist->task_id = $task->id;

        if ($request->input('completed', false)) {
            $checklist->completed = true;
            $checklist->completed_by = Auth::id();
        }

        $checklist->save();

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.checklist.created'));
    }

    /**
     * Update a checklist item for the task.
     */
    public function updateChecklist(ChecklistRequest $request, Task $task, TaskChecklist $checklist)
    {
        // Ensure the checklist belongs to the task
        if ($checklist->task_id !== $task->id) {
            abort(404);
        }

        $checklist->update($request->validated());

        // If completed status changed
        if ($request->has('completed') && $checklist->completed !== (bool) $request->input('completed')) {
            $checklist->completed = (bool) $request->input('completed');
            $checklist->completed_by = $checklist->completed ? Auth::id() : null;
            $checklist->save();
        }

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.checklist.updated'));
    }

    /**
     * Remove a checklist item from the task.
     */
    public function destroyChecklist(Task $task, TaskChecklist $checklist)
    {
        // Ensure the checklist belongs to the task
        if ($checklist->task_id !== $task->id) {
            abort(404);
        }

        $checklist->delete();

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.checklist.deleted'));
    }

    /**
     * Add an assignee to the task.
     */
    public function addAssignee(AssigneeRequest $request, Task $task)
    {
        $userId = $request->input('user_id');

        // Check if the user is already assigned
        if ($task->assignees()->where('user_id', $userId)->exists()) {
            return redirect()->route('tasks.admin.show', $task)
                ->with('error', trans('tasks::admin.tasks.assignee.already_assigned'));
        }

        $task->assignees()->attach($userId);

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.assignee.added'));
    }

    /**
     * Remove an assignee from the task.
     */
    public function removeAssignee(Task $task, $userId)
    {
        $task->assignees()->detach($userId);

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.assignee.removed'));
    }

    /**
     * Update the status of the specified task.
     */
    public function updateStatus(StatusUpdateRequest $request, Task $task)
    {
        $oldStatus = $task->status;
        $task->status_id = $request->input('status_id');
        $task->save();

        // Determine the appropriate action based on the new status
        $action = 'updated';
        $newStatus = $task->status;

        // If the task is marked as completed
        if ($newStatus && $newStatus->name === 'Completed') {
            $action = 'completed';
        }

        // Send Discord webhook for status change
        app(\Azuriom\Plugin\Tasks\Services\DiscordWebhookService::class)
            ->sendTaskWebhook($task, $action);

        return redirect()->back()->with('success', trans('tasks::admin.tasks.status_updated'));
    }

    /**
     * Store a new comment for the task.
     */
    public function storeComment(CommentRequest $request, Task $task)
    {
        $comment = new TaskComment($request->validated());
        $comment->task_id = $task->id;
        $comment->author_id = Auth::id();
        $comment->save();

        // Send Discord webhook for new comment
        app(\Azuriom\Plugin\Tasks\Services\DiscordWebhookService::class)
            ->sendCommentWebhook($comment);

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.comment.created'));
    }

    /**
     * Update a comment for the task.
     */
    public function updateComment(CommentRequest $request, Task $task, TaskComment $comment)
    {
        // Ensure the comment belongs to the task
        if ($comment->task_id !== $task->id) {
            abort(404);
        }

        // Only the author or an admin can update a comment
        if ($comment->author_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $comment->update($request->validated());

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.comment.updated'));
    }

    /**
     * Remove a comment from the task.
     */
    public function destroyComment(Task $task, TaskComment $comment)
    {
        // Ensure the comment belongs to the task
        if ($comment->task_id !== $task->id) {
            abort(404);
        }

        // Only the author or an admin can delete a comment
        if ($comment->author_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->route('tasks.admin.show', $task)
            ->with('success', trans('tasks::admin.tasks.comment.deleted'));
    }
}
