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
    <div class="text-center">
        <h2>{{theme_config('cart.content.title') ? theme_config('cart.content.title'):'Mon panier'}}</h2>
        <p>{{theme_config('cart.content.paragraph') ? theme_config('cart.content.paragraph'):'Liste de votre panier'}}</p>
    </div>

            @if(! $cart->isEmpty())
                <form action="{{ route('shop.cart.update') }}" method="POST" class="table-responsive">
                    @csrf

                    <table class="table table-striped cart-items m-0">
                        <thead>
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
                                    <input type="number" min="0" max="{{ $cartItem->maxQuantity() }}" size="5" class="form-control form-control-sm d-inline-block" name="quantities[{{ $cartItem->itemId }}]" value="{{ $cartItem->quantity }}" aria-label="{{ trans('shop::messages.fields.quantity') }}" required @if(!$cartItem->hasQuantity()) readonly @endif>
                                </td>
                                <td class="text-center vertical-middle">
                                    <a href="{{ route('shop.cart.remove', $cartItem->id) }}" title="{{ trans('messages.actions.delete') }}">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <p class="text-end my-4 py-3">
                        <button type="submit" class="btn btn-primary btn-sm me-3">
                            <i class="bi bi-check-lg me-2"></i> {{ trans('messages.actions.update') }}
                        </button>
                        <button id="cartClear" type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-2"></i> Vider le panier
                        </button>
                    </p>
                </form>
                <form id="formCartClear" method="POST" action="{{ route('shop.cart.clear') }}" class="d-none text-end mb-4">
                    @csrf
                </form>
        <div class="card p-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h2 class="h4">{{ trans('shop::messages.coupons.add') }}</h2>

                        <form action="{{ route('shop.cart.coupons.add') }}" method="POST" >
                            @csrf

                            <div class="input-group mb-3 @error('code') has-validation @enderror">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code" value="{{ old('code') }}">

                                <button type="submit" class="btn btn-primary ms-3 rounded rounded-2">
                                    <i class="bi bi-plus-lg me-2"></i> {{ trans('messages.actions.add') }}
                                </button>

                                @error('code')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </form>
                    </div>

                    @if(! $cart->coupons()->isEmpty())
                        <div class="col-12">
                            <h2 class="h4">{{ trans('shop::messages.coupons.title') }}</h2>

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

                                                <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('messages.actions.delete') }}">
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

                <div class="row">
                    <div class="col-12 col-md-12">
                        <h2 class="h4">{{ trans('shop::messages.giftcards.add') }}</h2>

                        <div class="row">
                            <form action="{{ route('shop.cart.giftcards.add') }}" method="POST" class="col-md-6">
                                @csrf

                                <div class="input-group mb-3 @error('code') has-validation @enderror">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code" value="{{ old('code') }}">

                                    <button type="submit" class="btn btn-primary ms-3 rounded rounded-2">
                                        <i class="bi bi-plus-lg me-2"></i> {{ trans('messages.actions.add') }}
                                    </button>

                                    @error('code')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </form>
                            <p class="col-md-6 text-end text-white h4">
                                {{ trans('shop::messages.cart.total', ['total' => shop_format_amount($cart->total())]) }}
                            </p>
                        </div>

                    </div>

                    @if(! $cart->giftcards()->isEmpty())
                        <div class="col-md-12">
                            <h3 class="h5">{{ trans('shop::messages.giftcards.title') }}</h3>

                            <div class="table-responsive">
                                <table class="table table-striped coupons">
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

                                                    <button type="submit" class="btn bg-transparent" title="{{ trans('messages.actions.delete') }}">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <p class="text-end">
                                {{ trans('shop::messages.cart.payable_total', ['total' => shop_format_amount($cart->payableTotal())]) }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 text-center text-md-start">
                        <a href="{{ route('shop.home') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> {{ trans('shop::messages.cart.back') }}
                        </a>
                    </div>

                    <div class="col-12 col-md-6 text-center text-md-end mt-3 mt-md-0">

                        @if(use_site_money())
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmBuyModal">
                                {{ trans('shop::messages.buy') }}
                            </button>
                        @else
                            <a href="{{ route('shop.payments.payment') }}" class="btn btn-secondary">
                                <i>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 15C13.8954 15 13 15.8954 13 17C13 18.1046 13.8954 19 15 19C16.1046 19 17 18.1046 17 17C17 15.8954 16.1046 15 15 15ZM15 15H7.29395C6.83269 15 6.60197 15 6.41211 14.918C6.24466 14.8456 6.09934 14.7288 5.99349 14.5802C5.87348 14.4118 5.82609 14.1863 5.72945 13.7353L3.27148 2.26477C3.17484 1.81376 3.12587 1.58825 3.00586 1.4198C2.90002 1.27123 2.75525 1.15441 2.5878 1.08205C2.39794 1 2.16779 1 1.70653 1H1M4 4H16.8732C17.595 4 17.9557 4 18.1979 4.15036C18.4101 4.28206 18.5652 4.48838 18.6329 4.72876C18.7102 5.00319 18.611 5.34996 18.411 6.04346L17.0264 10.8435C16.9068 11.2581 16.8469 11.4655 16.7256 11.6193C16.6185 11.7551 16.4772 11.8608 16.3171 11.926C16.1356 12 15.9199 12 15.4883 12H5.73047M6 19C4.89543 19 4 18.1046 4 17C4 15.8954 4.89543 15 6 15C7.10457 15 8 15.8954 8 17C8 18.1046 7.10457 19 6 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </i> {{ trans('shop::messages.cart.checkout') }}
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.cart.empty') }}
                </div>

                <a href="{{ route('shop.home') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> {{ trans('shop::messages.cart.back') }}
                </a>
            @endif
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

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            {{ trans('messages.actions.cancel') }}
                        </button>

                        <form method="POST" action="{{ route('shop.cart.payment') }}">
                            @csrf

                            <button class="btn btn-primary" type="submit">
                                {{ trans('shop::messages.cart.pay') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('footer-scripts')
    <script type="text/javascript">
        const button = document.getElementById('cartClear');
        const formCartClear = document.getElementById('formCartClear');

        button.addEventListener('click', function(event) {
            event.preventDefault();
            formCartClear.submit();
        });
    </script>
@endpush
