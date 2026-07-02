<?php

namespace Azuriom\Plugin\Tasks\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasTablePrefix;

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
        'name',
        'color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tasks with this status.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
