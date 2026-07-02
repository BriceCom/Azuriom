<?php

namespace Azuriom\Plugin\Suggest\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Azuriom\Plugin\Suggest\Observers\SuggestionObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;


#[ObservedBy([SuggestionObserver::class])]
class Suggestion extends Model
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
        'title',
        'content',
        'status',
        'refusal_reason',
        'category_id',
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
     *
     * @var string
     */
    protected $userKey = 'user_id';

    /**
     * Get the user who created this ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the votes for this suggestion.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the upvotes for this suggestion.
     */
    public function upvotes()
    {
        return $this->votes()->where('type', 'up');
    }

    /**
     * Get the downvotes for this suggestion.
     */
    public function downvotes()
    {
        return $this->votes()->where('type', 'down');
    }

    /**
     * Get the number of upvotes for this suggestion.
     */
    public function getUpvotesCountAttribute()
    {
        return $this->upvotes()->count();
    }

    /**
     * Get the number of downvotes for this suggestion.
     */
    public function getDownvotesCountAttribute()
    {
        return $this->downvotes()->count();
    }

    /**
     * Get the total votes (upvotes - downvotes) for this suggestion.
     */
    public function getVotesCountAttribute()
    {
        return $this->upvotes_count - $this->downvotes_count;
    }

    /**
     * Check if the given user has voted for this suggestion.
     */
    public function hasVoted(User $user)
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the given user has upvoted this suggestion.
     */
    public function hasUpvoted(User $user)
    {
        return $this->upvotes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the given user has downvoted this suggestion.
     */
    public function hasDownvoted(User $user)
    {
        return $this->downvotes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the category of this suggestion.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments for this suggestion.
     */
    public function comments()
    {
        return $this->hasMany(SuggestionComment::class);
    }

    /**
     * Get the stripped and trimmed content of this suggestion.
     */
    public function getStrippedContentAttribute(): string
    {
        return trim(strip_tags($this->content));
    }
}
