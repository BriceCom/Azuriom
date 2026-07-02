@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])
@php($payments = $data['payments'] ?? [])

<div class="card mb-4">
    <div class="card-header">
        {{ $data['header'] ?? 'Recent Payments' }}
    </div>
    <div class="list-group list-group-flush">
        @forelse($payments as $payment)
            @php($username = $payment['username'] ?? 'Unknown')
            @php($createdAt = isset($payment['created_at']) ? \Illuminate\Support\Carbon::make($payment['created_at']) : null)
            <div class="list-group-item d-flex">
                <div class="flex-shrink-0 d-flex align-items-center">
                    <img src="{{ tebex_get_avatar($username, 48) }}" class="me-3 rounded" alt="{{ $username }}" width="32">
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0">{{ $username }}</p>
                    <div class="d-flex justify-content-between gap-2">
                       <small>
                           @if(isset($payment['price']))
                               {{ number_format((float) $payment['price'], 2) }}{{ tebex_currency_symbol($payment['currency'] ?? null) }}
                           @endif
                       </small>
                        <small>
                            @if($createdAt !== null)
                                {{ format_date($createdAt) }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ trans('messages.none') }}
            </div>
        @endforelse
    </div>
</div>
