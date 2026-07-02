<div class="row">
    @if($topCustomer !== null)
        <div class="col-md-4 wow fadeIn" data-wow-duration="3s">
            <div class="card mb-4">
                <div class="card-header text-uppercase fw-bold">
                    {{ trans('shop::messages.top.title') }}
                </div>
                <div class="card-body d-flex">
                    <div class="flex-shrink-0">
                        <img class="me-3 rounded" src="{{ $topCustomer->user->getAvatar(48) }}"
                             alt="{{ $topCustomer->user->name }}" width="48">
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center gap-3 fs-5">
                        <p class="mb-0">{{ $topCustomer->user->name }}</p>
                        <b class="badge bg-success">
                            {{ $topCustomer->total.' '.currency_display() }}}
                        </b>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($recentPayments !== null)
        <div class="col-md-4 wow fadeIn" data-wow-duration="3s">
            <div class="card mb-4">
                <div class="card-header text-uppercase fw-bold">
                    {{ trans('shop::messages.recent.title') }}
                </div>
                <div class="card-body">
                    <div class="list-group-item d-flex">
                        @forelse($recentPayments as $payment)
                            <a href="#" class="flex-shrink-0 d-flex align-items-center"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               data-bs-original-title="{{ $payment->user->name }} @if($displaySidebarAmount) - {{ $payment->price.' '.currency_display() }} @endif">
                                <img src="{{ $payment->user->getAvatar(48) }}" class="me-3 rounded"
                                     alt="{{$payment->user->name }}" width="48">
                            </a>
                        @empty
                            <small>{{ trans('shop::messages.recent.empty') }}</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($goal >= 0)
        <div class="col-md-4 wow fadeIn" data-wow-duration="3s">
            <div class="card mb-4">
                <div class="card-header text-uppercase fw-bold">
                    {{ trans('shop::messages.goal.title') }}
                </div>
                <div class="card-body">
                    <div class="progress mb-1">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                             aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100"
                             style="width: {{ min($goal, 100) }}%"></div>
                    </div>

                    <p class="card-text text-center">
                        {{ trans_choice('shop::messages.goal.progress', $goal) }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>


<div class="list-group d-flex flex-md-row my-8">
    @if($displayHome)
        <a href="{{ route('shop.home') }}" class="list-group-item py-3 @if($category === null) active @endif wow fadeIn"
           data-wow-duration="1s">
            {{ trans('messages.home') }}
        </a>
    @endif

    @foreach($categories as $subCategory)
        <a href="{{ route('shop.categories.show', $subCategory) }}"
           class="list-group-item py-3 @if($subCategory->is($category)) active @endif wow fadeIn"
           data-wow-duration="1s">
            {{ $subCategory->name }}
        </a>

        @foreach($subCategory->categories as $cat)
            <a href="{{ route('shop.categories.show', $cat) }}"
               class="list-group-item ps-5 @if($cat->is($category)) active @endif wow fadeIn" data-wow-duration="1s">
                {{ $cat->name }}
            </a>
        @endforeach
    @endforeach
</div>
