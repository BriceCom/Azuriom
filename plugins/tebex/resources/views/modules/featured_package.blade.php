@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])
@php($package = $data['package'] ?? [])

@if(!empty($package))
    @php($showVat = setting('tebex.shop.vat.status', false))
    @php($priceInfo = tebex_format_price_data([
        'base_price' => $package['base_price'] ?? null,
        'total_price' => $package['total_price'] ?? null,
        'price' => $package['base_price'] ?? ($package['total_price'] ?? 0),
        'discount' => $package['discount'] ?? 0,
    ], $showVat))
    @php($isInCart = collect(tebex_cart_items())->contains(fn ($item) => (int) ($item['package_id'] ?? 0) === (int) ($package['id'] ?? 0)))
    @php($modalPackage = [
        'id' => (int) ($package['id'] ?? 0),
        'name' => $package['name'] ?? 'Package',
        'description' => $package['description'] ?? '',
        'image' => $package['image'] ?? null,
        'price' => [
            'normal' => $priceInfo['normal'],
            'discounted' => $priceInfo['discounted'],
            'expire' => null,
        ],
        'isInCart' => $isInCart,
    ])

    <div class="card mb-4">
        <div class="card-header">
            {{ $data['header'] ?? 'Featured Package' }}
        </div>
        <div class="card-body">
            @if(!empty($package['image']))
                <img src="{{ $package['image'] }}" alt="{{ $package['name'] ?? 'Package' }}">
            @endif

            <p class="h5 mb-2">{{ $package['name'] ?? 'Package' }}</p>
            @if(!empty($package['description']))
                <p class="text-muted mb-2">{!! $package['description'] !!}</p>
            @endif
            <p class="card-subtitle fs-6 mb-3">
                @if ($priceInfo['discounted'])
                    <del class="small text-danger">{{ tebex_format_price($priceInfo['normal']) }}</del>
                    {{ tebex_format_price($priceInfo['discounted']) }}
                @else
                    {{ tebex_format_price($priceInfo['normal']) }}
                @endif
                <span><small>{{ $showVat ? trans('tebex::messages.vat.ttc') : trans('tebex::messages.vat.ht') }}</small></span>
            </p>

            @if(!empty($package['id']))
                <button class="btn btn-primary" onclick='openPackageModal(@json($modalPackage))'>
                    @if($isInCart)
                        <i class="bi bi-pencil-square"></i> {{ trans('messages.actions.edit') }}
                    @else
                        <i class="bi bi-cart-plus"></i> {{ trans('messages.actions.add') }}
                    @endif
                </button>
            @endif
        </div>
    </div>
@endif
