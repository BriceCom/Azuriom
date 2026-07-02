<?php

namespace Azuriom\Plugin\Suggest\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $suggestion_id
 * @property int $user_id
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder upvote()
 * @method static \Illuminate\Database\Eloquent\Builder downvote()
 */
class Vote extends Model
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
        'suggestion_id',
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
     * Get the suggestion that this vote is for.
     */
    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class);
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
