<?php

namespace Azuriom\Plugin\Tasks\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class TaskChecklist extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'tasks_';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks_checklist';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'title',
        'completed',
        'completed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the task this checklist item belongs to.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who completed this checklist item.
     */
    public function completedByUser()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
