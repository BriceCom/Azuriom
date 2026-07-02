<?php

namespace Azuriom\Plugin\Suggest\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Models\SuggestionComment;
use Azuriom\Plugin\Suggest\Models\Vote;
use Azuriom\Plugin\Suggest\Models\Category;
use Azuriom\Support\Charts;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Show the suggest statistics page.
     */
    public function index()
    {
        // Basic statistics
        $totalSuggestions = Suggestion::count();
        $pendingSuggestions = Suggestion::where('status', 'pending')->count();
        $acceptedSuggestions = Suggestion::where('status', 'accepted')->count();
        $refusedSuggestions = Suggestion::where('status', 'refused')->count();
        $totalVotes = Vote::count();
        $totalUpvotes = Vote::where('type', 'up')->count();
        $totalDownvotes = Vote::where('type', 'down')->count();
        $totalComments = SuggestionComment::count();

        // Recent activity (last 30 days)
        $recentSuggestions = Suggestion::where('created_at', '>=', now()->subDays(30))->count();
        $recentVotes = Vote::where('created_at', '>=', now()->subDays(30))->count();

        // Top categories by suggestion count
        $topCategories = Category::withCount('suggestions')
            ->orderBy('suggestions_count', 'desc')
            ->limit(5)
            ->get();

        // Most voted suggestions
        $mostVotedSuggestions = Suggestion::withCount(['votes as upvotes_count' => function ($query) {
                $query->where('type', 'up');
            }])
            ->withCount(['votes as downvotes_count' => function ($query) {
                $query->where('type', 'down');
            }])
            ->with(['user', 'category'])
            ->orderByRaw('(SELECT COUNT(*) FROM suggest_votes WHERE suggest_votes.suggestion_id = suggest_suggestions.id AND type = "up") - (SELECT COUNT(*) FROM suggest_votes WHERE suggest_votes.suggestion_id = suggest_suggestions.id AND type = "down") DESC')
            ->limit(10)
            ->get();


        // Monthly statistics for chart
        $monthlyStats = Charts::countByMonths(Suggestion::query(), 'created_at');
        $monthlyVotes = Charts::countByMonths(Vote::query(), 'created_at');
        $monthlyUpVotes = Charts::countByMonths(Vote::scopes(['upvote']), 'created_at');
        $monthlyDownVotes = Charts::countByMonths(Vote::scopes(['downvote']), 'created_at');

        return view('suggest::admin.statistics', compact(
            'totalSuggestions',
            'pendingSuggestions',
            'acceptedSuggestions',
            'refusedSuggestions',
            'totalVotes',
            'totalUpvotes',
            'totalDownvotes',
            'recentSuggestions',
            'recentVotes',
            'topCategories',
            'mostVotedSuggestions',
            'monthlyStats',
            'monthlyVotes',
            'monthlyUpVotes',
            'monthlyDownVotes',
            'totalComments'
        ));
    }
}
