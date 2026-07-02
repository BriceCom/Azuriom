@extends('layouts.app')

@section('title', trans('tebex::messages.cart.cart'))

@section('content')

{{--    @include('elements.section')--}}

    <div class="profile-spacer"></div>

    <div class="cart-wrapper">

        <h1 class="cart-title">{{ trans('tebex::messages.cart.cart') }}</h1>

        <div class="cart-layout">

            {{-- LISTE DES ITEMS --}}
            <div class="cart-items">

                @php $globalTotal = 0; @endphp

                @forelse($cart['items'] as $item)

                    @php
                        $price = $item['price'] ?? 0;
                        $lineTotal = $price * $item['quantity'];
                        $globalTotal += $lineTotal;
                    @endphp

                    <div class="cart-item" data-package-id="{{ $item['package_id'] }}">

                        {{-- IMAGE --}}
                        @if(!empty($item['image']))
                            <img src="{{ $item['image'] }}" class="cart-item-image" alt="{{ $item['name'] }}">
                        @endif

                        {{-- INFOS --}}
                        <div class="cart-item-info">
                            <h3 class="cart-item-name">{{ $item['name'] }}</h3>

                            <div class="cart-item-qty">
                                <span>Quantité :</span>
                                <strong>{{ $item['quantity'] }}</strong>
                            </div>

                            <div class="cart-item-total">
                                {{ number_format($lineTotal, 2) }}{{ tebex_currency_symbol() }}
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="cart-item-actions">
                            <button type="button" class="btn btn-sm btn-danger remove-item">
                                <i class="bi bi-x-lg"></i>
                            </button>

                        </div>

                    </div>

                @empty

                    <div class="cart-empty">
                        {{ trans('tebex::messages.cart.empty') }}
                    </div>

                @endforelse

            </div>

            {{-- RÉCAPITULATIF --}}
            <div class="cart-summary">

                <h3 class="cart-summary-title">Votre panier</h3>

                <div class="cart-summary-box">

                    <div class="cart-summary-row">
                        <span>Sous total</span>
                        <strong>{{ number_format($globalTotal, 2) }}{{ tebex_currency_symbol() }}</strong>
                    </div>

                    <div class="cart-summary-row total">
                        <span>{{ trans('tebex::messages.cart.total') }}</span>
                        <strong>{{ number_format($globalTotal, 2) }}{{ tebex_currency_symbol() }}</strong>
                    </div>

                </div>

                {{-- BOUTONS --}}
                <div class="cart-summary-actions">

                    {{-- Vider --}}
                    <form action="{{ route('tebex.cart.clear') }}" method="POST"
                          onsubmit="return confirm('{{ trans('tebex::messages.actions.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button type ="submit" class="cart-btn-secondary">
                            {{ trans('tebex::messages.cart.clear') }}
                        </button>
                    </form>

                    {{-- Checkout --}}
                    <form action="{{ route('tebex.cart.checkout') }}" method="POST">
                        @csrf

                        <label class="cart-creator-label">
                            {{ trans('tebex::messages.cart.creator_code') }}
                        </label>

                        <input type="text"
                               name="creator_code"
                               maxlength="64"
                               value="{{ $creatorCode ?? '' }}"
                               class="cart-creator-input"
                               placeholder="{{ trans('tebex::messages.cart.creator_code_placeholder') }}">

                        <button class="cart-btn">
                            {{ trans('tebex::messages.cart.checkout') }}
                        </button>
                    </form>

                    {{-- Continuer --}}
                    <a href="{{ route('tebex.index') }}" class="cart-btn-secondary">
                        {{ trans('tebex::messages.cart.continue') }}
                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="profile-bottom-spacer"></div>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currencySymbol = '{{ tebex_currency_symbol() }}';

            function updateUI(row, newQuantity) {
                const unitPrice = parseFloat(row.dataset.unitPrice);
                const rowTotalEl = row.querySelector('.row-total');

                const newLineTotal = unitPrice * newQuantity;
                rowTotalEl.innerText = newLineTotal.toFixed(2) + currencySymbol;

                updateGrandTotal();
            }

            function updateGrandTotal() {
                let total = 0;
                document.querySelectorAll('.cart-item').forEach(row => {
                    const qty = parseInt(row.querySelector('.item-quantity-input').value);
                    const price = parseFloat(row.dataset.unitPrice);
                    if (!isNaN(qty) && !isNaN(price)) {
                        total += qty * price;
                    }
                });
                document.getElementById('cart-grand-total').innerText = total.toFixed(2) + currencySymbol;
            }

            document.querySelectorAll('.item-quantity-input').forEach(function(input) {
                input.addEventListener('change', function() {
                    const row = this.closest('.cart-item');
                    const packageId = row.dataset.packageId;
                    let newQty = parseInt(this.value);

                    if (isNaN(newQty) || newQty < 1) {
                        newQty = 1;
                        this.value = 1;
                    }
                    if (newQty > 99) {
                        newQty = 99;
                        this.value = 99;
                    }

                    updateUI(row, newQty);

                    updateItemQuantity(packageId, newQty);
                });
            });

            document.querySelectorAll('.remove-item').forEach(function(button) {
                button.addEventListener('click', function() {
                    if(confirm('{{ trans('tebex::messages.actions.confirm_delete') }}')) {
                        const row = this.closest('.cart-item');
                        const packageId = row.dataset.packageId;
                        removeItem(packageId);
                    }
                });
            });

            function updateItemQuantity(packageId, quantity) {
                fetch('{{ route('tebex.packages.update') }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        package_id: packageId,
                        quantity: quantity
                    })
                }).catch(error => {
                    console.error('Error updating quantity:', error);
                });
            }

            function removeItem(packageId) {
                fetch('{{ route('tebex.packages.remove') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        package_id: packageId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                    });
            }
        });
    </script>
@endpush
