<?php

namespace Azuriom\Plugin\Tebex\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tebex\Cart\Cart;
use Azuriom\Plugin\Tebex\Models\TebexPackage;
use Azuriom\Plugin\Tebex\Services\TebexApiService;
use Azuriom\Plugin\Tebex\Services\TebexShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class CartController extends Controller
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
     * CartController constructor.
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
     * Display the user cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('tebex::cart.index', [
            'cart' => Cart::fromSession($request->session()),
        ]);
    }


    /**
     * Remove a package from the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, $id)
    {
        $cart = Cart::fromSession($request->session());
        $cart->removeById($id);

        return redirect()->route('tebex.cart.index');
    }

    /**
     * Update the quantity of the items in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cart = Cart::fromSession($request->session());

        foreach ($request->input('quantities', []) as $id => $quantity) {
            $item = $cart->getById($id);

            if ($item !== null && $quantity > 0) {
                $item->setQuantity($quantity);
            }
        }

        $cart->save();

        return redirect()->route('tebex.cart.index');
    }

    /**
     * Clear the user cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clear(Request $request)
    {
        Cart::fromSession($request->session())->clear();

        return redirect()->route('tebex.cart.index');
    }

    /**
     * Update the Minecraft username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUsername(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|min:3',
        ]);

        session(['tebex_username' => $request->username]);

        return redirect()->route('tebex.cart.index')->with('success', trans('tebex::messages.cart.username_updated'));
    }

    /**
     * Pay using the website money.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        if (! function_exists('use_site_money') || ! use_site_money()) {
            return redirect()->route('tebex.cart.index');
        }

        $cart = Cart::fromSession($request->session());

        if ($cart->isEmpty()) {
            return redirect()->route('tebex.cart.index');
        }

        $user = $request->user();
        $total = $cart->total();

        if (! $user->hasMoney($total)) {
            return redirect()->route('tebex.cart.index')->with('error', trans('tebex::messages.cart.errors.money'));
        }

        $user->removeMoney($total);

        try {
            $result = $this->processCartCheckout($cart);

            if (!$result['success']) {
                $user->addMoney($total);
                return $result['redirect'];
            }

            // Redirect to the payment URL from the basket
            return redirect($result['basket']->links->payment);
        } catch (Exception $e) {
            Log::error('Tebex payment error: ' . $e->getMessage());

            $user->addMoney($total);

            return redirect()->route('tebex.cart.index')->with('error', trans('tebex::messages.cart.errors.execute'));
        }
    }

    /**
     * Proceed to checkout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $cart = Cart::fromSession($request->session());

        if ($cart->isEmpty()) {
            return redirect()->route('tebex.cart.index')->with('error', trans('tebex::messages.cart.empty'));
        }

        try {
            $result = $this->processCartCheckout($cart);

            if (!$result['success']) {
                return $result['redirect'];
            }

            // Redirect to the checkout URL from the basket
            return redirect($result['basket']->links->checkout);
        } catch (Exception $e) {
            Log::error('Tebex checkout error: ' . $e->getMessage());
            return redirect()->route('tebex.cart.index')->with('error', trans('tebex::messages.cart.checkout_error'));
        }
    }

    /**
     * Process the cart checkout by creating a basket and adding all items to it.
     * This method is used by both payment and checkout methods.
     *
     * @param  \Azuriom\Plugin\Tebex\Cart\Cart  $cart
     * @return array An array with 'success' boolean, 'redirect' response if success is false, and 'basket' object if success is true
     */
    private function processCartCheckout(Cart $cart)
    {
        $username = session('tebex_username');

        if (!$username) {
            return [
                'success' => false,
                'redirect' => redirect()->route('tebex.cart.index')->with('error', trans('tebex::messages.cart.username_required'))
            ];
        }

        try {
            // Create a new basket with the username
            Log::debug('Creating new basket with username', ['username' => $username]);
            $basket = $this->apiService->createBasket(null, null, true, [], $username);
            Log::debug('Basket created', ['basket_id' => $basket->id, 'basket_ident' => $basket->ident]);

            // Add each item from the cart to the basket
            foreach ($cart->content() as $item) {
                if ($item->buyable() instanceof TebexPackage) {
                    $packageId = $item->buyable()->getId();
                    $quantity = $item->quantity;

                    Log::debug('Adding package to basket', ['package_id' => $packageId, 'quantity' => $quantity]);
                    // Add the package to the basket
                    $this->apiService->addPackageToBasket($basket->ident, $packageId, $quantity);
                }
            }

            // Username is already set during basket creation, but let's log it for clarity
            Log::debug('Username was set during basket creation', ['username' => $username]);

            // Clear the cart
            $cart->clear();

            return [
                'success' => true,
                'basket' => $basket
            ];
        } catch (Exception $e) {
            Log::error('Tebex checkout error: ' . $e->getMessage(), ['exception' => $e]);
            return [
                'success' => false,
                'redirect' => redirect()->route('tebex.cart.index')->with('error', trans('tebex::messages.cart.checkout_error'))
            ];
        }
    }
}
