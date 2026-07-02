@extends('layouts.base')

@section('title', $category->name)

@php
$sales = \Azuriom\Plugin\Shop\Models\Coupon::all();
@endphp

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        @if(isset($sales))
        @foreach ($sales as $sale)
        @if($sale->is_enabled)
        @if($sale->is_global)
        <div class="w-full col-span-12 flex flex-col mb-10">
            <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between">
                <div class="text-sm font-medium my-auto truncate">
                    Promotion de {{ $sale->discount }}% sur toute la boutique avec le code {{
                    $sale->code }} jusqu’au {{ $sale->expire_at->format('d/m/y') }} à {{
                    $sale->expire_at->format('G:i')
                    }}
                </div>
                <button class="bg-white/30 rounded-lg py-2 px-4 truncate" data-ripple-dark="true">
                    En profiter
                </button>
            </div>
        </div>
        @else
        <div class="w-full col-span-12 flex flex-col mb-10">
            <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between">
                <div class="text-sm font-medium my-auto truncate">
                    Promotion de {{ $sale->discount }}% sur @if(count($sale->packages) == "1")
                    l'article
                    @else
                    les articles
                    @endif
                    @foreach ($sale->packages as $package)
                    {{ $package->name }},
                    @endforeach
                    avec le code {{
                    $sale->code }} jusqu’au {{ $sale->expire_at->format('d/m/y') }} à {{
                    $sale->expire_at->format('G:i')
                    }}
                </div>
                <button class="bg-white/30 rounded-lg py-2 px-4 truncate" data-ripple-dark="true">
                    En profiter
                </button>
            </div>
        </div>
        @endif
        @endif
        @endforeach
        @endif
        @include('shop::categories._sidebar')
        <div class="w-full col-span-12 xl:col-span-9 mt-10 xl:mt-0 xl:pl-10">
            <div class="bg-steel-100 rounded-2xl">
                <div class="flex flex-raw items-center justify-start py-6 px-8 bg-steel-200 rounded-t-2xl">
                    <div class="flex justify-center items-center w-auto">
                        <img class="-mt-10 rounded-lg mx-auto z-50 w-24" src="{{ theme_asset('img/chest.png') }}">
                        <div class="ml-6 w-full mr-4 text-ellipsis truncate">
                            <h1 class="text-white font-semibold text-2xl">La boutique</h1>
                            <p class="text-xs text-steel-50 font-medium">Retrouvez tous les articles du serveur</p>
                        </div>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-2xl">{{ $category->name }}</span>
                        <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                    </div>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-8">
                        @forelse($category->packages as $id => $package)
                        <div id="dmodal-{{ $id }}"
                            class="hs-overlay hs-overlay-open:translate-x-0 hidden translate-x-full fixed top-0 right-0 transition-all duration-300 transform h-full max-w-md w-full z-[9999] bg-steel-300"
                            tabindex="-1">
                            <div class="relative overflow-hidden h-12 text-center bg-no-repeat bg-center">
                                <div class="absolute top-2 right-2">
                                    <button type="button"
                                        class="py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-steel-100 font-medium bg-steel-200 text-white shadow-sm align-middle hover:bg-steel-100 focus:outline-none text-xs "
                                        data-hs-overlay="#dmodal-{{ $id }}">
                                        Fermer
                                    </button>
                                </div>
                            </div>
                            <div class="overflow-y-auto h-full flex justify-center items-center -mt-8 p-12">
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $package->short_description }}
                                    </h3>
                                    <p class="text-sm text-steel-50">
                                        {!! $package->description !!}
                                    </p>
                                    @if($package->hasImage())
                                    <img class="h-48 mx-auto" src="{{ $package->imageUrl() }}"
                                        alt="{{ $package->name }}">
                                    @endif
                                    <div
                                        class="py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-200 text-white font-semibold transition-all text-xs truncate w-full">
                                        <p class="text-white text-sm font-semibold mr-2 ml-3">
                                            @if($package->isDiscounted())
                                            <del class="text-xs text-danger">{{ $package->getOriginalPrice() }}</del>
                                            @endif
                                            {{ $package->getPrice() }}
                                        </p>
                                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
                                    </div>
                                    @auth
                                    @if($package->isInCart())
                                    <form action="{{ route('shop.cart.remove', $package) }}" method="POST"
                                        class="flex gap-5">
                                        @csrf

                                        <button type="submit"
                                            class="w-full mt-6 w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-danger text-white font-semibold transition-all text-xs truncate">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-6 w-6 mr-0.5"
                                                viewBox="0 0 512 512">
                                                <path d="M296 64h-80a7.91 7.91 0 00-8 8v24h96V72a7.91 7.91 0 00-8-8z"
                                                    fill="none" />
                                                <path
                                                    d="M432 96h-96V72a40 40 0 00-40-40h-80a40 40 0 00-40 40v24H80a16 16 0 000 32h17l19 304.92c1.42 26.85 22 47.08 48 47.08h184c26.13 0 46.3-19.78 48-47l19-305h17a16 16 0 000-32zM192.57 416H192a16 16 0 01-16-15.43l-8-224a16 16 0 1132-1.14l8 224A16 16 0 01192.57 416zM272 400a16 16 0 01-32 0V176a16 16 0 0132 0zm32-304h-96V72a7.91 7.91 0 018-8h80a7.91 7.91 0 018 8zm32 304.57A16 16 0 01320 416h-.58A16 16 0 01304 399.43l8-224a16 16 0 1132 1.14z" />
                                            </svg>
                                            {{ trans('shop::messages.actions.remove') }}
                                        </button>
                                    </form>
                                    @else
                                    <form class="flex gap-5" action="{{ route('shop.packages.buy', $package) }}"
                                        method="POST">
                                        @csrf

                                        @if($package->has_quantity)
                                        <input value="1" type="number" min="0" max="{{ $package->getMaxQuantity() }}"
                                            maxlength="2" name="quantity"
                                            class="w-1/4 mt-6 py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-200 text-white font-semibold text-sm truncate w-full focus:outline-none text-center"
                                            required>
                                        @endif
                                        <button type="submit"
                                            class="w-3/4 mt-6 w-full py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate"
                                            data-ripple-dark="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-6 w-6 mr-0.5"
                                                viewBox="0 0 512 512">
                                                <path xmlns="http://www.w3.org/2000/svg"
                                                    d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z">
                                                </path>
                                            </svg>
                                            {{ trans('shop::messages.buy') }}
                                        </button>
                                    </form>
                                    @endif
                                    @else
                                    <div
                                        class="p-4 rounded-md bg-danger text-white w-full tet-xd font-semibold w-full mt-10">
                                        {{ trans('shop::messages.cart.guest') }}
                                    </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-steel-200" data-hs-overlay="#dmodal-{{ $id }}"
                            data-ripple-dark="true">
                            <div class="flex justify-between px-8 pt-8">
                                <p class="text-white my-auto text-lg font-semibold truncate mr-4 ">
                                    {{ $package->short_description }}
                                </p>
                            </div>
                            <div class="flex w-full">
                                @if($package->hasImage())
                                <img class="h-48 mx-auto my-4" src="{{ $package->imageUrl() }}"
                                    alt="{{ $package->name }}">
                                @endif
                            </div>
                            <div class=" grid md:grid-cols-2 grid-cols-1 gap-8 px-8 pb-8">
                                <div class="text-white font-medium tracking-tighter overflow-hidden my-auto">
                                    <span class="text-2xl font-bold truncate">{{ $package->name }}</span>
                                </div>
                                <div
                                    class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition-all text-xs truncate">
                                    <p class="text-white text-sm font-semibold mr-2 ml-3">
                                        @if($package->isDiscounted())
                                        <del class="text-xs text-danger">{{ $package->getOriginalPrice() }}</del>
                                        @endif
                                        {{ $package->getPrice() }}
                                    </p>
                                    <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 rounded-md bg-danger text-white text-center">
                            Cette catégorie est vide
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection