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
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end mb-10 gap-5">
        <div>
            <h1 class="title-bl wow fadeIn" data-wow-duration="2s">
                <div class="color-white">
                    {{ $category->name }}
                </div>
                <div class="subtitle">
                    {{ $category->name }}
                </div>
            </h1>
            @if($category->description)
                <div class="w-75 title-description mt30 fweight-300 my-0 wow fadeIn wysiwyg" data-wow-duration="3s">
                        {!! $category->description !!}
                </div>
            @endif
        </div>

        <div>
            @auth
                @if(use_site_money())
                    <p class="text-end mb-2">
                        {{ trans('shop::messages.profile.money', ['balance' => format_money(auth()->user()->money)]) }}
                    </p>
                @endif
                <div class="d-flex justify-content-between justify-content-lg-end gap-2">
                    <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block text-nowrap">
                        <i class="bi bi-cart-fill"></i> {{ trans('shop::messages.cart.title') }}
                    </a>

                    @if(use_site_money())
                        <a href="{{ route('shop.offers.select') }}" class="btn btn-warning btn-block text-nowrap">
                            <i class="bi bi-wallet-fill"></i> Créditer mon compte
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>

    <div class="row" id="shop">
        <div class="col-12">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-12">
            <div class="row gy-4">
                @forelse($category->packages as $package)
                    <div class="col-md-4 wow fadeInUp" data-wow-duration="{{$loop->iteration/3}}s">
                        <div class="card h-100">
                            @if($package->hasImage())
                                <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                    <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                                </a>
                            @endif

                            <div class="card-body">
                                <h4 class="card-title">{{ $package->name }}</h4>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <h5 class="card-subtitle">
                                        @if($package->isDiscounted())
                                            <del class="small text-danger">{{ $package->getOriginalPrice() }}</del>
                                        @endif
                                        {{ shop_format_amount($package->getPrice()) }}
                                    </h5>

                                    <a href="#" class="btn btn-primary btn-block" data-package-url="{{ route('shop.packages.show', $package) }}">
                                        {{ trans('shop::messages.buy') }}
                                    </a>
                                </div>
                            </div>
                        </div>
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
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
@endsection
