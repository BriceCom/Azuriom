<?php

namespace Azuriom\Plugin\AlternativeCurrency\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\AlternativeCurrency\Models\Coin;
use Azuriom\Plugin\AlternativeCurrency\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GiveController extends Controller
{

    /**
     * Affiche al liste des utilisateurs et formulaire
     */
    public function index()
    {
        $users = \Azuriom\Models\User::all();
        $coins = Coin::all();

        $search = request('search');

        $usersPaginate = User::with(['coin', 'user'])
            ->when($search, fn (Builder $query) => $query->search($search))
            ->latest()
            ->paginate();

        return view('alternative-currency::admin.give.index', [
            'users' => $users,
            'usersPaginate' => $usersPaginate,
            'coins' => $coins,
            'search' => $search,
        ]);
    }


    /**
     * Enregistre un nouveau montant pour un utilisateur
     */
    public function store()
    {
        $type = request('type');

        request()->validate([
            'user' => 'required',
            'coin' => 'required',
            'amount' => 'required|numeric|min:0.01'
        ]);

        // Récupère l'utilisateur si existant
        $findUser = User::whereUserId(request('user'));

        if($findUser->exists()){
            // Récupère si le joueur a ce coin
            $findData = $findUser->whereCoinId(request('coin'))->first();

            if($findData){
                // Si on est sur le point de donner
                if($type === "give"){
                    $findData->addAmount(request('amount'));

                } else {
                    // L'utilisateur a assez de coin
                    if($findData->hasAmount(request('amount'))){
                        $findData->removeAmount(request('amount'));
                        return redirect()->route('alternative-currency.admin.give.index')->with('success', "Le montant du joueur a été correctement débité.");
                    }

                    return redirect()->route('alternative-currency.admin.give.index')->with('error', "Le joueur serai en négatif...");
                }

                return redirect()->route('alternative-currency.admin.give.index')->with('success', "Le montant du joueur a été correctement crédité.");
            }
        }

        if($type === "give"){
            User::create([
                'user_id' => request('user'),
                'coin_id' => request('coin'),
                'amount' => request('amount')
            ]);

            return redirect()->route('alternative-currency.admin.give.index')->with('success', "Le joueur a bien été crédité.");
        }

        return redirect()->route('alternative-currency.admin.give.index')->with('error', "Le joueur n'a surement pas ce coin.");
    }

}
