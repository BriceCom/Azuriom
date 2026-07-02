<?php

namespace Azuriom\Plugin\Tebex\Controllers\Api;

use Illuminate\Http\Request;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tebex\Cart\Cart;
use Azuriom\Plugin\Tebex\Models\TebexPackage;
use Azuriom\Plugin\Tebex\Services\TebexApiService;
use Azuriom\Plugin\Tebex\Services\TebexShopService;
use Exception;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * @var TebexApiService
     */
    protected $apiService;

    /**
     * @var TebexShopService
     */
    protected $shopService;

    /**
     * ApiController constructor.
     *
     * @param TebexApiService $apiService
     * @param TebexShopService $shopService
     */
    public function __construct(TebexApiService $apiService, TebexShopService $shopService)
    {
        $this->apiService = $apiService;
        $this->shopService = $shopService;
    }

    /**
     * Process a package purchase using the shop plugin's cart system.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request)
    {
        if (strlen($request->username) < 3 || !is_numeric($request->package_id)) {
            return response()->json(['message' => 'Wrong settings!'], 404);
        }

        try {
            // Store the username in the session for later use
            session(['tebex_username' => $request->username]);

            // Get the package data from the Tebex API
            $categories = $this->shopService->getShopData();
            $package = null;

            // Find the package in the categories
            foreach ($categories as $category) {
                // Check in the category's packages
                foreach ($category->packages as $p) {
                    if ($p->id == $request->package_id) {
                        $package = $p;
                        break 2;
                    }
                }

                // Check in the subcategories' packages
                if (!$package) {
                    foreach ($category->subcategories as $subcategory) {
                        foreach ($subcategory->packages as $p) {
                            if ($p->id == $request->package_id) {
                                $package = $p;
                                break 3;
                            }
                        }
                    }
                }
            }

            if (!$package) {
                return response()->json(['message' => 'Package not found'], 404);
            }

            // Create a TebexPackage object
            $tebexPackage = TebexPackage::fromPackageObject($package);

            // Add the package to the shop plugin's cart
            $cart = Cart::fromSession($request->session());
            $cart->add($tebexPackage, $request->input('quantity') ?? 1);

            // Redirect to the shop plugin's cart page
            return response()->json([
                'redirect_url' => route('shop.cart.index')
            ], 200);
        } catch (Exception $e) {
            Log::error('Tebex checkout error: ' . $e->getMessage());
            return response()->json(['message' => trans('tebex::admin.errors.nickname')], 500);
        }
    }

}
