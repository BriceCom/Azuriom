<?php

namespace Azuriom\Plugin\Tebex\Controllers\Api;

use Illuminate\Http\Request;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tebex\Services\TebexApiService;

class ApiController extends Controller
{
    public function buy(Request $request, TebexApiService $api)
    {
        if (strlen($request->username) < 3 || !is_numeric($request->package_id)) {
            return response()->json(['message' => trans('tebex::admin.errors.wrong_settings')], 404);
        }

        try {
            $token = $api->getConfiguredPublicKeyOrAbort();

            $basket = $api->createBasketWithFallback($token, [
                'complete' => url('/'),
                'cancel' => url('/')
            ], $request->username);

            if(!$basket) throw new \Exception(trans('tebex::admin.errors.nickname'));

            $ident = $basket['ident'] ?? $basket['data']['ident'];

            $api->addPackagesToBasket($ident, [['package_id' => $request->package_id, 'quantity' => 1]]);

            $basketInfo = $api->getBasket($token, $ident);
            $url = $basketInfo['links']['checkout'] ?? ($basketInfo['data']['links']['checkout'] ?? null);

            return response()->json(['checkout_url' => $url], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
