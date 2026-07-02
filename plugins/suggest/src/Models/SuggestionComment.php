<?php

namespace Azuriom\Plugin\Suggest\Models;

use Azuriom\Models\Traits\HasMarkdown;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Azuriom\Plugin\Suggest\Models\CommentVote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class SuggestionComment extends Model
{
    use HasMarkdown;
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
        'content',
    ];

    /**
     * The user key associated with this model.
     */
    protected string $userKey = 'author_id';

    /**
     * Get the suggestion of this comment.
     */
    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class);
    }

    /**
     * Get the author of this comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the votes for this comment.
     */
    public function votes()
    {
        return $this->hasMany(CommentVote::class, 'comment_id');
    }

    /**
     * Get the upvotes for this comment.
     */
    public function upvotes()
    {
        return $this->votes()->where('type', 'up');
    }

    /**
     * Get the downvotes for this comment.
     */
    public function downvotes()
    {
        return $this->votes()->where('type', 'down');
    }

    /**
     * Get the number of upvotes for this comment.
     */
    public function getUpvotesCountAttribute()
    {
        return $this->upvotes()->count();
    }

    /**
     * Get the number of downvotes for this comment.
     */
    public function getDownvotesCountAttribute()
    {
        return $this->downvotes()->count();
    }

    /**
     * Get the total votes (upvotes - downvotes) for this comment.
     */
    public function getVotesCountAttribute()
    {
        return $this->upvotes_count - $this->downvotes_count;
    }

    /**
     * Check if the given user has voted for this comment.
     */
    public function hasVoted(User $user)
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the given user has upvoted this comment.
     */
    public function hasUpvoted(User $user)
    {
        return $this->upvotes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the given user has downvoted this comment.
     */
    public function hasDownvoted(User $user)
    {
        return $this->downvotes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the stripped and trimmed content of this suggestion.
     */
    public function getStrippedContentAttribute(): string
    {
        return trim(strip_tags($this->content));
    }
}
