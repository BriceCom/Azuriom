<?php

namespace Azuriom\Plugin\Tebex\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tebex\Cart\Cart;
use Azuriom\Plugin\Tebex\Models\TebexPackage;
use Azuriom\Plugin\Tebex\Services\TebexShopService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * @var TebexShopService
     */
    protected $shopService;

    /**
     * PackageController constructor.
     *
     * @param TebexShopService $shopService
     */
    public function __construct(TebexShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    /**
     * Display the specified package.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = $this->shopService->getPackage($id);

        if (!$package) {
            abort(404);
        }

        return view('tebex::packages.show', ['package' => $package]);
    }

    /**
     * Buy the specified package.
     *
     * @param Request $request
     * @param int $package
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request, $package)
    {
        $this->validate($request, [
            'quantity' => 'nullable|integer',
        ]);

        $packageObj = $this->shopService->getPackage($package);

        if (!$packageObj) {
            abort(404);
        }

        $user = $request->user();
        $cart = Cart::fromSession($request->session());

        if ($packageObj->getMaxQuantity() < 1) {
            return redirect()->back()->with('error', trans('tebex::messages.packages.limit'));
        }

        $cart->add($packageObj, $request->input('quantity') ?? 1);

        return redirect()->route('tebex.cart.index');
    }

    /**
     * Show package variables/options.
     *
     * @param Request $request
     * @param int $package
     * @return \Illuminate\Http\Response
     */
    public function showVariables(Request $request, $package)
    {
        // Tebex packages don't support variables yet, so we'll just redirect to buy
        return $this->buy($request, $package);
    }
}
