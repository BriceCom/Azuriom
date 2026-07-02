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
    <div class="text-center">
        <h2>{{theme_config('offers.content.title') ? theme_config('offers.content.title'):trans('shop::messages.payment.title')}}</h2>
        <p>{{theme_config('offers.content.paragraph') ? theme_config('offers.content.paragraph'):'Paiement sécurisé par PayPal & Stripe'}}</p>
    </div>

    <div class="row justify-content-center gy-3 mt-3">
        <div class="col-md-8">
            <div class="card py-5">
                <div class="card-body d-flex align-items-center flex-column flex-md-row flex-wrap gap-3">
            @forelse($gateways as $gateway)
                    <a title="Payer avec {{ $gateway->name }}" href="{{ route('shop.payments.pay', $gateway->type) }}" class="payment-method col-12 col-md text-center">
                            <img tabindex="1" aria-hidden="true" src="{{ $gateway->paymentMethod()->image() }}" style="width:168px;height: 80px;filter: saturate(0) brightness(0.8) contrast(0.2); max-height: {{ $gateway->name != "Stripe" ? '60px; scale:1.3;':"80px;" }}" class="img-fluid" alt="{{ $gateway->name }}">
                    </a>
            @empty
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.payment.empty') }}
                    </div>
            @endforelse
                </div>
            </div>
        </div>
    </div>

    <form method="POST" id="submitForm">
        @csrf
    </form>
@endsection
