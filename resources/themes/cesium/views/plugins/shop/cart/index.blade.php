@extends('layouts.app')

@section('title', trans('shop::messages.cart.title'))

@push('styles')
    <style>
        .cart-items thead th {
            width: 40%;
        }

        .cart-items tbody td {
            width: 15%;
        }
    </style>
@endpush

@section('content')

    <div class="container mx-auto">
        <div class="card">
            <h1 class="text-2xl mb-6">{{ trans('shop::messages.cart.title') }}</h1>

            <div class="card-body">
                @if(! $cart->isEmpty())
                    <form action="{{ route('shop.cart.update') }}" method="POST">
                        @csrf

                        <table class="table cart-items">
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ trans('messages.fields.name') }}</th>
                                <th scope="col">{{ trans('shop::messages.fields.price') }}</th>
                                <th scope="col">{{ trans('shop::messages.fields.total') }}</th>
                                <th scope="col">{{ trans('shop::messages.fields.quantity') }}</th>
                                <th scope="col">{{ trans('messages.fields.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($cart->content() as $cartItem)
                                <tr>
                                    <th scope="row">{{ $cartItem->name() }}</th>
                                    <td>{{ shop_format_amount($cartItem->price()) }}</td>
                                    <td>{{ shop_format_amount($cartItem->total()) }}</td>
                                    <td>
                                        <input type="number" min="0" max="{{ $cartItem->maxQuantity() }}" size="5" class="form-input" name="quantities[{{ $cartItem->itemId }}]" value="{{ $cartItem->quantity }}" aria-label="{{ trans('shop::messages.fields.quantity') }}" required @if(!$cartItem->hasQuantity()) readonly @endif>
                                    </td>
                                    <td>
                                        <a href="{{ route('shop.cart.remove', $cartItem->id) }}" class="btn btn-danger btn-icon" title="{{ trans('messages.actions.delete') }}">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary btn-sm ms-auto mt-4">
                            {{ trans('messages.actions.update') }} <i class="bi bi-check-lg"></i>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('shop.cart.clear') }}" class="mt-2">
                        @csrf

                        <button type="submit" class="btn btn-danger ms-auto">
                            {{ trans('shop::messages.cart.clear') }} <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.cart.empty') }}
                    </div>
                @endif

                <div class="row mb-6">
                    <div class="md:w-1/2">
                        <form action="{{ route('shop.cart.coupons.add') }}" method="POST" class="flex items-end gap-2">
                            @csrf

                            <div class="input-group @error('code') has-validation @enderror">
                                <div class="form-input">
                                    <label for="code" class="form-label">
                                        {{ trans('shop::messages.coupons.add') }}
                                    </label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code" value="{{ old('code') }}">
                                </div>

                                @error('code')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ trans('messages.actions.add') }} <i class="bi bi-plus-lg"></i>
                            </button>
                        </form>
                    </div>

                    @if(! $cart->coupons()->isEmpty())
                        <div class="md:w-1/2">
                            <h5 class="my-4">{{ trans('shop::messages.coupons.title') }}</h5>

                            <table class="table coupons">
                                <thead>
                                <tr>
                                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                                    <th scope="col">{{ trans('shop::messages.fields.discount') }}</th>
                                    <th scope="col">{{ trans('messages.fields.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cart->coupons() as $coupon)
                                    <tr>
                                        <th scope="row">{{ $coupon->code }}</th>
                                        <td>{{ $coupon->is_fixed ? shop_format_amount($coupon->discount) : $coupon->discount.' %' }}</td>
                                        <td>
                                            <form action="{{ route('shop.cart.coupons.remove', $coupon) }}" method="POST" class="d-inline-block">
                                                @csrf

                                                <button type="submit" class="btn btn-icon btn-danger" title="{{ trans('messages.actions.delete') }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="md:w-1/2">
                        <form action="{{ route('shop.cart.giftcards.add') }}" method="POST" class="flex items-end gap-2">
                            @csrf

                            <div class="input-group @error('code') has-validation @enderror">
                                <div class="form-input">
                                    <label for="code" class="form-label">
                                        {{ trans('shop::messages.giftcards.add') }}
                                    </label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code" value="{{ old('code') }}">
                                </div>

                                @error('code')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ trans('messages.actions.add') }} <i class="bi bi-plus-lg"></i>
                            </button>
                        </form>
                    </div>

                    @if(! $cart->giftcards()->isEmpty())
                        <div class="md:w-1/2">
                            <h5 class="my-4">{{ trans('shop::messages.giftcards.title') }}</h5>

                            <table class="table coupons">
                                <thead>
                                <tr>
                                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                                    <th scope="col">{{ trans('shop::messages.fields.discount') }}</th>
                                    <th scope="col">{{ trans('messages.fields.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cart->giftcards() as $giftcard)
                                    <tr>
                                        <th scope="row">{{ $giftcard->code }}</th>
                                        <td>{{ shop_format_amount($giftcard->balance) }}</td>
                                        <td>
                                            <form action="{{ route('shop.cart.giftcards.remove', $giftcard) }}" method="POST" class="d-inline-block">
                                                @csrf

                                                <button type="submit" class="btn btn-icon btn-danger" title="{{ trans('messages.actions.delete') }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <form @if(! use_site_money()) action="{{ route('shop.payments.payment') }}" @endif>
                    <div class="flex items-end justify-between">
                        <a href="{{ route('shop.home') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> {{ trans('shop::messages.cart.back') }}
                        </a>

                        <div class="flex flex-col justify-end gap-8">
                            <p class="text-2xl">
                                {{ trans('shop::messages.cart.payable_total', ['total' => shop_format_amount($cart->payableTotal())]) }}
                            </p>
                            @if(! use_site_money())
                                <div class="d-flex justify-content-end">
                                    @include('shop::cart._terms', ['terms' => $terms])
                                </div>
                            @endif
                            @if(use_site_money())
                                <button type="button" class="btn btn-green ms-auto" data-bs-toggle="modal" data-bs-target="#confirmBuyModal">
                                    Procéder au paiement <i class="bi bi-cart-check"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-green ms-auto">
                                    Procéder au paiement <i class="bi bi-cart-check"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(use_site_money())
        <div class="modal fade" id="confirmBuyModal" tabindex="-1" role="dialog" aria-labelledby="confirmBuyLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="confirmBuyLabel">
                            {{ trans('shop::messages.cart.confirm.title') }}
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{ trans('shop::messages.cart.confirm.price', ['price' => shop_format_amount($cart->payableTotal())]) }}
                    </div>

                    <form class="modal-footer" method="POST" action="{{ route('shop.cart.payment') }}">
                        @csrf

                        @include('shop::cart._terms', ['terms' => $terms])

                        <div class="flex items-end justify-end gap-4">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                {{ trans('messages.actions.cancel') }}
                            </button>

                            <button class="btn btn-green" type="submit">
                                {{ trans('shop::messages.cart.pay') }} <i class="bi bi-check-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
