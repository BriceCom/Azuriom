@extends('layouts.app')

@section('title', setting("tebex.shop.title", trans("tebex::messages.shop")))

@section('content')

@php
    $i = 0;
    $y = 0;
@endphp
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-9">
                @auth
                    <div class="card bg-primary bg-opacity-25 border-0">
                        <div class="card-body d-flex gap-3">
                            @auth
                                <img class="shop-profil" src="{{Auth::user()->getAvatar(96)}}" alt="Avatar de {{Auth::user()->name}}">
                                <div class="w-100 d-flex flex-column">
                                    <span class="fw-bold h5 mb-0">Bienvenue {{Auth::user()->name}}</span>
                                    <div>
                                        <small class="badge" style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->role->name}}</small>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                @endauth

                <div class="col-9">
                    <div class="d-flex flex-wrap justify-content-center gap-4 my-4" role="tablist">
                        @if(setting('tebex.shop.home', true))
                            <a class="text-decoration-none fw-bold h5 @if($i == 0) text-white text-decoration-underline active @else text-white-50 @endif" data-bs-toggle="tab" data-bs-target="#pill-home" type="button" role="tab" aria-controls="pill-home" aria-selected="true">
                                <i class="bi bi-house-door"></i> {{ trans('tebex::messages.home.home') }}
                            </a>
                            @php $i++ @endphp
                        @endif
                        @foreach($categories as $categorie)
                            <a class="text-decoration-none fw-bold h5 @if($i == 0) text-white text-decoration-underline active @else text-white-50 @endif" data-bs-toggle="tab" data-bs-target="#pill-{{ $categorie->id }}" type="button" role="tab" aria-controls="pill-{{ $categorie->id }}" aria-selected="true">
                                {{ $categorie->name }}
                            </a>
                            @foreach($categorie->subcategories as $subCategorie)
                                <a class="text-decoration-none fw-bold h5" data-bs-toggle="tab" data-bs-target="#pill-{{ $subCategorie->id }}" type="button" role="tab" aria-controls="pill-{{ $subCategorie->id }}" aria-selected="true">
                                    <i class="bi bi-arrow-return-right"></i>
                                    {{ $subCategorie->name }}
                                </a>
                            @endforeach
                            @php $i++ @endphp
                        @endforeach
                    </div>
                </div>
                <div class="tab-content">
                    @if(setting('tebex.shop.home', true))
                        <div class="tab-pane fade @if($y == 0) active show @endif" id="pill-home" role="tabpanel">
                            <div class="card card-body">
                                {!! setting('tebex.shop.home.message', trans('tebex::messages.home.placeholder')) !!}
                            </div>
                        </div>
                        @php $y++ @endphp
                    @endif

                    @forelse($categories as $categorie)
                        <div class="tab-pane fade @if($y == 0) active show @endif" id="pill-{{ $categorie->id }}" role="tabpanel">
                            <div class="row gy-4">
                                @forelse($categorie->packages as $package)
                                    <div class="col-md-4">
                                        <div class="card bg-primary bg-opacity-25 border-0 h-100 p-2" onclick="showModal(`{{ $package->name }}`, `{{ $package->description }}`, `{{ $package->id }}`, `{{ $package->price->discounted ? $package->price->discounted . tebex_currency_symbol() : $package->price->normal . tebex_currency_symbol() }} {{ setting('tebex.shop.vat.status') ? trans('tebex::messages.vat.ttc') : trans('tebex::messages.vat.ht') }}`)">
                                            @if($package->image)
                                                <img class="card-img" draggable="false" src="{{ $package->image }}" alt="{{ $package->name }}">
                                            @endif

                                            <div class="card-body">
                                                <h4 class="card-title">{{ $package->name }}</h4>
                                                <h5 class="card-subtitle mb-3">
                                                    @if($package->price->discounted)
                                                        <del class="small">{{ $package->price->normal . tebex_currency_symbol() }}</del>
                                                        {{ $package->price->discounted . tebex_currency_symbol() }}
                                                    @else
                                                        {{ $package->price->normal . tebex_currency_symbol() }}
                                                    @endif
                                                    <span><small>{{ setting('tebex.shop.vat.status') ? trans('tebex::messages.vat.ttc') : trans('tebex::messages.vat.ht') }}</small></span>
                                                </h5>
                                                <button class="btn btn-primary btn-block w-100">
                                                    <i class="bi bi-eye"></i>
                                                    {{ trans('tebex::messages.packages.show') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col">
                                        <div class="alert alert-warning" role="alert">
                                            {{ trans('tebex::messages.categories.empty') }}
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        @foreach($categorie->subcategories as $categorie)
                            <div class="tab-pane fade" id="pill-{{ $categorie->id }}" role="tabpanel">
                                <div class="row gy-4">
                                    @forelse($categorie->packages as $package)
                                        <div class="col-md-4">
                                            <div class="card h-100 p-2" onclick="showModal(`{{ $package->name }}`, `{{ $package->description }}`, '{{ $package->id }}', '{{ $package->price->discounted ? $package->price->discounted . tebex_currency_symbol() : $package->price->normal . tebex_currency_symbol() }} {{ setting('tebex.shop.vat.status') ? trans('tebex::messages.vat.ttc') : trans('tebex::messages.vat.ht') }}')">
                                                @if($package->image)
                                                    <img class="card-img" draggable="false" src="{{ $package->image }}" alt="{{ $package->name }}">
                                                @endif

                                                <div class="card-body">
                                                    <h4 class="card-title">{{ $package->name }}</h4>
                                                    <h5 class="card-subtitle mb-3">
                                                        @if($package->price->discounted)
                                                            <del class="small">{{ $package->price->normal . tebex_currency_symbol() }}</del>
                                                            {{ $package->price->discounted . tebex_currency_symbol() }}
                                                        @else
                                                            {{ $package->price->normal . tebex_currency_symbol() }}
                                                        @endif
                                                        <span><small>{{ setting('tebex.shop.vat.status') ? trans('tebex::messages.vat.ttc') : trans('tebex::messages.vat.ht') }}</small></span>
                                                    </h5>
                                                    <button class="btn btn-primary btn-block w-100">
                                                        <i class="bi bi-eye"></i>
                                                        {{ trans('tebex::messages.packages.show') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col">
                                            <div class="alert alert-warning" role="alert">
                                                {{ trans('tebex::messages.categories.empty') }}
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                        @php $y++ @endphp
                    @empty
                        <div class="col">
                            <div class="alert alert-warning" role="alert">
                                {{ trans('tebex::messages.categories.empty') }}
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card bg-primary bg-opacity-25 border-0 mb-4">
                    <div class="card-body">
                        <span class="text-white-50 text-sm">Bienvenue sur la boutique</span>
                        <ul class="list-unstyled d-flex flex-column gap-2 mt-3 mb-0">
                            <li><a href="{{theme_config("shop.link.cgu")}}" class="w-100 btn btn-primary text-start py-2">CGU/CGV</a></li>
                            <li><a href="{{theme_config("shop.link.mentions")}}" class="w-100 btn btn-primary text-start py-2">Mentions légales</a></li>
                            <li>
                                <div class="w-100 btn btn-primary text-start py-2">
                                    <a href="{{theme_config("shop.link.support")}}" class="text-decoration-none">Support <a href="mailto:{{theme_config("shop.email") ?? "contact@natifia.fr" }}" class="d-inline-grid text-xs text-white-50 text-end mt-1">( {{theme_config("shop.email") ?? "contact@natifia.fr" }} )</a></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ plugin_asset('tebex', 'js/script.js') }}"></script>
    <script>
        var api = "{{ route('tebex.api.buy') }}";
        let title = "{{ trans('tebex::messages.modal.mc_pseudo') }}";
        let buy = "{{ trans('tebex::messages.packages.buy') }}";
        let errorUser = "{{ trans('tebex::messages.modal.bad_username') }}";
        let cancel = "{{ trans('tebex::messages.packages.cancel') }}";
    </script>
    @guest
        <script>
            var pseudo = ""
        </script>
    @else
        <script>
            var pseudo = "{{ Auth::user()->name }}"
        </script>
    @endguest
@endpush
