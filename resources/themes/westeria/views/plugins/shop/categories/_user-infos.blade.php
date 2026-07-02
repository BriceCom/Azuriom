<div class="card mb-4">
    <div class="card-body @guest d-flex flex-column flex-md-row gap-3 gap-md-0 justify-content-between align-items-center @endguest">
        @auth
            <div class="d-flex align-items-center gap-4">
                <img class="rounded-3 flex-grow-1" src="{{Auth::user()->getAvatar(64)}}" width="64" height="64" alt="Avatar de {{Auth::user()->name}}">
                <div class="w-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="mb-0">Bonjour {{Auth::user()->name}} <small class="badge text-xs" style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->role->name}}</small></h2>
                            <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block">
                                <i class="bi bi-cart2"></i>
                            </a>
                        </div>
                        @if(use_site_money())
                            <small class="fw-semibold d-block">Vous avez actuellement {{auth()->user()->money}} <img class="ms-1" src="{{theme_config('shop.img') ? image_url(theme_config('shop.img')): 'https://cdn-icons-png.flaticon.com/128/2933/2933116.png'}}" alt="Icône monnaie" width="16" height="16">
                                @if(use_site_money())
                                    <a href="{{ route('shop.offers.select') }}" class="text-warning text-xs ms-md-2">
                                        Créditer mon compte
                                    </a>
                                @endif
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        @endauth
        @guest
                <p class="d-inline-block mb-0">Vous devez être connecté pour effectuer un achat.</p>
                <a href="{{ route('login') }}" class="btn btn-warning text-sm ms-auto">Se connecter</a>
        @endguest
    </div>
</div>
