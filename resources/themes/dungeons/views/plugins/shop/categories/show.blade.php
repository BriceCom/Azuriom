@extends('layouts.app')

@php
    $cart = Azuriom\Plugin\Shop\Cart\Cart::fromSession(request()->session());
@endphp

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
    <div class="position-relative text-center">
        <div>
            <h2>{{theme_config('shop.content.title') ? theme_config('shop.content.title'):'Boutique'}}</h2>
            <p>{{theme_config('shop.content.paragraph') ? theme_config('shop.content.paragraph'):'Cette monnaie est utilisable dans la boutique du serveur'}}</p>
        </div>
        <div class="cart-button-wrapper position-absolute top-50 end-0 translate-middle-y">
            <a title="Voir le contenu de votre panier" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{$cart->count()}} ARTICLE{{$cart->count()>1 ?'S':''}}" href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block cart-button py-2">
                <i>
                    <svg width="36" height="36" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 15C13.8954 15 13 15.8954 13 17C13 18.1046 13.8954 19 15 19C16.1046 19 17 18.1046 17 17C17 15.8954 16.1046 15 15 15ZM15 15H7.29395C6.83269 15 6.60197 15 6.41211 14.918C6.24466 14.8456 6.09934 14.7288 5.99349 14.5802C5.87348 14.4118 5.82609 14.1863 5.72945 13.7353L3.27148 2.26477C3.17484 1.81376 3.12587 1.58825 3.00586 1.4198C2.90002 1.27123 2.75525 1.15441 2.5878 1.08205C2.39794 1 2.16779 1 1.70653 1H1M4 4H16.8732C17.595 4 17.9557 4 18.1979 4.15036C18.4101 4.28206 18.5652 4.48838 18.6329 4.72876C18.7102 5.00319 18.611 5.34996 18.411 6.04346L17.0264 10.8435C16.9068 11.2581 16.8469 11.4655 16.7256 11.6193C16.6185 11.7551 16.4772 11.8608 16.3171 11.926C16.1356 12 15.9199 12 15.4883 12H5.73047M6 19C4.89543 19 4 18.1046 4 17C4 15.8954 4.89543 15 6 15C7.10457 15 8 15.8954 8 17C8 18.1046 7.10457 19 6 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </i>
            </a>
        </div>
    </div>

    <div class="row" id="shop">
        <div class="col">
            <div class="row gy-4 mt-2">
                @if($category->description)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                {!! $category->description !!}
                            </div>
                        </div>
                    </div>
                @endif

                @forelse($category->packages as $package)
                    <div class="col-md-6 col-xl-4">
                        <div class="shop-card card" style=" @if($package->hasImage()) background-image: url('{{ $package->imageUrl() }}');background-size: cover;background-position: center; @endif height:375px">
                            <a data-package-url="{{ route('shop.packages.show', $package) }}" rel="noreferrer">

                            </a>

                            <div class="card-body d-flex flex-column justify-content-end p-0">
                                <div class="shop-card-content p-3">
                                    <h3 class="card-title mb-1">{{ $package->name }}</h3>
                                    <span class="card-subtitle fw-light h4">
                                        @if($package->isDiscounted())
                                            <del class="small">{{ $package->getOriginalPrice() }}</del>
                                        @endif
                                        {{ shop_format_amount($package->getPrice()) }}
                                    </span>

                                    <div class="mt-1">
                                        <button data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="AJOUTÉ AU PANIER" class="btn btn-primary btn-block py-2 px-3" data-package-url="{{ route('shop.packages.show', $package) }}">
                                            <i class="me-2">
                                                <svg width="17" height="17" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15 15C13.8954 15 13 15.8954 13 17C13 18.1046 13.8954 19 15 19C16.1046 19 17 18.1046 17 17C17 15.8954 16.1046 15 15 15ZM15 15H7.29395C6.83269 15 6.60197 15 6.41211 14.918C6.24466 14.8456 6.09934 14.7288 5.99349 14.5802C5.87348 14.4118 5.82609 14.1863 5.72945 13.7353L3.27148 2.26477C3.17484 1.81376 3.12587 1.58825 3.00586 1.4198C2.90002 1.27123 2.75525 1.15441 2.5878 1.08205C2.39794 1 2.16779 1 1.70653 1H1M4 4H16.8732C17.595 4 17.9557 4 18.1979 4.15036C18.4101 4.28206 18.5652 4.48838 18.6329 4.72876C18.7102 5.00319 18.611 5.34996 18.411 6.04346L17.0264 10.8435C16.9068 11.2581 16.8469 11.4655 16.7256 11.6193C16.6185 11.7551 16.4772 11.8608 16.3171 11.926C16.1356 12 15.9199 12 15.4883 12H5.73047M6 19C4.89543 19 4 18.1046 4 17C4 15.8954 4.89543 15 6 15C7.10457 15 8 15.8954 8 17C8 18.1046 7.10457 19 6 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </i>
                                            <span>{{ trans('shop::messages.buy') }}</span>
                                        </button>
                                    </div>
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
