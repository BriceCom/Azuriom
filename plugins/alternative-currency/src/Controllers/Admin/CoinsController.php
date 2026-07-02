<?php

namespace Azuriom\Plugin\AlternativeCurrency\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Image;
use Azuriom\Plugin\AlternativeCurrency\Models\Coin;
use Azuriom\Plugin\AlternativeCurrency\Request\CoinsRequest;

class CoinsController extends Controller
{

    public function index()
    {
        $coins = Coin::all();

        return view('alternative-currency::admin.coins.index', compact('coins'));
    }

    public function create(){
        return view('alternative-currency::admin.coins.create', [
            'images' => Image::all()
        ]);
    }

    public function edit(Coin $coin){
        return view('alternative-currency::admin.coins.edit', [
            'images' => Image::all(),
            'coin' => $coin
        ]);
    }

    public function store(CoinsRequest $request){
        Coin::create($request->validated());

        return redirect()->route('alternative-currency.admin.coins.index')->with('success', "Coin crée avec succès.");
    }

    public function update(CoinsRequest $request, Coin $coin){
        $coin->update($request->validated());

        return redirect()->route('alternative-currency.admin.coins.index')->with('success', "Coin mis à jour avec succès.");
    }

    public function destroy(Coin $coin){
        $coin->delete();

        return redirect()->route('alternative-currency.admin.coins.index')->with('success', "Coin supprimé avec succès.");
    }

}
