<?php

namespace Azuriom\Plugin\Tasks\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Azuriom\Plugin\Tasks\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TaskObserver::class])]
class Task extends Model
{
    use HasTablePrefix;
    use HasUser;
    use SoftDeletes;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'tasks_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status_id',
        'started_at',
        'limited_at',
        'priority',
        'is_private',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'limited_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_private' => 'boolean',
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'author_id';

    /**
     * Get the author of this task.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the status of this task.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the tags associated with this task.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tasks_task_tag');
    }

    /**
     * Get the related tasks.
     */
    public function relatedTasks()
    {
        return $this->belongsToMany(Task::class, 'tasks_task_relations', 'task_id', 'related_task_id');
    }

    /**
     * Get the tasks that are related to this task.
     */
    public function relatedToTasks()
    {
        return $this->belongsToMany(Task::class, 'tasks_task_relations', 'related_task_id', 'task_id');
    }

    /**
     * Get the assignees of this task.
     */
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'tasks_assignees');
    }

    /**
     * Get the roles that can view this task.
     */
    public function visibleToRoles()
    {
        return $this->belongsToMany('Azuriom\Models\Role', 'tasks_visibility', 'task_id', 'role_id');
    }

    /**
     * Get the checklist items for this task.
     */
    public function checklistItems()
    {
        return $this->hasMany(TaskChecklist::class);
    }

    /**
     * Get the logs for this task.
     */
    public function logs()
    {
        return $this->hasMany(TaskLog::class);
    }

    /**
     * Get the comments for this task.
     */
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }


    /**
     * Check if the task is overdue.
     */
    public function isOverdue()
    {
        return $this->limited_at !== null && $this->limited_at->isPast();
    }

    /**
     * Check if the task is completed.
     */
    public function isCompleted()
    {
        $completedStatuses = json_decode(setting('tasks.completed_statuses', '[]'), true) ?? [];

        if (!empty($completedStatuses)) {
            return in_array($this->status_id, $completedStatuses);
        }

        return $this->status && $this->status->name === 'Completed';
    }

    /**
     * Get the timestamp when the task was marked as completed.
     */
    public function getCompletedAt()
    {
        if (!$this->isCompleted()) {
            return null;
        }

        $completedStatuses = json_decode(setting('tasks.completed_statuses', '[]'), true) ?? [];
        $statusIds = !empty($completedStatuses) ? array_map('strval', $completedStatuses) : [(string) $this->status_id];

        $logs = $this->relationLoaded('logs')
            ? $this->logs
            : $this->logs()
                ->where('action', 'updated_status_id')
                ->orderBy('created_at')
                ->get(['task_id', 'action', 'new_value', 'created_at']);

        $completedAt = $logs
            ->first(fn ($log) => in_array((string) $log->new_value, $statusIds))
            ?->created_at;

        return $completedAt ?? $this->created_at;
    }

    /**
     * Check if the task was completed before or at its deadline.
     */
    public function isCompletedOnTime()
    {
        if ($this->limited_at === null || !$this->isCompleted()) {
            return false;
        }

        $completedAt = $this->getCompletedAt();

        return $completedAt !== null && $completedAt->lte($this->limited_at);
    }

    /**
     * Get the completion percentage of the task based on checklist items.
     */
    public function getCompletionPercentage()
    {
        $items = $this->checklistItems;

        if ($items->isEmpty()) {
            return 0;
        }

        $completedCount = $items->where('completed', true)->count();

        return round(($completedCount / $items->count()) * 100);
    }

    /**
     * Scope a query to only include tasks with a specific status.
     */
    public function scopeWithStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    /**
     * Scope a query to only include tasks with a specific tag.
     */
    public function scopeWithTag($query, $tagId)
    {
        return $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('tag_id', $tagId);
        });
    }

    /**
     * Scope a query to only include tasks assigned to a specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->whereHas('assignees', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Scope a query to only include tasks authored by a specific user.
     */
    public function scopeAuthoredBy($query, $userId)
    {
        return $query->where('author_id', $userId);
    }

    /**
     * Scope a query to only include archived (soft-deleted) tasks.
     */
    public function scopeArchived($query)
    {
        return $query->onlyTrashed();
    }

    /**
     * Scope a query to only include non-archived tasks.
     */
    public function scopeNotArchived($query)
    {
        return $query->whereNull('deleted_at');
    }
}
