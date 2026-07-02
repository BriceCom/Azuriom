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
    <hgroup>
        <h1>{{ theme_config('shop.title') ?? trans('shop::messages.title') }}</h1>
        <p> {{ theme_config('shop.text') ?? theme_config('shop.text') }}</p>
    </hgroup>

    <div class="row" id="shop">

        <div class="col-lg-3">
            @include('shop::categories._user')
            @include('shop::categories._sidebar')
        </div>

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
                        <div class="shop card h-100">
                            <span class="shop-price badge bg-quaternary rounded-1 fw-bold text-xl">
                                @if($package->isDiscounted())
                                    <del class="small text-danger">{{ $package->getOriginalPrice() }}</del>
                                @endif
                                {{ shop_format_amount($package->getPrice()) }}
                            </span>

                            @if($package->hasImage())
                                <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                    <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                                </a>
                            @endif

                            <div class="card-body">
                                <h4 class="card-title">{{ $package->name }}</h4>

                                <a href="#" class="btn btn-primary btn-block" data-package-url="{{ route('shop.packages.show', $package) }}">
                                    {{ trans('shop::messages.buy') }}
                                </a>
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
