<?php

namespace Azuriom\Plugin\Suggest\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Models\SuggestionComment;
use Azuriom\Plugin\Suggest\Requests\SuggestionCommentRequest;
use Azuriom\Plugin\Suggest\Requests\VoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SuggestionCommentRequest $request, Suggestion $suggestion)
    {
        if ($suggestion->status !== 'pending') {
            return back()->with('error', trans('suggest::messages.comments.not_allowed'));
        }

        $suggestion->comments()->create($request->validated());

        return back()->with('success', trans('suggest::messages.comments.created'));
    }

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

        return back()->with('success', trans('suggest::messages.voted_' . $type));
    }

    /**
     * Remove a vote from the specified comment.
     */
    public function unvote(VoteRequest $request, Suggestion $suggestion, SuggestionComment $comment)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $comment->votes()
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->delete();

        return back()->with('success', trans('suggest::messages.unvoted_' . $type));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suggestion $suggestion, SuggestionComment $comment)
    {
        $comment->delete();

        return back()->with('success', trans('suggest::messages.comments.deleted'));
    }
}
