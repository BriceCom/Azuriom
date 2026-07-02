@auth
    <div class="card">
        <div class="card-body">
            <div>
                <div class="d-flex gap-3">
                    <img class="rounded-3" src="{{Auth::user()->getAvatar(64)}}" alt="Avatar de {{Auth::user()->name}}">
                    <div class="w-100 d-flex flex-column justify-content-between">
                        <div>
                            <small class="badge" style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->name}}</small>
                            @if(use_site_money())
                                <small class="fw-semibold d-block"> {{format_money(auth()->user()->money)}}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                @if(use_site_money())
                    <a href="{{ route('shop.offers.select') }}" class="btn btn-primary btn-block text-xs">
                        Créditer mon compte
                    </a>
                @endif
                <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block text-xs">
                    Mon panier
                </a>
            </div>
        </div>
    </div>
@endauth
