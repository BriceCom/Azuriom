<?php

namespace Azuriom\Plugin\Shop\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\AlternativeCurrency\Models\User;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Package;
use Azuriom\Support\Markdown;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the user cart.
     */
    public function index(Request $request)
    {
        $terms = setting('shop.required_terms');
        $cart = Cart::fromSession($request->session());

        $alternativeCurrency = plugins()->isEnabled('alternative-currency') === true && $cart->totalAlternative()>0;
        $userAlternativeCurrency = null;

        if($alternativeCurrency){
            $userAlternativeCurrency = \Azuriom\Plugin\AlternativeCurrency\Models\User::whereUserId(Auth::id())->whereCoinId(ac_shop_currency_id())->with('coin')->get()->first();
        }
        if ($terms !== null) {
            $markdown = Markdown::parse($terms, true);

            $terms = new HtmlString(Str::between($markdown, '<p>', '</p>'));
        }

        return view('shop::cart.index', [
            'cart' => $cart,
            'terms' => $terms,
            'alternativeCurrency' => $alternativeCurrency,
            'userAlternativeCurrency' => $userAlternativeCurrency,
        ]);
    }

    /**
     * Remove a package from the cart.
     */
    public function remove(Request $request, Package $package)
    {
        $cart = Cart::fromSession($request->session());

        $cart->remove($package);

        return to_route('shop.cart.index');
    }

    /**
     * Update the quantity of the items in the cart.
     */
    public function update(Request $request)
    {
        $cart = Cart::fromSession($request->session());

        foreach ($request->input('quantities', []) as $id => $quantity) {
            $item = $cart->getById($id);

            if ($item !== null && $quantity > 0) {
                $item->setQuantity($quantity);
            }

            $cart->save();
        }

        return to_route('shop.cart.index');
    }

    /**
     * Clear the user cart.
     */
    public function clear(Request $request)
    {
        Cart::fromSession($request->session())->clear();

        return to_route('shop.cart.index');
    }

    /**
     * Pay using the website money.
     */
    public function payment(Request $request)
    {
        if (! use_site_money()) {
            return to_route('shop.cart.index');
        }

        $cart = Cart::fromSession($request->session());

        if ($cart->isEmpty()) {
            return to_route('shop.cart.index');
        }

        $user = $request->user();
        $total = $cart->payableTotal();

        if (! $user->hasMoney($total)) {
            return to_route('shop.cart.index')->with('error', trans('shop::messages.cart.errors.money'));
        }

        $user->removeMoney($total);

        try {
            payment_manager()->buyPackages($cart);
        } catch (Exception $e) {
            report($e);

            $user->addMoney($total);

            return to_route('shop.cart.index')->with('error', trans('shop::messages.cart.errors.execute'));
        }

        $cart->destroy();

        return to_route('shop.home')->with('success', trans('shop::messages.cart.success'));
    }

    public function alternativePayment(Request $request){
        if (! use_site_money()) {
            return to_route('shop.cart.index');
        }

        $cart = Cart::fromSession($request->session());

        if ($cart->isEmpty()) {
            return to_route('shop.cart.index');
        }

        $user = $request->user();
        $total = $cart->totalAlternative();

        $userCoin = User::whereUserId($user->id)->whereCoinId(ac_shop_currency_id())->with('coin')->get()->first();

        if (! $userCoin->hasAmount($total)) {
            return to_route('shop.cart.index')->with('error', "Vous n'avez pas assez de ". $userCoin->coin->name);
        }

        $userCoin->removeAmount($total);

        try {
            payment_manager()->buyPackagesWithAlternativeCurrency($cart);
        } catch (Exception $e) {
            report($e);

            $userCoin->addAmount($total);

            return to_route('shop.cart.index')->with('error', trans('shop::messages.cart.errors.execute'));
        }

        // Vérifier si la propriété alternative_price est supérieure à 0
        $filteredItems = $cart->content()->filter(function ($cartItem) {
            return $cartItem->buyable()->alternative_price > 0;
        });

        // On boucle sur chaque article et on supprime
        $filteredItems->each(function ($cartItem) use ($cart) {
            $cart->remove($cartItem->buyable());
        });

        return to_route('shop.home')->with('success', trans('shop::messages.cart.success'));
    }
}
