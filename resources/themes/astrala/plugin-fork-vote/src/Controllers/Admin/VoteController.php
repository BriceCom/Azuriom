<?php

namespace Azuriom\Plugin\Vote\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\Vote\Models\Vote;
use Azuriom\Support\Charts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $topVotes = collect();
        $date = now()->startOfMonth()->subMonths(6);

        while ($date->addMonth()->isPast()) {
            $topVotes->put($date->format('m/Y'), Vote::getRawTopVoters($date, $date->clone()->endOfMonth()));
        }

        $topVotes = $topVotes->map(function ($voteValues) {
            return $voteValues->mapWithKeys(function ($vote, $position) {
                return [
                    $position + 1 => (object) [
                        'user' => ((int)$vote->user ? User::find($vote->user):null),
                        'user_name' => $vote->user,
                        'votes' => $vote->count,
                    ],
                ];
            });
        });

        $votes = Vote::with(['user', 'reward', 'site'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->latest()
            ->paginate();

        return view('vote::admin.votes', [
            'search' => $search,
            'topVotes' => $topVotes,
            'votes' => $votes,
            'votesCount' => Vote::count(),
            'votesCountMonth' => Vote::where('created_at', '>', now()->startOfMonth())->count(),
            'votesCountWeek' => Vote::where('created_at', '>', now()->startOfWeek())->count(),
            'votesCountDay' => Vote::where('created_at', '>', today())->count(),
            'votesPerMonths' => Charts::countByMonths(Vote::query()),
            'votesPerDays' => Charts::countByDays(Vote::query()),

            'now' => now()->format('m/Y'),
        ]);
    }
}
