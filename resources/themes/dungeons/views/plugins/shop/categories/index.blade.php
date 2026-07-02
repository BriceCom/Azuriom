@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@php
    $cart = Azuriom\Plugin\Shop\Cart\Cart::fromSession(request()->session());
@endphp

@section('content')
    <div class="position-relative text-center">
        <div>
            <h2>{{theme_config('shop.content.title') ? theme_config('shop.content.title'):'Boutique'}}</h2>
            <p>{{theme_config('shop.content.paragraph') ? theme_config('shop.content.paragraph'):'Cette monnaie est utilisable dans la boutique du serveur'}}</p>
        </div>
        <div class="cart-button-wrapper position-absolute top-50 end-0 translate-middle-y">
            <a data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{$cart->count()}} ARTICLE{{$cart->count()>1 ?'S':''}}" href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block cart-button">
                <i class="bi bi-cart display-5"></i>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    {{ $welcome }}
                </div>
            </div>
        </div>
    </div>
@endsection
