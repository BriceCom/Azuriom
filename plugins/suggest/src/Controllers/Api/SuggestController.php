<?php

namespace Azuriom\Plugin\Suggest\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\Category;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Models\Vote;
use Azuriom\Plugin\Suggest\Requests\SuggestionRequest;
use Azuriom\Plugin\Suggest\Requests\VoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestController extends Controller
{
    /**
     * Display a listing of the suggestions.
     */
    public function index()
    {
        $suggestions = Suggestion::with('user')
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json($suggestions);
    }

    /**
     * Display the specified suggestion.
     */
    public function show(Suggestion $suggestion)
    {
        $suggestion->load('user');
        $hasVoted = Auth::check() ? $suggestion->hasVoted(Auth::user()) : false;

        return response()->json([
            'suggestion' => $suggestion,
            'hasVoted' => $hasVoted,
        ]);
    }

    /**
     * Store a newly created suggestion in storage.
     */
    public function store(SuggestionRequest $request)
    {
        $suggestion = new Suggestion($request->validated());
        $suggestion->user_id = Auth::id();
        $suggestion->status = 'pending';
        $suggestion->save();

        return response()->json([
            'message' => trans('suggest::messages.created'),
            'suggestion' => $suggestion,
        ]);
    }

    /**
     * Vote for the specified suggestion.
     */
    public function vote(VoteRequest $request, Suggestion $suggestion)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $suggestion->votes()
            ->updateOrCreate(
                ['user_id' => $user->id],
                ['type' => $type]
            );

        // Reload the suggestion with vote counts
        $suggestion->loadCount(['upvotes', 'downvotes']);

        return response()->json([
            'message' => trans('suggest::messages.voted_' . $type),
            'suggestion' => [
                'id' => $suggestion->id,
                'upvotes_count' => $suggestion->upvotes_count,
                'downvotes_count' => $suggestion->downvotes_count,
                'votes_count' => $suggestion->votes_count,
            ],
            'user_vote' => [
                'type' => $type,
                'has_upvoted' => $suggestion->hasUpvoted($user),
                'has_downvoted' => $suggestion->hasDownvoted($user),
            ],
        ]);
    }

    /**
     * Remove a vote from the specified suggestion.
     */
    public function unvote(VoteRequest $request, Suggestion $suggestion)
    {
        $user = Auth::user();
        $type = $request->input('type');

        // Delete the vote
        $deleted = $suggestion->votes()
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->delete();

        // Reload the suggestion with vote counts
        $suggestion->loadCount(['upvotes', 'downvotes']);

        return response()->json([
            'message' => trans('suggest::messages.unvoted_' . $type),
            'suggestion' => [
                'id' => $suggestion->id,
                'upvotes_count' => $suggestion->upvotes_count,
                'downvotes_count' => $suggestion->downvotes_count,
                'votes_count' => $suggestion->votes_count,
            ],
            'user_vote' => [
                'has_upvoted' => $suggestion->hasUpvoted($user),
                'has_downvoted' => $suggestion->hasDownvoted($user),
            ],
        ]);
    }
}
