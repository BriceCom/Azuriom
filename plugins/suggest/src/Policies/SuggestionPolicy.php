<?php

namespace Azuriom\Plugin\Suggest\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuggestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any suggestions.
     *
     * @param  \Azuriom\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the suggestion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Suggest\Models\Suggestion  $suggestion
     * @return bool
     */
    public function view(User $user, Suggestion $suggestion)
    {
        return true;
    }

    /**
     * Determine whether the user can create suggestions.
     *
     * @param  \Azuriom\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('suggest.create');
    }

    /**
     * Determine whether the user can edit the suggestion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Suggest\Models\Suggestion  $suggestion
     * @return bool
     */
    public function edit(User $user, Suggestion $suggestion)
    {
        if ($user->can('suggest.edit')) {
            return true;
        }

        if ($suggestion->status !== 'pending') {
            return false;
        }

        if ($user->id !== $suggestion->user_id) {
            return false;
        }

        if (!isset($suggestion->upvotes_count) || !isset($suggestion->downvotes_count)) {
            $suggestion->loadCount(['upvotes', 'downvotes']);
        }

        return $suggestion->upvotes_count === 0 && $suggestion->downvotes_count === 0;
    }

    /**
     * Determine whether the user can update the suggestion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Suggest\Models\Suggestion  $suggestion
     * @return bool
     */
    public function update(User $user, Suggestion $suggestion)
    {
        return $this->edit($user, $suggestion);
    }

    /**
     * Determine whether the user can delete the suggestion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Suggest\Models\Suggestion  $suggestion
     * @return bool
     */
    public function delete(User $user, Suggestion $suggestion)
    {
        if ($user->can('suggest.delete')) {
            return true;
        }

        if ($user->id !== $suggestion->user_id) {
            return false;
        }

        return $suggestion->status === 'pending';
    }

    /**
     * Determine whether the user can delete the suggestion (legacy method).
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Suggest\Models\Suggestion  $suggestion
     * @return bool
     */
    public function destroy(User $user, Suggestion $suggestion)
    {
        return $this->delete($user, $suggestion);
    }

    /**
     * Determine whether the user can manage suggestion settings.
     *
     * @param  \Azuriom\Models\User  $user
     * @return bool
     */
    public function manageSettings(User $user)
    {
        return $user->can('suggest.settings');
    }
}
