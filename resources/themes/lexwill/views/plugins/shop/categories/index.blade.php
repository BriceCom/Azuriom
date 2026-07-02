@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-10 gap-5">
       <div>
           <h1 class="title-bl wow fadeIn" data-wow-duration="2s">
               <div class="color-white">
                   {{ trans('shop::messages.title') }}
               </div>
               <div class="subtitle">
                   {{ trans('shop::messages.title') }}
               </div>
           </h1>
       </div>

        <div>
            @auth
                @if(use_site_money())
                <p class="text-end mb-2 wow fadeIn" data-wow-duration="1s">
                    {{ trans('shop::messages.profile.money', ['balance' => format_money(auth()->user()->money)]) }}
                </p>
                @endif
                <div class="d-flex justify-content-between justify-content-lg-end gap-2 wow fadeIn" data-wow-duration="2s">
                    <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block text-nowrap">
                        <i class="bi bi-cart-fill"></i> {{ trans('shop::messages.cart.title') }}
                    </a>

                    @if(use_site_money())
                        <a href="{{ route('shop.offers.select') }}" class="btn btn-warning btn-block text-nowrap wow fadeIn" data-wow-duration="2s">
                            <i class="bi bi-wallet-fill"></i> Créditer mon compte
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-12">
            <div class="card wow fadeIn" data-wow-duration="3s">
                <div class="card-body">
                    {{ $welcome }}
                </div>
            </div>
        </div>
    </div>
@endsection
