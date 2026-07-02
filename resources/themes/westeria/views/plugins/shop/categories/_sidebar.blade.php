@if($recentPayments !== null)
    <div class="card mb-4">
        <div class="card-header">
            Paiements récents
        </div>
        <div class="card-body d-flex flex-md-row gap-3 pt-0">
            @forelse($recentPayments as $payment)
                <a class="d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $payment->user->name }}">
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
