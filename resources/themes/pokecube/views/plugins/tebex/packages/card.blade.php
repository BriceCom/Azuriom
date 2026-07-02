<div class="shop-card" onclick="openPackageModal({{ json_encode($package) }})">

    {{-- IMAGE --}}
    @if($package->image)
        <img src="{{ $package->image }}" alt="{{ $package->name }}" class="shop-card-image">
    @else
        <div class="shop-card-image" style="background: linear-gradient(135deg, #b297c2, #a81cee);"></div>
    @endif

    {{-- BANNER --}}
    @if(isset($package->banner) && $package->banner)
        <div class="shop-card-banner" style="background-color: {{ $package->banner->color }}; color: {{ color_contrast($package->banner->color) }}">
            <small>{{ $package->banner->text }}</small>
        </div>
    @endif

    {{-- NOM --}}
    <h3 class="shop-card-title">{{ $package->name }}</h3>

    {{-- PRIX --}}
    <div class="shop-card-price">

        @if($package->price->discounted)
            <span class="shop-card-price-old">
                {{ tebex_format_price($package->price->normal) }}
            </span>
            <span class="shop-card-price-new">
                {{ tebex_format_price($package->price->discounted) }}
            </span>
        @else
            <span class="shop-card-price-new">
                {{ tebex_format_price($package->price->normal) }}
            </span>
        @endif

    </div>

    {{-- BOUTON --}}
    <button class="shop-card-btn" onclick="event.stopPropagation(); openPackageModal({{ json_encode($package) }})">
        @if($package->isInCart)
            <i class="bi bi-pencil-square"></i> {{ trans('messages.actions.edit') }}
        @else
            <i class="bi bi-cart-plus"></i> {{ trans('messages.actions.add') }}
        @endif
    </button>

</div>
