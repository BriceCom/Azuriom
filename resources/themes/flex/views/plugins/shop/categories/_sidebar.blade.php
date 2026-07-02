@if($shopUser !== null)
    <div class="card mb-4">
        <div class="card-body d-grid gap-3">
            <div class="d-flex gap-2.5 align-items-center rounded-2 p-2 bg-black" style="--di-bg-opacity: 1;">
                <img src="{{ $shopUser->getAvatar(64) }}" class="rounded-2" alt="Avatar" width="48" height="48">
                <div class="d-flex flex-column">
                    <span class="fw-bold">{{ $shopUser->name }}</span>
                    @if(use_site_money())
                        <span class="badge text-bg-primary">
                            {{ trans('shop::messages.profile.money', ['balance' => format_money($shopUser->money)]) }}
                        </span>
                    @endif
                </div>
            </div>

            @if($userHasPayments)
                <a href="{{ route('shop.profile') }}" class="btn btn-primary w-100">
                    <i class="bi bi-cash-coin"></i> {{ trans('shop::messages.profile.payments') }}
                </a>
            @endif

            @guest
                <form action="{{ route('shop.logout') }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                    </button>
                </form>
            @endguest

            <div class="row g-2">
                <div class="col-md-6">
                    <a href="{{ route('shop.cart.index') }}" class="w-100 btn btn-tertiary">
                        {{ trans('shop::messages.cart.title') }}
                    </a>
                </div>

                @if(use_site_money())
                    <div class="col-md-6">
                        <a href="{{ route('shop.offers.select') }}" class="w-100 btn btn-secondary">
                            <i class="bi bi-credit-card"></i> {{ trans('shop::messages.cart.credit') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@else
    <a href="{{ route('shop.login') }}" class="w-100 btn btn-primary mb-4">
        <i class="bi bi-box-arrow-in-right"></i> {{ trans('auth.login') }}
    </a>
@endif

<div class="card mb-4">
    <div class="card-body">
        <div class="list-group mb-3">
            @if($displayHome)
                <a href="{{ route('shop.home') }}" class="list-group-item @if($category === null) active @endif">
                    {{ trans('messages.home') }}
                </a>
            @endif

            @foreach($categories as $subCategory)
                <a href="{{ route('shop.categories.show', $subCategory) }}" class="list-group-item fw-semibold @if($subCategory->is($category)) active @endif">
                    @if($subCategory->icon)
                        <i class="{{ $subCategory->icon }} text-lg"></i>
                    @endif
                    {{ $subCategory->name }}
                </a>

                @foreach($subCategory->categories as $cat)
                    <a href="{{ route('shop.categories.show', $cat) }}" class="list-group-item fw-semibold ms-3 @if($cat->is($category)) active @endif">
                        @if($cat->icon)
                            <i class="{{ $cat->icon }} text-lg"></i>
                        @endif
                        {{ $cat->name }}
                    </a>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

@if($goal >= 0)
    <div class="card mb-4">
        <div class="card-header">
            {{ trans('shop::messages.goal.title') }}
        </div>
        <div class="card-body">
            <div class="progress mb-2">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ min($goal, 100) }}%"></div>
            </div>

            <p class="card-text text-center">
                {{ trans_choice('shop::messages.goal.progress', $goal) }}
            </p>
        </div>
    </div>
@endif

@if($topCustomer !== null)
    <div class="card mb-4">
        <div class="card-header">
            {{ trans('shop::messages.top.title') }}
        </div>
        <div class="card-body d-flex">
            <div class="flex-shrink-0">
                <img class="me-3 rounded" src="{{ $topCustomer->user->getAvatar(64) }}" alt="{{ $topCustomer->user->name }}" width="64">
            </div>
            <div class="flex-grow-1">
                <p class="h4 mb-1">{{ $topCustomer->user->name }}</p>
                @if($displaySidebarAmount)
                    {{ $topCustomer->formatPrice() }}
                @endif
            </div>
        </div>
    </div>
@endif

@if($recentPayments !== null)
    <div class="card mb-4">
        <div class="card-header">
            {{ trans('shop::messages.recent.title') }}
        </div>
        <div class="card-body">
            <div class="list-group">
                @forelse($recentPayments as $payment)
                    <div class="list-group-item d-flex gap-3">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="{{ $payment->user->getAvatar(32) }}" class="rounded-1" alt="{{ $payment->user->name }}" width="32">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1">{{ $payment->user->name }}</p>
                            <small>
                                @if($displaySidebarAmount)
                                    {{ $payment->formatPrice() }}
                                @endif
                                {{ format_date($payment->created_at) }}
                            </small>
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
@endif
