<li class="nav-item dropdown btn btn-outline-secondary text-white bg-dark bg-opacity-10">
    <a class="nav-link dropdown-toggle p-0 text-white" href="#" id="basketDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if(shop_cart()->content())
            {{shop_cart()->count()}}
        @else
            0
        @endif
        <i class="bi bi-basket2-fill"></i>
    </a>

    <!-- Dropdown - Notifications -->
    <div class="dropdown-list dropdown-menu dropdown-menu-end mt-3 p-0 rounded-4" aria-labelledby="basketDropdown" style="width: 350px">
            <div class="card">
                <div class="card-body">
                    @forelse(shop_cart()->content() as $item)
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="flex-grow-1"><span class="fw-bold text-sm">x{{$item->quantity}}</span> • {{$item->buyable()->name}}</span>
                            <a href="{{route('shop.cart.remove', $item->buyable())}}"><i class="bi bi-x"></i></a>
                        </div>
                        <hr class="border-secondary">
                    @empty
                        <span class="d-block fw-bold text-center mb-5">Votre panier est vide !</span>
                    @endforelse
                    @if(!shop_cart()->isEmpty())
                        <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
                            <span class="text-uppercase fw-semibold text-sm">{{shop_cart()->count()}} articles</span>
                            <span class="text-uppercase fw-semibold text-sm">Total: {{ shop_format_amount(shop_cart()->total()) }}</span>
                        </div>
                    @endif
                    <a href="/shop/cart" class="w-100 btn btn-primary text-uppercase fw-semibold">Voir le panier</a>
                </div>
            </div>
    </div>
</li>
