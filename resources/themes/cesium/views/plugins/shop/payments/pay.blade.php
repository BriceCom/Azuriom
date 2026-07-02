@extends('layouts.app')

@section('title', trans('shop::messages.payment.title'))

@push('footer-scripts')
    <script>
        document.querySelectorAll('.payment-method').forEach(function (el) {
            el.addEventListener('click', function (ev) {
                ev.preventDefault();

                const form = document.getElementById('submitForm');
                form.action = el.href;
                form.submit();
            });
        });
    </script>
@endpush

@section('content')
    <div class="container mx-auto">
        <div class="card">
            <h1 class="text-lg font-medium mb-8 text-white">Sélectionnez un moyens de paiement</h1>

            <div class="flex flex-wrap gap-8">
                @forelse($gateways as $gateway)
                    <a href="{{ isset($route) ? $route($gateway->type) : route('shop.payments.pay', $gateway->type) }}" class="payment-method">
                        <div class="card-body text-center">
                            <img src="{{ $gateway->paymentMethod()->image() }}" style="max-height: 45px" class="img-fluid h-[45px]" alt="{{ $gateway->name }}">
                        </div>
                    </a>
                @empty
                    <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.payment.empty') }}
                @endforelse
            </div>
        </div>
    </div>

    <form method="POST" id="submitForm">
        @csrf
    </form>
@endsection
