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
    <div class="card">
        <div class="card-body">
            <div class="row" id="shop">
                <div class="col-lg-9">
                    @include('shop::categories._categories')
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
                                <div class="card bg-primary bg-opacity-25 border-0 h-100">
                                    @if($package->hasImage())
                                        <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                            <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                                        </a>
                                    @endif
                                    <div class="h-100">

                                    </div>

                                    <div class="card-body  bg-primary bg-opacity-50 m-2 d-flex align-items-center gap-3">
                                        <h6 class="card-title fw-semibold">{{ $package->name }}</h6>

                                        <a href="#" class="w-100 btn btn-primary" data-package-url="{{ route('shop.packages.show', $package) }}">
                                            {{ trans('shop::messages.buy') }}
                                            <small class="d-block card-subtitle fw-semibold">
                                                @if($package->isDiscounted())
                                                    <del class="small">{{ $package->getOriginalPrice() }}</del>
                                                @endif
                                                {{ shop_format_amount($package->getPrice()) }}
                                            </small>
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
                <div class="col-lg-3">
                    @include('shop::categories._sidebar')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
@endsection
