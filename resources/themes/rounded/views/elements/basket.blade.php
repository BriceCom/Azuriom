<li class="nav-item dropdown d-flex align-items-center text-white bg-dark bg-opacity-10 me-3">
    <a class="position-relative nav-link p-0 text-white" href="#" id="basketDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-cart2"></i>
        <span class="position-absolute bg-danger rounded-pill text-sm d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 12px; bottom: -5px; right: -10px;">
            @if(shop_cart()->content())
                {{shop_cart()->count()}}
            @else
                0
            @endif
        </span>
    </a>

    <!-- Dropdown - Notifications -->
    <div class="dropdown-list dropdown-menu dropdown-menu-end mt-2 p-0" aria-labelledby="basketDropdown" style="width: 350px">
            <div class="card">
                <div class="card-body">
                    @forelse(shop_cart()->content() as $item)
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="flex-grow-1"><span class="fw-bold text-sm">x{{$item->quantity}}</span> - {{$item->buyable()->name}}</span>
                            <a href="{{route('shop.cart.remove', $item->buyable())}}"><i class="bi bi-x"></i></a>
                        </div>
                        <hr class="border-secondary">
                    @empty
                        <span class="d-block fw-bold text-center mb-2">{{trans('theme::theme.navbar.basket.empty')}} <a href="/shop/cart" class=" d-block fw-normal">{{trans('theme::theme.navbar.basket.access')}}</a></span>
                    @endforelse
                    @if(!shop_cart()->isEmpty())
                        <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
                            <span class="text-uppercase fw-semibold text-sm">{{trans('theme::theme.navbar.basket.article', ['count'=> shop_cart()->count()])}}</span>
                            <span class="text-uppercase fw-semibold text-sm">{{trans('theme::theme.navbar.basket.total', ['count'=> shop_format_amount(shop_cart()->total())])}}</span>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</li>
