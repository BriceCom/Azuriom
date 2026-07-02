@extends('layouts.app')

@section('title', trans('tebex::messages.cart.title'))

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
    <h1>{{ trans('tebex::messages.cart.title') }}</h1>

    <div class="card">
        <div class="card-body">
            @if(! $cart->isEmpty())
                <form action="{{ route('tebex.cart.update') }}" method="POST">
                    @csrf

                    <table class="table cart-items">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('tebex::messages.fields.price') }}</th>
                            <th scope="col">{{ trans('tebex::messages.fields.total') }}</th>
                            <th scope="col">{{ trans('tebex::messages.fields.quantity') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($cart->content() as $cartItem)
                            <tr>
                                <th scope="row">{{ $cartItem->name() }}</th>
                                <td>{{ tebex_format_amount($cartItem->price()) }}</td>
                                <td>{{ tebex_format_amount($cartItem->total()) }}</td>
                                <td>
                                    <input type="number" min="0" max="{{ $cartItem->maxQuantity() }}" size="5" class="form-control form-control-sm d-inline-block" name="quantities[{{ $cartItem->itemId }}]" value="{{ $cartItem->quantity }}" aria-label="{{ trans('tebex::messages.fields.quantity') }}" required @if(!$cartItem->hasQuantity()) readonly @endif>
                                </td>
                                <td>
                                    <a href="{{ route('tebex.cart.remove', $cartItem->id) }}" class="btn btn-sm btn-danger" title="{{ trans('messages.actions.delete') }}">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <p class="text-end mb-1">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-lg"></i> {{ trans('messages.actions.update') }}
                        </button>
                    </p>
                </form>

                <form method="POST" action="{{ route('tebex.cart.clear') }}" class="text-end mb-4">
                    @csrf

                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> {{ trans('tebex::messages.cart.clear') }}
                    </button>
                </form>
            @else
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ trans('tebex::messages.cart.empty') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <h5>{{ trans('tebex::messages.cart.minecraft_username') }}</h5>

                    <form action="{{ route('tebex.cart.username') }}" method="POST">
                        @csrf

                        <div class="input-group mb-3 @error('username') has-validation @enderror">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   placeholder="{{ trans('tebex::messages.cart.enter_username') }}"
                                   id="username" name="username"
                                   value="{{ old('username', session('tebex_username', Auth::user()->name ?? '')) }}"
                                   autocomplete="off">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> {{ trans('messages.actions.save') }}
                            </button>

                            @error('username')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <h5 class="text-end">
                {{ trans('tebex::messages.cart.total', ['total' => tebex_format_amount($cart->total())]) }}
            </h5>

            <div class="d-flex">
                <a href="{{ route('tebex.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ trans('tebex::messages.cart.back') }}
                </a>

                <a href="{{ route('tebex.cart.checkout') }}" class="btn btn-primary ms-auto">
                    <i class="bi bi-cart-check"></i> {{ trans('tebex::messages.cart.checkout') }}
                </a>
            </div>
        </div>
    </div>
@endsection
