@extends('layouts.app')

@section('title', trans('shop::messages.offers.gateway'))

@section('content')
    <div class="container mx-auto">
        <div class="card">
            <h1 class="text-lg font-medium mb-8 text-white">Sélectionnez un moyens de paiement</h1>

            <div class="flex flex-wrap gap-8">
                @forelse($gateways as $gateway)
                    <div class="col-md-3">
                        <div class="card">
                            <a href="{{ route('shop.offers.buy', $gateway) }}" class="payment-method">
                                <div class="card-body text-center">
                                    <img src="{{ $gateway->paymentMethod()->image() }}" style="max-height: 45px" class="img-fluid h-[45px]" alt="{{ $gateway->name }}">
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.payment.empty') }}
                @endforelse
            </div>
        </div>
    </div>
@endsection
