@extends('layouts.app')

@section('title', setting("tebex.shop.title", trans("tebex::messages.shop")))

@include('elements.section')

@section('content')

<div class="profile-spacer"></div>

<div class="shop-wrapper">

    {{-- TITRE --}}
    <h1 class="shop-title">
        {{ setting("tebex.shop.title", trans("tebex::messages.shop")) }}
    </h1>

    @if(setting("tebex.shop.subtitle"))
        <p class="shop-subtitle">{{ setting("tebex.shop.subtitle") }}</p>
    @endif

    <div class="shop-layout">

        {{-- SIDEBAR --}}
        <aside class="shop-sidebar">
            @include('tebex::categories._sidebar')
        </aside>

        {{-- CONTENU PRINCIPAL --}}
        <main class="shop-products-area">

            {{-- MESSAGE D'ACCUEIL --}}
            @if(setting('tebex.shop.home.message'))
                <div class="shop-home-message">
                    {!! setting('tebex.shop.home.message') !!}
                </div>
            @endif

            {{-- GRILLE DES PRODUITS --}}
            <div class="shop-products">

{{--                @forelse($packages as $package)--}}
{{--                    <div class="shop-card-wrapper">--}}
{{--                        @include('tebex::packages.card', ['package' => $package])--}}
{{--                    </div>--}}

{{--                @empty--}}

{{--                    <div class="shop-empty">--}}
{{--                        {{ trans('tebex::messages.categories.empty') }}--}}
{{--                    </div>--}}

{{--                @endforelse--}}

            </div>

            @include('tebex::packages.show')


        </main>

    </div>

</div>

<div class="profile-bottom-spacer"></div>

{{-- MODAL PRODUIT --}}
@include('tebex::packages.show')

@endsection

@push('scripts')
    @include('tebex::components.store.scripts')
@endpush
