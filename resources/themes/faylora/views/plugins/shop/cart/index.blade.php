@extends('layouts.base')

@section('title', trans('shop::messages.cart.title'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto md:grid grid-cols-12 gap-8">
        <div class="w-full col-span-12 flex flex-col gap-6">
            @if(session('success'))
            <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="flex w-full py-4 px-5 bg-danger rounded-2xl text-white text-sm justify-between" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div id="status-message"></div>

            @if(use_site_money())
            <div class="flex w-full py-4 px-5 bg-primary rounded-2xl text-white text-sm justify-between">
                <div class="text-sm font-medium my-auto truncate">
                    Créditer votre compte avec des crédits pour pouvoir acheter des coins !
                </div>
                <a href="{{ route('shop.offers.select') }}" class="bg-white/20 rounded-lg py-2 px-4 truncate"
                    data-ripple-dark="true">
                    {{ trans('shop::messages.cart.credit') }}
                </a>
            </div>
            @endif
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl overflow-hidden gap-8">
                <div class="flex flex-raw items-center justify-between w-full">
                    <div class="flex justify-center items-center w-auto overflow-hidden">
                        <div>
                            <img class="absolute h-10 rounded-lg shadow-xl mx-auto z-50"
                                src="{{ auth()->user()->getAvatar(150) }}">
                            <div class="h-10 w-10 bg-steel-300 flex justify-center items-center rounded-lg">
                                <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 w-full mr-4 text-ellipsis truncate">
                            <h4 class="text-white font-semibold text-xs truncate">{{ auth()->user()->name }}</h4>
                        </div>
                    </div>
                    @if(use_site_money())
                    <div>
                        <div
                            class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-12 pl-5 pr-3 text-white">
                            <p class="text-white text-sm font-semibold mr-2 ml-3">{{ auth()->user()->money }}</p>
                            <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
                        </div>
                    </div>
                    @endif
                </div>
                @if(use_site_money())
                <a class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition-all text-xs truncate"
                    href="{{ route('shop.offers.select') }}" data-ripple-dark="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                        <path
                            d="M95.5 104h320a87.73 87.73 0 0111.18.71 66 66 0 00-77.51-55.56L86 94.08h-.3a66 66 0 00-41.07 26.13A87.57 87.57 0 0195.5 104zM415.5 128h-320a64.07 64.07 0 00-64 64v192a64.07 64.07 0 0064 64h320a64.07 64.07 0 0064-64V192a64.07 64.07 0 00-64-64zM368 320a32 32 0 1132-32 32 32 0 01-32 32z">
                        </path>
                        <path
                            d="M32 259.5V160c0-21.67 12-58 53.65-65.87C121 87.5 156 87.5 156 87.5s23 16 4 16-18.5 24.5 0 24.5 0 23.5 0 23.5L85.5 236z">
                        </path>
                    </svg>
                    Créditer mon compte
                </a>
                @endif
            </div>
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl gap-8">
                <div class="flex flex-col">
                    <span class="text-white font-bold text-2xl">Votre panier</span>
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
                @if(! $cart->isEmpty())
                <form action="{{ route('shop.cart.update') }}" method="POST" class="flex flex-col gap-8">
                    @csrf
                    <div class="flex md:flex-row flex-col gap-8">
                        <button type="submit"
                            class="w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition-all text-xs truncate"
                            data-ripple-dark="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5"
                                viewBox="0 0 512 512">
                                <path d="M320 146s24.36-12-64-12a160 160 0 10160 160" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"></path>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="32" d="M256 58l80 80-80 80"></path>
                            </svg>
                            {{ trans('messages.actions.update') }}
                        </button>
                        <button type="submit"
                            class="w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-danger text-white font-semibold transition-all text-xs truncate"
                            formaction="{{ route('shop.cart.clear') }}" data-ripple-dark="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5"
                                viewBox="0 0 512 512">
                                <path d="M296 64h-80a7.91 7.91 0 00-8 8v24h96V72a7.91 7.91 0 00-8-8z" fill="none">
                                </path>
                                <path
                                    d="M432 96h-96V72a40 40 0 00-40-40h-80a40 40 0 00-40 40v24H80a16 16 0 000 32h17l19 304.92c1.42 26.85 22 47.08 48 47.08h184c26.13 0 46.3-19.78 48-47l19-305h17a16 16 0 000-32zM192.57 416H192a16 16 0 01-16-15.43l-8-224a16 16 0 1132-1.14l8 224A16 16 0 01192.57 416zM272 400a16 16 0 01-32 0V176a16 16 0 0132 0zm32-304h-96V72a7.91 7.91 0 018-8h80a7.91 7.91 0 018 8zm32 304.57A16 16 0 01320 416h-.58A16 16 0 01304 399.43l8-224a16 16 0 1132 1.14z">
                                </path>
                            </svg>
                            {{ trans('shop::messages.cart.clear') }}
                        </button>
                    </div>
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="text-left">
                                <th class="p-0">
                                    <div class="flex items-center h-14 py-3 px-6 rounded-l-xl bg-steel-300">
                                        <label class="ml-2 text-xs text-white font-semibold">{{
                                            trans('messages.fields.name') }}</label>
                                    </div>
                                </th>
                                <th class=" p-0 hidden xl:block">
                                    <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                        <label class="ml-2 text-xs text-white font-semibold">{{
                                            trans('shop::messages.fields.price') }}</label>
                                    </div>
                                </th>
                                <th class=" p-0">
                                    <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                        <label class="ml-2 text-xs text-white font-semibold">{{
                                            trans('shop::messages.fields.total') }}</label>
                                    </div>
                                </th>
                                <th class=" p-0 hidden xl:block">
                                    <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                        <label class="ml-2 text-xs text-white font-semibold">{{
                                            trans('shop::messages.fields.quantity') }}</label>
                                    </div>
                                </th>
                                <th class=" p-0">
                                    <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                        <label class="ml-2 text-xs text-white font-semibold">{{
                                            trans('messages.fields.action') }}</label>
                                    </div>
                                </th>
                                <th class=" p-0">
                                    <div class="flex items-center h-14 py-3 px-6 rounded-r-xl bg-steel-300">
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->content() as $cartItem)
                            <tr>
                                <td class="p-0">
                                    <div class="flex items-center h-16 px-6">
                                        <div class="flex h-full items-center">
                                            <span class="text-sm font-medium text-gray-100">{{ $cartItem->name()
                                                }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 hidden xl:block">
                                    <div class="flex items-center h-16 px-6">
                                        <div
                                            class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white">
                                            <p class="text-white text-sm font-semibold mr-2">{{ $cartItem->price() }}
                                            </p>
                                            <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0">
                                    <div class="flex items-center h-16 px-6">
                                        <div
                                            class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white">
                                            <p class="text-white text-sm font-semibold mr-2">{{ $cartItem->total() }}
                                            </p>
                                            <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 hidden xl:block">
                                    <div class="flex items-center h-16 px-6">
                                        <input type="number"
                                            class="py-1 px-1 bg-steel-300 rounded-xl w-10 h-10 text-white focus:outline-none text-center text-xs font-semibold"
                                            min="0" max="{{ $cartItem->maxQuantity() }}"
                                            name="quantities[{{ $cartItem->itemId }}]" maxlength="2"
                                            value="{{ $cartItem->quantity }}"
                                            aria-label="{{ trans('shop::messages.fields.quantity') }}" required
                                            @if(!$cartItem->hasQuantity()) readonly @endif>
                                    </div>
                                </td>
                                <td class="p-0">
                                    <div class="flex items-center h-16 px-6">
                                        <a href="{{ route('shop.cart.remove', $cartItem->id) }}"><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="fill-danger transition duration-200 h-5 w-5"
                                                viewBox="0 0 512 512">
                                                <rect x="32" y="48" width="448" height="80" rx="32" ry="32" />
                                                <path
                                                    d="M74.45 160a8 8 0 00-8 8.83l26.31 252.56a1.5 1.5 0 000 .22A48 48 0 00140.45 464h231.09a48 48 0 0047.67-42.39v-.21l26.27-252.57a8 8 0 00-8-8.83zm248.86 180.69a16 16 0 11-22.63 22.62L256 318.63l-44.69 44.68a16 16 0 01-22.63-22.62L233.37 296l-44.69-44.69a16 16 0 0122.63-22.62L256 273.37l44.68-44.68a16 16 0 0122.63 22.62L278.62 296z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($cart->giftcards()->isEmpty())
                    <div class="flex flex-row">
                        <h1 class="text-white text-lg font-semibold my-auto">Total : </h1>
                        <div
                            class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white my-auto ml-4">
                            <p class="text-white text-sm font-semibold mr-2">{{ $cart->total() }}</p>
                            <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                        </div>
                    </div>
                    @endif
                </form>


                @if($cart->coupons()->isEmpty())
                @if($cart->giftcards()->isEmpty())
                @if(use_site_money())
                <form method="POST" action="{{ route('shop.cart.payment') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                        data-ripple-dark="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                            </path>
                        </svg>
                        {{ trans('shop::messages.cart.pay') }}
                    </button>
                </form>
                @else
                <a class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                    href="{{ route('shop.payments.payment') }}" data-ripple-dark="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                        </path>
                    </svg>
                    {{ trans('shop::messages.cart.checkout') }}
                </a>
                @endif
                @endif
                @endif
                @else
                <div class="flex w-full py-4 px-5 bg-danger rounded-2xl text-white text-sm justify-between">
                    <div class="text-sm font-medium my-auto truncate">
                        {{ trans('shop::messages.cart.empty') }}
                    </div>
                </div>
                @endif
            </div>
            @if(! $cart->isEmpty())
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl gap-8">
                <div class="flex flex-col">
                    <span class="text-white font-bold text-2xl">Code promotionel</span>
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
                <form action="{{ route('shop.cart.coupons.add') }}" method="POST"
                    class="flex md:flex-row flex-col gap-8">
                    @csrf

                    <input
                        class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition text-xs truncate focus:outline-none md:w-2/3 w-full placeholder-steel-50 @error('code') is-invalid @enderror"
                        placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code"
                        value="{{ old('code') }}">
                    <button type="submit"
                        class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold text-xs truncate md:w-1/3 w-full"
                        data-ripple-dark="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                            <path xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                d="M256 112v288M400 256H112" />
                        </svg>
                        {{ trans('messages.actions.add') }}
                    </button>

                    @error('code')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </form>
                @if(! $cart->coupons()->isEmpty())
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="text-left">
                            <th class="p-0">
                                <div class="flex items-center h-14 py-3 px-6 rounded-l-xl bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.name') }}</label>
                                </div>
                            </th>
                            <th class=" p-0 hidden xl:block">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('shop::messages.fields.discount') }}</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.action') }}</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->coupons() as $coupon)
                        <tr>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6">
                                    <div class="flex h-full items-center">
                                        <span class="text-sm font-medium text-gray-100">{{ $coupon->code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-0 hidden xl:block">
                                <div class="flex items-center h-16 px-6">
                                    <div
                                        class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white">
                                        <p class="text-white text-sm font-semibold mr-2">{{ $coupon->is_fixed ?
                                            shop_format_amount($coupon->discount) : $coupon->discount.' %' }}
                                        </p>
                                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                                    </div>
                                </div>
                            </td>
                            <td class="p-0">
                                <form action="{{ route('shop.cart.coupons.remove', $coupon) }}" method="POST"
                                    class="flex items-center h-16 px-6">
                                    @csrf

                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                                            class="fill-danger transition duration-200 h-5 w-5" viewBox="0 0 512 512">
                                            <rect x="32" y="48" width="448" height="80" rx="32" ry="32" />
                                            <path
                                                d="M74.45 160a8 8 0 00-8 8.83l26.31 252.56a1.5 1.5 0 000 .22A48 48 0 00140.45 464h231.09a48 48 0 0047.67-42.39v-.21l26.27-252.57a8 8 0 00-8-8.83zm248.86 180.69a16 16 0 11-22.63 22.62L256 318.63l-44.69 44.68a16 16 0 01-22.63-22.62L233.37 296l-44.69-44.69a16 16 0 0122.63-22.62L256 273.37l44.68-44.68a16 16 0 0122.63 22.62L278.62 296z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($cart->giftcards()->isEmpty())
                <div class="flex flex-row">
                    <h1 class="text-white text-lg font-semibold my-auto">Total : </h1>
                    <div
                        class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white my-auto ml-4">
                        <p class="text-white text-sm font-semibold mr-2">{{ $cart->total() }}</p>
                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                    </div>
                </div>
                @endif

                @if($cart->giftcards()->isEmpty())
                @if(use_site_money())
                <form method="POST" action="{{ route('shop.cart.payment') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                        data-ripple-dark="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                            </path>
                        </svg>
                        {{ trans('shop::messages.cart.pay') }}
                    </button>
                </form>
                @else
                <a class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                    href="{{ route('shop.payments.payment') }}" data-ripple-dark="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                        </path>
                    </svg>
                    {{ trans('shop::messages.cart.checkout') }}
                </a>
                @endif
                @endif
                @endif
            </div>
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl gap-8">
                <div class="flex flex-col">
                    <span class="text-white font-bold text-2xl">{{ trans('shop::messages.giftcards.add') }}</span>
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
                <form action="{{ route('shop.cart.giftcards.add') }}" method="POST"
                    class="flex md:flex-row flex-col gap-8">
                    @csrf

                    <input
                        class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition text-xs truncate focus:outline-none md:w-2/3 w-full placeholder-steel-50 @error('code') is-invalid @enderror"
                        placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code"
                        value="{{ old('code') }}">
                    <button type="submit"
                        class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold text-xs truncate md:w-1/3 w-full"
                        data-ripple-dark="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                            <path xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                d="M256 112v288M400 256H112" />
                        </svg>
                        {{ trans('messages.actions.add') }}
                    </button>

                    @error('code')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </form>
                @if(! $cart->giftcards()->isEmpty())
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="text-left">
                            <th class="p-0">
                                <div class="flex items-center h-14 py-3 px-6 rounded-l-xl bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.name') }}</label>
                                </div>
                            </th>
                            <th class=" p-0 hidden xl:block">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('shop::messages.fields.discount') }}</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.action') }}</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->giftcards() as $giftcard)
                        <tr>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6">
                                    <div class="flex h-full items-center">
                                        <span class="text-sm font-medium text-gray-100">{{ $giftcard->code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-0 hidden xl:block">
                                <div class="flex items-center h-16 px-6">
                                    <div
                                        class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white">
                                        <p class="text-white text-sm font-semibold mr-2">{{ $giftcard->balance }}
                                        </p>
                                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                                    </div>
                                </div>
                            </td>
                            <td class="p-0">
                                <form action="{{ route('shop.cart.giftcards.remove', $giftcard) }}" method="POST"
                                    class="flex items-center h-16 px-6">
                                    @csrf

                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                                            class="fill-danger transition duration-200 h-5 w-5" viewBox="0 0 512 512">
                                            <rect x="32" y="48" width="448" height="80" rx="32" ry="32" />
                                            <path
                                                d="M74.45 160a8 8 0 00-8 8.83l26.31 252.56a1.5 1.5 0 000 .22A48 48 0 00140.45 464h231.09a48 48 0 0047.67-42.39v-.21l26.27-252.57a8 8 0 00-8-8.83zm248.86 180.69a16 16 0 11-22.63 22.62L256 318.63l-44.69 44.68a16 16 0 01-22.63-22.62L233.37 296l-44.69-44.69a16 16 0 0122.63-22.62L256 273.37l44.68-44.68a16 16 0 0122.63 22.62L278.62 296z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex flex-row">
                    <h1 class="text-white text-lg font-semibold my-auto">Total : </h1>
                    <div
                        class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-10 pl-5 pr-4 text-white my-auto ml-4">
                        <p class="text-white text-sm font-semibold mr-2">{{ $cart->payableTotal() }}</p>
                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                    </div>
                </div>

                @if(use_site_money())
                <form method="POST" action="{{ route('shop.cart.payment') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                        data-ripple-dark="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                            <path xmlns="http://www.w3.org/2000/svg"
                                d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                            </path>
                        </svg>
                        {{ trans('shop::messages.cart.pay') }}
                    </button>
                </form>
                @else
                <a class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                    href="{{ route('shop.payments.payment') }}" data-ripple-dark="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                        </path>
                    </svg>
                    {{ trans('shop::messages.cart.checkout') }}
                </a>
                @endif
                @endif
            </div>
        </div>
        @endif
    </div>
</main>
@endsection