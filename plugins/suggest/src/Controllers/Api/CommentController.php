<?php

namespace Azuriom\Plugin\Suggest\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Models\SuggestionComment;
use Azuriom\Plugin\Suggest\Requests\VoteRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Vote for the specified comment.
     */
    public function vote(VoteRequest $request, Suggestion $suggestion, SuggestionComment $comment)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $comment->votes()
            ->updateOrCreate(
                ['user_id' => $user->id],
                ['type' => $type]
            );

        $comment->loadCount(['upvotes', 'downvotes']);

        return response()->json([
            'message' => trans('suggest::messages.voted_' . $type),
            'comment' => [
                'id' => $comment->id,
                'upvotes_count' => $comment->upvotes_count,
                'downvotes_count' => $comment->downvotes_count,
                'votes_count' => $comment->votes_count,
            ],
            'user_vote' => [
                'type' => $type,
                'has_upvoted' => $comment->hasUpvoted($user),
                'has_downvoted' => $comment->hasDownvoted($user),
            ],
        ]);
    }

    /**
     * Remove a vote from the specified comment.
     */
    public function unvote(VoteRequest $request, Suggestion $suggestion, SuggestionComment $comment)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $deleted = $comment->votes()
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->delete();

        $comment->loadCount(['upvotes', 'downvotes']);

        return response()->json([
            'message' => trans('suggest::messages.unvoted_' . $type),
            'comment' => [
                'id' => $comment->id,
                'upvotes_count' => $comment->upvotes_count,
                'downvotes_count' => $comment->downvotes_count,
                'votes_count' => $comment->votes_count,
            ],
            'user_vote' => [
                'has_upvoted' => $comment->hasUpvoted($user),
                'has_downvoted' => $comment->hasDownvoted($user),
            ],
        ]);
    }
}
