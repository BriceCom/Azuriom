<?php

namespace Azuriom\Plugin\AlternativeCurrency\Controllers\Api;


use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\AlternativeCurrency\Models\Coin;
use Azuriom\Plugin\AlternativeCurrency\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    // Voir toute la monnaie d'un joueur spécifique
    public function getMoneyOfUser($id)
    {
        $user = User::whereUserId($id)->with('coin')->get();

        if($user->isEmpty()) {
            return response()->json([
                'error' => 'Le joueur n\'existe pas.',
            ], 404);
        }

        return response()->json($user);
    }

    // Voir la monnaie d'un joueur spécifique
    public function getCoin($id)
    {
        $coin = Coin::find($id);

        if(!$coin) {
            return response()->json([
                'error' => 'Le coin n\'existe pas.',
            ], 404);
        }

        return response()->json($coin);
    }

    // Voir la monnaie d'un joueur spécifique
        public function addCoinToUser(Request $request)
    {
        $coin = Coin::find($request->coinId);

        if(!$coin) {
            return response()->json([
                'error' => 'Le coin n\'existe pas.',
            ], 404);
        }

        $user = \Azuriom\Models\User::find($request->userId);

        if(!$user) {
            return response()->json([
                'error' => 'Le joueur n\'est pas inscrit sur le site.',
            ], 404);
        }

        if(!$request->amount) {
            return response()->json([
                'error' => 'Le montant `amount` est obligatoire.',
            ], 404);
        }


        $findUser = User::whereUserId($request->userId);

        if(isset($findUser)){
            $findData = $findUser->whereCoinId($request->coinId)->first();

            if($findData){
                $findData->addAmount($request->amount);

                return response()->json([
                    'success' => 'Le joueur a bien été crédité ' . request('amount') . ' ' . $coin->name . '.',
                ], 404);
            }
        }

        User::create([
            'user_id' => request('userId'),
            'coin_id' => request('coinId'),
            'amount' => request('amount')
        ]);


        return response()->json([
            'success' => 'Ce joueur n\'avait pas ce coin, il a donc bien été ajouté et crédité de ' . request('amount') . ' ' . $coin->name . '.',
        ], 404);
    }
}
