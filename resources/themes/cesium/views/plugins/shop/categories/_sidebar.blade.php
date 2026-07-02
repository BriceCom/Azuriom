@auth
    <div class="mb-10">
        <ul class="flex flex-col gap-4">
            <li>
                <a href="{{ route('shop.cart.index') }}" class="flex gap-4 items-center justify-center shadow-sm p-4 rounded-xl btn bg-steel-400 hover:bg-steel-200 hs-tooltip-toggle font-medium  transition duration-200 text-sm text-white">
                    <i class="bi bi-basket-fill"></i> Accéder à mon panier
                </a>
            </li>
            @if(use_site_money())
                <li>
                    <a href="{{ route('shop.offers.select') }}" class="flex gap-4 items-center justify-center shadow-sm p-4 rounded-xl btn bg-steel-400 hover:bg-steel-200 hs-tooltip-toggle font-medium  transition duration-200 text-sm text-white">
                        <i class="bi bi-coin"></i> <p>{{ trans('shop::messages.profile.money', ['balance' => format_money(auth()->user()->money)]) }} <small>(Créditer mon compte)</small></p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endauth
<div class="card mb-10">
    <div class="flex flex-col gap-3">
        @if($displayHome)
            <a href="{{ route('shop.home') }}" class="hover:text-white/80 @if($category === null) active @endif">
                {{ trans('messages.home') }}
            </a>
        @endif

        @foreach($categories as $subCategory)
            <a href="{{ route('shop.categories.show', $subCategory) }}" class="hover:text-white/80  @if($subCategory->is($category)) active @endif">
                {{ $subCategory->name }}
            </a>


            @foreach($subCategory->categories as $cat)
                <a href="{{ route('shop.categories.show', $cat) }}" class="ps-4 -ms-px border-s-2 border-transparent text-sm text-steel-50 hover:border-steel-100 hover:text-white @if($cat->is($category)) border-white underline @endif">
                    {{ $cat->name }}
                </a>
            @endforeach
        @endforeach
    </div>
</div>

<div class="card">
    <div class="flex flex-col gap-4">
        @if($goal !== false)
            <div class=" mb-10">
                <h1 class="text-lg font-medium text-center mb-6"><i class="bi bi-graph-up"></i> {{ trans('shop::messages.goal.title') }}</h1>

                <div>
                    <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden" role="progressbar" aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: {{ min($goal, 100) }}%"></div>
                    </div>

                    <small>
                        {{ trans_choice('shop::messages.goal.progress', $goal) }}
                    </small>
                </div>
            </div>
        @endif

        @if($topCustomer !== null)
            <div class="mb-10">
                <h1 class="text-lg font-medium text-center mb-6"><i class="bi bi-star"></i> {{ trans('shop::messages.top.title') }}</h1>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <img class="rounded" src="{{ $topCustomer->user->getAvatar(64) }}" alt="{{ $topCustomer->user->name }}" width="52">
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
            <div class="mb-10">

                <h1 class="text-lg font-medium text-center mb-6"><i class="bi bi-people"></i> {{ trans('shop::messages.recent.title') }}</h1>
                <div class="flex flex-col gap-4">
                    @forelse($recentPayments as $payment)
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 d-flex align-items-center">
                                <img src="{{ $payment->user->getAvatar(48) }}" class="rounded" alt="{{ $payment->user->name }}" width="32">
                            </div>
                            <div>
                                <p>{{ $payment->user->name }}</p>
                                <p class="text-xs text-steel-100">
                                    @if($displaySidebarAmount)
                                        {{ $payment->price.' '.currency_display() }} -
                                    @endif
                                    {{ format_date($payment->created_at) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item">
                            {{ trans('shop::messages.recent.empty') }}
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
