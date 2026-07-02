<div class="row gx-md-6 gy-4 mb-4 mb-md-8">
    @if($topCustomer !== null)
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex flex-column p-4 pb-md-0">
                    <h2>MEILLEUR ACHETEUR</h2>
                    <p class="fw-normal text-light">Nos meilleurs acheteurs reçoivent des cadeaux tous les mois</p>
                    <div class="d-flex flex-grow-1 gap-4">
                        <div class="align-self-end text-start overflow-hidden" style="height: 110px;">
                            <img src="https://mc-heads.net/body/{{$topCustomer->user->name}}.png" class="rounded mb-3" alt="Avatar de{{ $topCustomer->user->nam }}" height="170">
                        </div>
                        <div class="flex-grow-1 align-self-center">
                            <p class="fs-3 fw-semibold mb-0">{{ $topCustomer->user->name }}</p>
                            @if($displaySidebarAmount)
                                {{ $topCustomer->formatPrice() }}
                            @endif
                        </div>
                        @auth
                            <div class="d-grid gap-2">
                                @if(use_site_money())
                                    <p class="text-center mb-0">
                                        {{ trans('shop::messages.profile.money', ['balance' => format_money(auth()->user()->money)]) }}
                                    </p>

                                    <a href="{{ route('shop.offers.select') }}" class="btn btn-primary btn-block">
                                        {{ trans('shop::messages.cart.credit') }}
                                    </a>
                                @endif

                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($goal !== false)
        <div class="col-12 @if($topCustomer !== null) col-md-6 @endif">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h2>OBJECTIF MENSUEL</h2>
                    <p class="fw-normal text-light">Merci énormément aux personnes qui nous soutiennent</p>
                    <div class="progress mt-5">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ min($goal, 100) }}%"></div>
                    </div>

                    <p class="card-text text-primary text-center fs-1 mt-3">
                        {{ $goal }}%
                    </p>
                </div>
            </div>
        </div>
    @endif
        @if($recentPayments !== null)
            <div class="col-12 ">
                <div class="card mb-4 mb-md-8">
                    <div class="card-body">
                        <h2>{{ trans('shop::messages.recent.title') }}</h2>
                        <div class="list-group list-group-flush">
                            @forelse($recentPayments as $payment)
                                <div class="list-group-item d-flex bg-transparent">
                                    <div class="flex-shrink-0 d-flex align-items-center">
                                        <img src="{{ $payment->user->getAvatar(48) }}" class="me-3 rounded" alt="{{ $payment->user->name }}" width="32">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1">{{ $payment->user->name }}</p>
                                        <small>{{ $payment->price.' '.currency_display() }} - {{ format_date($payment->created_at) }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item">
                                    {{ trans('shop::messages.recent.empty') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>

@if($shopUser !== null)
   <div class="card mb-4">
       <div class="card-body d-flex flex-wrap align-items-center gap-2 gap-lg-5 py-3">
           <div class="d-flex justify-content-center mb-3">
               <div class="flex-shrink-0 d-flex align-items-center">
                   <img src="{{ $shopUser->getAvatar(48) }}" class="me-3 rounded" alt="{{ $shopUser->name }}" width="48">
               </div>
               <div class="align-self-center">
                   <h3 class="mb-0">{{ $shopUser->name }}</h3>
                   @if(use_site_money())
                       <p class="mb-0">
                           {{ trans('shop::messages.profile.money', ['balance' => format_money($shopUser->money)]) }}
                       </p>
                   @endif
               </div>
           </div>

           <div class="d-flex flex-wrap align-items-start gap-2">
               @if(use_site_money())
                   <a href="{{ route('shop.offers.select') }}" class="btn btn-primary">
                       <i class="bi bi-credit-card"></i> {{ trans('shop::messages.cart.credit') }}
                   </a>
               @endif

               <a href="{{ route('shop.cart.index') }}" class="btn btn-primary">
                   <i class="bi bi-cart"></i> {{ trans('shop::messages.cart.title') }}
               </a>

               @if($userHasPayments)
                   <a href="{{ route('shop.profile') }}" class="btn btn-primary">
                       <i class="bi bi-cash-coin"></i> {{ trans('shop::messages.profile.payments') }}
                   </a>
               @endif
           </div>

           @guest
               <form action="{{ route('shop.logout') }}" method="POST" class="text-center">
                   @csrf
                   <button type="submit" class="btn btn-secondary w-100">
                       <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                   </button>
               </form>
           @endguest
       </div>
   </div>
@else
    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap align-items-center gap-2 gap-lg-5 py-3">
            <p class="mb-0">Connectez-vous pour acheter et accéder à votre panier ainsi qu'à vos achats.</p>

            <a href="{{ route('shop.login') }}" class="btn btn-primary d-block">
                <i class="bi bi-box-arrow-in-right"></i> {{ trans('auth.login') }}
            </a>
        </div>
    </div>
@endif

<div class="card d-flex flex-row flex-wrap justify-content-center align-items-center gap-4 p-2 mb-4 mb-md-8">
    @if($displayHome)
        <a href="{{ route('shop.home') }}" class="text-white fw-normal @if($category === null) btn btn-primary @else btn bg-black p-2 @endif">
            {{ trans('messages.home') }}
        </a>
    @endif

    @foreach($categories as $subCategory)
        <a href="{{ route('shop.categories.show', $subCategory) }}" class="text-white fw-normal @if($subCategory->is($category)) btn btn-primary @else btn bg-black @endif">
            {{ $subCategory->name }}
        </a>

        @foreach($subCategory->categories as $cat)
            <a href="{{ route('shop.categories.show', $cat) }}" class="text-white fw-normal @if($cat->is($category)) btn btn-primary @else btn bg-black p-2 @endif">
                {{ $cat->name }}
            </a>
        @endforeach
    @endforeach
</div>
