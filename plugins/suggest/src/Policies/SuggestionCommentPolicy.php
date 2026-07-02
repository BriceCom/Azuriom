<?php

namespace Azuriom\Plugin\Suggest\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Suggest\Models\SuggestionComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuggestionCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, SuggestionComment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, SuggestionComment $comment): bool
    {
        return $user !== null && ($user->is($comment->author));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, SuggestionComment $comment): bool
    {
        if ($user === null) {
            return false;
        }

        if ($comment->suggestion->status !== 'pending') {
            return false;
        }

        if ($user->is($comment->author)) {
            return true;
        }

        if ($user->can('suggest.comments.delete')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, SuggestionComment $comment): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, SuggestionComment $comment): bool
    {
        return $user !== null;
    }
}
