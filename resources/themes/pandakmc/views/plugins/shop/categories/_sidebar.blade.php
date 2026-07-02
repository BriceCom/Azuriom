{{--<div class="list-group mb-3">--}}
{{--    @if($displayHome)--}}
{{--        <a href="{{ route('shop.home') }}" class="list-group-item @if($category === null) active @endif">--}}
{{--            {{ trans('messages.home') }}--}}
{{--        </a>--}}
{{--    @endif--}}

{{--    @foreach($categories as $subCategory)--}}
{{--        <a href="{{ route('shop.categories.show', $subCategory) }}" class="list-group-item @if($subCategory->is($category)) active @endif">--}}
{{--            {{ $subCategory->name }}--}}
{{--        </a>--}}

{{--        @foreach($subCategory->categories as $cat)--}}
{{--            <a href="{{ route('shop.categories.show', $cat) }}" class="list-group-item ps-5 @if($cat->is($category)) active @endif">--}}
{{--                {{ $cat->name }}--}}
{{--            </a>--}}
{{--        @endforeach--}}
{{--    @endforeach--}}
{{--</div>--}}
<div class="row gx-15 gy-5">
    @if($topCustomer !== null)
        <div class="col-lg-6">
            <div class="shop__sideitem border border-3 border-white pt-6 px-8">
                <h3 class="fw-bold text-uppercase text-center">Meilleur acheteur du mois</h3>

                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3 mt-4">
                    <div class="order-2 shop__top-avatar">
                        <img src="https://mc-heads.net/body/{{ $topCustomer->user->name }}/150"
                             alt="{{ $topCustomer->user->name }}">
                    </div>
                    <div class="d-flex flex-column align-items-center order-1 order-md-3 my-4 mt-md-0">
                        <span class="fw-bold text-uppercase h4">{{ $topCustomer->user->name }}</span>
                        <div class="shop__top-tag">
                            <span class="text-uppercase">Tag</span>
                            <b style="--tag-color: #3CDCFF">{{theme_config("shop.index.tag") ?? "#ACTIONNAIRE"}}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($goal > 0)
        <div class="col-lg-6">
            <div class="shop__sideitem border border-3 border-white py-6 px-8">
                <h3 class="fw-bold text-uppercase text-center">Objectif mensuel</h3>

                <div class="d-flex flex-column align-items-center gap-3 mt-6">
                    <span class="fw-bold h6 mb-0">{{ trans_choice('shop::messages.goal.progress', $goal) }}é</span>
                    <div class="progress mb-0">

                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                             aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100"
                             style="width: {{ min($goal, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{--    <div class="col-lg-6">--}}
    {{--        <div class="shop__sideitem border border-3 border-white py-6 px-8">--}}
    {{--            <h3 class="fw-bold text-uppercase text-center">Objectif de panier</h3>--}}

    {{--            <div class="d-flex flex-column align-items-center gap-3 mt-6">--}}
    {{--                <span class="fw-bold h6 mb-0">26/45€ de récolté</span>--}}
    {{--                <progress value="26" max="45" class="w-100"></progress>--}}
    {{--                <p class="fw-lighter text-xs text-uppercase lh-base text-center">Tous les 45€ de dépensé dans la boutique, un giveaway global débutera  sur le serveur permettant d'obtenir une récompense épique !</p>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>


@auth
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-end gap-4 my-7">
        @if(use_site_money())
            <p class="text-center mb-0">
                {{ format_money(auth()->user()->money) }}
            </p>

            <a href="{{ route('shop.offers.select') }}" class="btn btn-primary btn-block rounded-3">
                {{ trans('shop::messages.cart.credit') }}
            </a>
        @endif

        <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block rounded-3">
            <i class="bi bi-cart"></i> {{ trans('shop::messages.cart.title') }}
        </a>
    </div>
@endauth


{{--@if($recentPayments !== null)--}}
{{--    <div class="card mb-4">--}}
{{--        <div class="card-header">--}}
{{--            <i class="bi bi-list-check"></i> {{ trans('shop::messages.recent.title') }}--}}
{{--        </div>--}}
{{--        <div class="list-group list-group-flush">--}}
{{--            @forelse($recentPayments as $payment)--}}
{{--                <div class="list-group-item d-flex">--}}
{{--                    <div class="flex-shrink-0 d-flex align-items-center">--}}
{{--                        <img src="{{ $payment->user->getAvatar(48) }}" class="me-3 rounded" alt="{{ $payment->user->name }}" width="32">--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1">--}}
{{--                        <p class="mb-1">{{ $payment->user->name }}</p>--}}
{{--                        <small>--}}
{{--                            @if($displaySidebarAmount)--}}
{{--                                {{ $payment->price.' '.currency_display() }} ---}}
{{--                            @endif--}}
{{--                            {{ format_date($payment->created_at) }}--}}
{{--                        </small>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @empty--}}
{{--                <div class="list-group-item">--}}
{{--                    {{ trans('shop::messages.recent.empty') }}--}}
{{--                </div>--}}
{{--            @endforelse--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}
