<?php

namespace Azuriom\Plugin\Suggest\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $comment_id
 * @property int $user_id
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder upvote()
 * @method static \Illuminate\Database\Eloquent\Builder downvote()
 */
class CommentVote extends Model
{
    use HasTablePrefix;
    use HasUser;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'suggest_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment_id',
        'user_id',
        'type',
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
     * Get the comment that this vote is for.
     */
    public function comment()
    {
        return $this->belongsTo(SuggestionComment::class, 'comment_id');
    }

    /**
     * Scope a query to only include upvotes.
     */
    public function scopeUpvote(Builder $query): void
    {
        $query->where('type', 'up');
    }

    /**
     * Scope a query to only include downvotes.
     */
    public function scopeDownvote(Builder $query): void
    {
        $query->where('type', 'down');
    }
}
