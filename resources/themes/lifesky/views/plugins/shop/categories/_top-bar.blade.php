<div class="row gy-2 mb-8">
    @if($goal !== false)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-graph-up"></i> {{ trans('shop::messages.goal.title') }}
                </div>
                <div class="card-body">
                    <div class="progress mb-1">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ min($goal, 100) }}%"></div>
                    </div>

                    <p class="card-text text-center text-danger h3">
                        {{$goal}} %
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($topCustomer !== null)
        <div class="col-md-6">
            <div class="card h-100">
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
        </div>
    @endif

    @if($recentPayments !== null)
            <div class="col-md-6">
                <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-list-check"></i> {{ trans('shop::messages.recent.title') }}
                </div>
                <div class="card-body d-flex flex-wrap gap-3 pt-0">
                    @forelse($recentPayments as $payment)
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $payment->user->name }}">
                            <img class="rounded-2" src="{{ $payment->user->getAvatar(32) }}" alt="Avatar de {{ $payment->user->name }}">
                        </a>
                    @empty
                        <div class="text-center w-100">
                            {{ trans('shop::messages.recent.empty') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

</div>
