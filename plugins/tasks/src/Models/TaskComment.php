<?php

namespace Azuriom\Plugin\Tasks\Models;

use Azuriom\Models\Traits\HasMarkdown;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class TaskComment extends Model
{
    use HasTablePrefix;
    use HasMarkdown;
    use HasUser;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'tasks_';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'content',
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
     * The user key associated with this model.
     */
    protected string $userKey = 'author_id';

    /**
     * Get the task this comment belongs to.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the author of this comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
