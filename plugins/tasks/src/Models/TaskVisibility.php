<?php

namespace Azuriom\Plugin\Tasks\Models;

use Azuriom\Models\Role;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class TaskVisibility extends Model
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
    protected $table = 'tasks_visibility';

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
        'role_id',
    ];

    /**
     * Get the task.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
