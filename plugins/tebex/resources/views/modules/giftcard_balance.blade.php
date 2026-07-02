@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])

<div class="card mb-4">
    <div class="card-header">
        {{ $data['header'] ?? 'Gift Card Balance' }}
    </div>
    <div class="card-body">
        @if(isset($data['balance']))
            <p class="mb-0">
                {{ number_format((float) $data['balance'], 2) }}{{ tebex_currency_symbol($data['currency'] ?? null) }}
            </p>
        @else
            <p class="mb-0 text-muted">{{ trans('messages.none') }}</p>
        @endif
    </div>
</div>
