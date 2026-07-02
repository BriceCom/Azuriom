
<div class="card bg-primary bg-opacity-25 border-0">
    <div class="card-body d-flex gap-3">
        @guest
            <p class="mb-0">Vous devez être connecté pour effectuer un achat.
                <span class="d-inline-flex text-decoration-underline fw-semibold">@includeIf('components.login-modal')</span>
            </p>
        @endguest
        @auth
            <img class="shop-profil" src="{{Auth::user()->getAvatar(96)}}" alt="Avatar de {{Auth::user()->name}}">
            <div class="w-100 d-flex flex-column justify-content-between">
                <span class="fw-bold h5 mb-0">Bienvenue {{Auth::user()->name}}</span>
                <div>
                    <small class="badge" style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->role->name}}</small>
                </div>
                <div class="d-flex flex-column flex-md-row align-items-start justify-content-between align-items-md-end">
                    <div>
                        <span class="text-white-50 text-sm">Vous possédez actuellement</span><span class="fw-semibold text-white text-sm ms-1">{{Auth::user()->money}} {{money_name()}}</span>
                    </div>
                    <div>
                        <a class="text-sm me-3" href="{{ route('shop.offers.select') }}">Créditer mon compte</a>
                        <a class="btn btn-primary" href="{{ route('shop.cart.index') }}">Mon panier</a>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>

<div class="d-flex flex-wrap justify-content-center gap-4 my-4">
    @if($displayHome)
        <a href="{{ route('shop.home') }}" class="text-decoration-none fw-bold h5 @if($category === null) text-white text-decoration-underline active @else text-white-50 @endif">
            {{ trans('messages.home') }}
        </a>
    @endif

    @foreach($categories as $subCategory)


        <div>
            <a href="{{ route('shop.categories.show', $subCategory) }}" class="text-decoration-none fw-bold h5 @if($subCategory->is($category)) text-white text-decoration-underline active @else text-white-50 @endif">
                {{ $subCategory->name }}

                <a id="{{ $subCategory->name }}" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i></i>
                </a>
            </a>

            <div class="dropdown-menu dropdown-menu-end"  aria-labelledby="{{ $subCategory->name }}">
                @foreach($subCategory->categories as $cat)
                    <a href="{{ route('shop.categories.show', $cat) }}" class="dropdown-item ps-2 @if($cat->is($category)) active @endif">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

    @endforeach
</div>
