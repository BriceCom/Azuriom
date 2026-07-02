<div class="shop-sidebar-box">

    {{-- HOME --}}
    @if(setting('tebex.shop.home_status', true))
        <a href="{{ route('tebex.index') }}"
           class="shop-sidebar-item @if(!isset($category)) active @endif">
            {{ trans('tebex::messages.home.home') }}
        </a>
    @endif

    {{-- CATÉGORIES --}}
    @foreach($categories as $cat)

        <a href="{{ route('tebex.categories.show', $cat->id) }}"
           class="shop-sidebar-item @if(isset($category) && $cat->id == $category->id) active @endif">
            {{ $cat->name }}
        </a>

        @foreach($cat->subcategories as $subcat)
            <a href="{{ route('tebex.categories.show', $subcat->id) }}"
               class="shop-sidebar-item shop-sidebar-sub @if(isset($category) && $subcat->id == $category->id) active @endif">
                <span class="shop-sidebar-sub-icon">›</span>
                {{ $subcat->name }}
            </a>
        @endforeach

    @endforeach

</div>

{{-- PROFIL + PANIER --}}
<div class="shop-sidebar-box">

    @include('tebex::user.profile')

    @if(auth()->check() || session('tebex.username'))
        <a href="{{ route('tebex.cart.show') }}" class="shop-sidebar-cart">
            <span>{{ trans('tebex::messages.cart.cart') }}</span>
            <span id="cart-count-badge" class="shop-sidebar-cart-badge">{{ tebex_cart_count() }}</span>
        </a>
    @endif

</div>

{{-- Modal pseudo --}}
@include('tebex::user.modal')
