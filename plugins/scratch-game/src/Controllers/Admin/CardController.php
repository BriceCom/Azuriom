<?php

namespace Azuriom\Plugin\ScratchGame\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Image;
use Azuriom\Models\Role;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Azuriom\Plugin\ScratchGame\Models\ScratchReward;
use Azuriom\Plugin\ScratchGame\Requests\CardRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CardController extends Controller
{
    /**
     * Display a listing of cards.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $cards = ScratchCard::with(['rewards', 'roles'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->when($status === 'enabled', fn (Builder $query) => $query->where('is_enabled', true))
            ->when($status === 'disabled', fn (Builder $query) => $query->where('is_enabled', false))
            ->latest()
            ->paginate();

        return view('scratch-game::admin.cards.index', [
            'search' => $search,
            'status' => $status,
            'cards' => $cards,
        ]);
    }

    /**
     * Show the form for creating a new card.
     */
    public function create()
    {
        return view('scratch-game::admin.cards.create', [
            'images' => Image::orderBy('name')->get(['id', 'name', 'file']),
            'rewards' => ScratchReward::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created card.
     */
    public function store(CardRequest $request)
    {
        $data = Arr::except($request->validated(), ['rewards', 'roles']);

        $card = ScratchCard::create($data);

        $card->rewards()->sync($request->input('rewards', []));
        $card->roles()->sync($request->input('roles', []));

        return to_route('scratch-game.admin.cards.index')
            ->with('success', trans('scratch-game::admin.cards.status.created'));
    }

    /**
     * Show the form for editing the specified card.
     */
    public function edit(ScratchCard $card)
    {
        $card->load(['rewards', 'roles']);

        return view('scratch-game::admin.cards.edit', [
            'card' => $card,
            'images' => Image::orderBy('name')->get(['id', 'name', 'file']),
            'rewards' => ScratchReward::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified card.
     */
    public function update(CardRequest $request, ScratchCard $card)
    {
        $data = Arr::except($request->validated(), ['rewards', 'roles']);

        if (! $request->filled('cover_image')) {
            unset($data['cover_image']);
        }

        if (! $request->filled('background_image')) {
            unset($data['background_image']);
        }

        $card->update($data);

        $card->rewards()->sync($request->input('rewards', []));
        $card->roles()->sync($request->input('roles', []));

        return to_route('scratch-game.admin.cards.index')
            ->with('success', trans('scratch-game::admin.cards.status.updated'));
    }

    /**
     * Remove the specified card.
     */
    public function destroy(ScratchCard $card)
    {
        $card->delete();

        return to_route('scratch-game.admin.cards.index')
            ->with('success', trans('scratch-game::admin.cards.status.deleted'));
    }

    /**
     * Toggle card enabled status.
     */
    public function toggleEnabled(ScratchCard $card)
    {
        $card->update(['is_enabled' => ! $card->is_enabled]);

        $message = $card->is_enabled
            ? trans('scratch-game::admin.cards.status.enabled')
            : trans('scratch-game::admin.cards.status.disabled');

        return back()->with('success', $message);
    }
}
