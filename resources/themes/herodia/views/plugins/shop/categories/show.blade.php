@extends('layouts.app')

@section('title', $category->name)

@push('footer-scripts')
    <script>
        document.querySelectorAll('[data-package-url]').forEach(function (el) {
            el.addEventListener('click', function (ev) {
                ev.preventDefault();

                axios.get(el.dataset['packageUrl']).then(function (response) {
                    const itemModal = document.getElementById('itemModal');
                    itemModal.innerHTML = response.data;
                    new bootstrap.Modal(itemModal).show();
                }).catch(function (error) {
                    createAlert('danger', error, true);
                });
            });
        });
    </script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-10 offset-lg-1 col-md-12">
            <div class="list-group mb-3 categories-group">
                @if($displayHome)
                    <a href="{{ route('shop.home') }}" class="list-group-item @if($category === null) active @endif">
                        {{ trans('messages.home') }}
                    </a>
                @endif

                @foreach($categories as $subCategory)
                    <a href="{{ route('shop.categories.show', $subCategory) }}" class="list-group-item @if($subCategory->is($category)) active @endif">
                        {{ $subCategory->name }}
                    </a>

                    @foreach($subCategory->categories as $cat)
                        <a href="{{ route('shop.categories.show', $cat) }}" class="list-group-item ps-5 @if($cat->is($category)) active @endif">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                @endforeach
            </div>

            @auth
                <div class="d-grid gap-2 mb-4 basket">
                    @if(use_site_money())
                        <p class="text-center mb-0">
                            {{ trans('shop::messages.profile.money', ['balance' => format_money(auth()->user()->money)]) }}
                        </p>

                        <a href="{{ route('shop.offers.select') }}" class="btn btn-block">
                            {{ trans('shop::messages.cart.credit') }}
                        </a>
                    @endif

                    <a href="{{ route('shop.cart.index') }}" class="btn btn-block">
                        <i class="bi bi-cart"></i> {{ trans('shop::messages.cart.title') }}
                    </a>
                </div>
            @endauth
        </div>
    </div>  

    <div class="row">
        <div class="col-lg-9">
            <div class="row gy-4">
                @if($category->description)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pb-1">
                                {!! $category->description !!}
                            </div>
                        </div>
                    </div>
                @endif

                @forelse($category->packages as $package)
                    <div class="col-md-4">
                        <form action="{{ route('shop.packages.buy', $package) }}" method="POST" class="align-items-center">
                            @csrf

                                <div class="card h-100 btq-item">
                                    @if($package->image !== null)
                                        <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">      
                                    @endif

                                    <div class="card-body">
                                        <h4 class="card-title">{{ $package->name }}</h4>
                                        <h5 class="card-subtitle mb-3">
                                            @if($package->isDiscounted())
                                                <del class="small">{{ $package->getOriginalPrice() }}</del>
                                            @endif
                                            {{ shop_format_amount($package->getPrice()) }}
                                        </h5>
                            <button type="submit" class="btn btn-primary mb-3" style="border: 0; width: 100%;">Acheter</button>

                                        
                                                
                                    </div>
                                </div>
                        </form>
                    </div>
                @empty
                    <div class="col">
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.categories.empty') }}
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="col-lg-3 text-center gy-4">
            @if($topCustomer !== null)
                <div class="card-btq mb-4">
                    <h4><i class="fa-solid fa-trophy"></i> Meilleur acheteur<br> du mois</h4>
                
                    <div class="flex-shrink-0 p-1 list-group-item">
                        <img  src="https://minotar.net/avatar/{{ $topCustomer->user->name }}" alt="{{ $topCustomer->user->name }}" width="55">
                    </div>
                        <p class="h4 mb-1">{{ $topCustomer->user->name }}</p>
                </div>
            @endif

            @if($recentPayments !== null)
                <div class="card-btq">
                    <h4><i class="fa-solid fa-money-bill"></i> {{ trans('shop::messages.recent.title') }}</h4>
                    <div class="list-group-item d-flex py-4 justify-content-evenly">
                        @forelse($recentPayments as $payment)
                            <img src="https://minotar.net/avatar/{{ $payment->user->name }}" alt="{{ $payment->user->name }}" width="50">
                        @empty
                            {{ trans('shop::messages.recent.empty') }}
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
    

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
@endsection
