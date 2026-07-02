<?php

namespace Azuriom\Plugin\DailyReward\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\DailyReward\Models\DailyRewardClaim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    /**
     * Display claim history.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $claims = DailyRewardClaim::query()
            ->with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', '%'.$search.'%'));
            })
            ->latest('claimed_at')
            ->paginate();

        return view('daily-reward::admin.claims.index', [
            'claims' => $claims,
            'search' => $search,
        ]);
    }
}
