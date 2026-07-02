<?php

namespace Azuriom\Plugin\Tasks\Services;

use Azuriom\Plugin\Tasks\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class TaskService
{
    /**
     * The Discord webhook service instance.
     *
     * @var \Azuriom\Plugin\Tasks\Services\DiscordWebhookService
     */
    protected $discordWebhookService;

    /**
     * Create a new service instance.
     *
     * @param \Azuriom\Plugin\Tasks\Services\DiscordWebhookService $discordWebhookService
     * @return void
     */
    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        $this->discordWebhookService = $discordWebhookService;
    }

    /**
     * Create a new task with the given data.
     *
     * @param array $data
     * @return \Azuriom\Plugin\Tasks\Models\Task
     */
    public function createTask(array $data)
    {
        $task = new Task($data);
        $task->author_id = Auth::id();

        if (Schema::hasColumn('tasks_tasks', 'is_private')) {
            $task->is_private = (($data['visibility'] ?? null) === 'private');
        }

        $task->save();

        if (isset($data['tags'])) {
            $task->tags()->attach($data['tags']);
        }

        if (isset($data['assignees'])) {
            $task->assignees()->attach($data['assignees']);
        }

        if (($data['visibility'] ?? null) === 'role' && isset($data['visibility_roles'])) {
            $task->visibleToRoles()->attach($data['visibility_roles']);
        } else {
            $task->visibleToRoles()->detach();
        }

        if (isset($data['related_tasks'])) {
            $task->relatedTasks()->attach($data['related_tasks']);
        }

        return $task;
    }

    /**
     * Update a task with the given data.
     *
     * @param \Azuriom\Plugin\Tasks\Models\Task $task
     * @param array $data
     * @return \Azuriom\Plugin\Tasks\Models\Task
     */
    public function updateTask(Task $task, array $data)
    {
        $task->fill($data);

        if (Schema::hasColumn('tasks_tasks', 'is_private')) {
            $task->is_private = (($data['visibility'] ?? null) === 'private');
        }

        $task->save();

        if (isset($data['tags'])) {
            $task->tags()->sync($data['tags']);
        } else {
            $task->tags()->detach();
        }

        if (isset($data['assignees'])) {
            $task->assignees()->sync($data['assignees']);
        } else {
            $task->assignees()->detach();
        }

        if (($data['visibility'] ?? null) === 'role' && isset($data['visibility_roles'])) {
            $task->visibleToRoles()->sync($data['visibility_roles']);
        } else {
            $task->visibleToRoles()->detach();
        }

        if (isset($data['related_tasks'])) {
            $task->relatedTasks()->sync($data['related_tasks']);
        } else {
            $task->relatedTasks()->detach();
        }

        $this->discordWebhookService->sendTaskWebhook($task, 'updated');

        return $task;
    }
    /**
     * Archive a task (soft delete).
     *
     * @param Task $task
     * @return bool
     */
    public function archiveTask(Task $task)
    {
        $result = $task->delete();

        $this->discordWebhookService->sendTaskWebhook($task, 'archived');

        return $result;
    }

    /**
     * Restore an archived task.
     *
     * @param int $taskId
     * @return bool
     */
    public function restoreTask(int $taskId)
    {
        $task = Task::withTrashed()->find($taskId);
        $result = $task->restore();

        $this->discordWebhookService->sendTaskWebhook($task, 'restored');

        return $result;
    }

    /**
     * Force delete a task.
     *
     * @param int $taskId
     * @return bool
     */
    public function forceDeleteTask(int $taskId)
    {
        $task = Task::withTrashed()->find($taskId);

        $task->tags()->detach();
        $task->assignees()->detach();
        $task->visibleToRoles()->detach();
        $task->relatedTasks()->detach();
        $task->relatedToTasks()->detach();
        $task->checklistItems()->delete();
        $task->logs()->delete();
        $task->comments()->delete();

        return $task->forceDelete();
    }

    /**
     * Get tasks with filters applied.
     *
     * @param array $filters
     * @param bool $archived
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilteredTasks(array $filters, bool $archived = false)
    {
        $completedStatuses = json_decode(setting('tasks.completed_statuses', '[]'), true) ?? [];
        $hasPrivateVisibility = Schema::hasColumn('tasks_tasks', 'is_private');

        $query = Task::with([
            'author',
            'status',
            'tags',
            'assignees',
            'visibleToRoles',
            'logs' => function ($q) use ($completedStatuses) {
                $q->where('action', 'updated_status_id')
                    ->select(['id', 'task_id', 'new_value', 'created_at'])
                    ->orderBy('created_at');

                if (!empty($completedStatuses)) {
                    $q->whereIn('new_value', $completedStatuses);
                }
            },
        ]);
        $user = Auth::user();

        if (!$user->isAdmin()) {
            $query->where(function ($q) use ($user, $hasPrivateVisibility) {

                $q->where('author_id', $user->id)
                    ->orWhereHas('assignees', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->orWhere(function ($q2) use ($hasPrivateVisibility) {
                        $q2->doesntHave('visibleToRoles');

                        if ($hasPrivateVisibility) {
                            $q2->where('is_private', false);
                        }
                    })
                    ->orWhereHas('visibleToRoles', function ($q) use ($user) {
                        $q->where('role_id', $user->role_id);
                    });
            });
        }

        if ($archived) {
            $query->archived();
        } else {
            $query->notArchived();
        }

        if (isset($filters['status'])) {
            $query->withStatus($filters['status']);
        }

        if (isset($filters['tag'])) {
            $query->withTag($filters['tag']);
        }

        if (isset($filters['assignee'])) {
            $query->assignedTo($filters['assignee']);
        }

        if (isset($filters['author'])) {
            $query->authoredBy($filters['author']);
        }

        $query->orderByDesc('priority')->orderByDesc('created_at');

        return $query->paginate(15)->withQueryString();
    }
}
