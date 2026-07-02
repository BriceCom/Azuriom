<?php

namespace Azuriom\Plugin\ScratchGame\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Azuriom\Plugin\ScratchGame\Models\ScratchLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of play logs.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $cardId = $request->input('card_id');
        $userId = $request->input('user_id');

        $logs = ScratchLog::with(['card', 'user', 'reward'])
            ->when($search, function (Builder $query, string $search) {
                $query->where(function (Builder $nested) use ($search) {
                    $nested->whereHas('user', function (Builder $sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })->orWhereHas('card', function (Builder $sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })->orWhereHas('reward', function (Builder $sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($cardId, fn (Builder $query) => $query->where('card_id', $cardId))
            ->when($userId, fn (Builder $query) => $query->where('user_id', $userId))
            ->latest()
            ->paginate(50);

        return view('scratch-game::admin.logs.index', [
            'search' => $search,
            'card_id' => $cardId,
            'user_id' => $userId,
            'logs' => $logs,
            'cards' => ScratchCard::orderBy('name')->get(['id', 'name']),
            'users' => User::orderBy('name')->limit(200)->get(['id', 'name']),
        ]);
    }
}
