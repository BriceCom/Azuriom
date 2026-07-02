@extends('layouts.app')

@section('title', trans('shop::messages.offers.amount'))

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
            <h1 class="text-lg font-medium mb-8 text-white">Choisir une offres</h1>

            <div class="flex flex-wrap gap-8">
                @forelse($offers as $offer)
                    <div class="col-md-3">
                        <div class="card">
                            <a href="{{ route('shop.offers.pay', [$offer->id, $gateway->type]) }}" class="payment-method">
                                <div class="flex flex-col items-center gap-4">
                                    @if($offer->hasImage())
                                        <img src="{{ $offer->imageUrl() }}" alt="{{ $offer->name }}" class="img-fluid">
                                    @endif
                                    <h3>{{ $offer->name }}</h3>
                                    <h4>{{ $offer->price }} {{ currency_display() }}</h4>
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

    <form method="POST" id="submitForm">
        @csrf
    </form>
@endsection
