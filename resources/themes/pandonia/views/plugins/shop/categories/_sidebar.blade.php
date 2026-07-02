@auth
    <div class="d-none d-md-block mb-4">
        @includeIf('shop::categories._user-infos')
    </div>
@endauth

@php
    $package = \Azuriom\Plugin\Shop\Models\Package::where('name', 'LIKE', '%'.theme_config('shop.article.text').'%')->first();
@endphp
@if(isset($package))
<div class="card mb-4">
    <div class="card-header">
        <i class="d-inline-block bi bi-star-fill me-1"></i> Article populaire
    </div>
    <div class="card-body d-flex flex-column align-items-center gap-3 pt-0">
        @if($package->hasImage())
            <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
            </a>
        @endif
        <div class="w-100 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title fw-semibold text-warning text-center mb-0">{{ $package->name }}</h5>

                <p class="d-block card-subtitle fw-semibold">
                    @if($package->isDiscounted())
                        <del class="small">{{ $package->getOriginalPrice() }}</del>
                    @endif
                    {{ shop_format_amount($package->getPrice()) }}
                </p>
            </div>
            <div class="d-flex align-items-center gap-1">
                <a href="#" class="w-100 btn btn-warning text-sm text-dark fw-bold" data-package-url="{{ route('shop.packages.show', $package) }}">
                    Acheter
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@if($recentPayments !== null)
    <div class="card mb-4">
        <div class="card-header">
            Paiements récents
        </div>
        <div class="card-body d-flex flex-wrap gap-3 pt-0">
            @forelse($recentPayments as $payment)
                <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $payment->user->name }}">
                <img src="{{ $payment->user->getAvatar(32) }}" alt="Avatar de {{ $payment->user->name }}">
                </a>
            @empty
                <div class="list-group-item">
                    {{ trans('shop::messages.recent.empty') }}
                </div>
            @endforelse
        </div>
    </div>
@endif

@if($goal !== false)
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-graph-up"></i> {{ trans('shop::messages.goal.title') }}
        </div>
        <div class="card-body pt-0">
            <div class="progress mb-1">
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
            <i class="bi bi-star"></i> {{ trans('shop::messages.top.title') }}
        </div>
        <div class="card-body d-flex">
            <div class="flex-shrink-0">
                <img class="me-3 rounded" src="{{ $topCustomer->user->getAvatar(64) }}" alt="{{ $topCustomer->user->name }}" width="64">
            </div>
            <div class="flex-grow-1">
                <p class="h4 mb-1">{{ $topCustomer->user->name }}</p>
                @if($displaySidebarAmount)
                    {{ $topCustomer->total.' '.currency_display() }}
                @endif
            </div>
        </div>
    </div>
@endif
