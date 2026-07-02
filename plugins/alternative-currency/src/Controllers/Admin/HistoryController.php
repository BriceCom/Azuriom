<?php

namespace Azuriom\Plugin\AlternativeCurrency\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\AlternativeCurrency\Models\History;
use Illuminate\Database\Eloquent\Builder;

class HistoryController extends Controller
{

    /**
     * Affiche la liste d'historique
     */
    public function index()
    {
        $search = request('search');

        $historys = History::with(['coin', 'user'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->latest()
            ->paginate();

        return view('alternative-currency::admin.history.index', [
            "search" => $search,
            'historys' => $historys,
        ]);
    }
}
