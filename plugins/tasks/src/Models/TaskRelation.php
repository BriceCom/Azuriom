<?php

namespace Azuriom\Plugin\Tasks\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class TaskRelation extends Model
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
    protected $table = 'tasks_task_relations';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'related_task_id',
    ];

    /**
     * Get the task.
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Get the related task.
     */
    public function relatedTask()
    {
        return $this->belongsTo(Task::class, 'related_task_id');
    }
}
