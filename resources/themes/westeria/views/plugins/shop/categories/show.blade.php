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

                <div class="col-12 mb-4">
                    <div class="card overflow-visible">
                        <div class="card-body">
                            <div class="row gy-4">
                                @forelse($category->packages as $package)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card overflow-visible position-relative h-100">
                                            @if($package->hasImage())
                                                <a href="#"
                                                   data-package-url="{{ route('shop.packages.show', $package) }}"
                                                   class="text-center">
                                                    <img class="card-img-top" src="{{ $package->imageUrl() }}"
                                                         alt="{{ $package->name }}">
                                                </a>
                                            @endif
                                            <div class="h-100">

                                            </div>
                                            <div class="card-body border-0 d-flex flex-column align-items-center p-2 py-3 gap-3">
                                                <h5 class="card-title fw-semibold text-center mb-0">{{ $package->name }}</h5>

                                                <p class="position-absolute d-flex align-items-center bg-dark rounded-2 px-3 py-1 border border-2 border-secondary border-opacity-50 d-block card-subtitle fw-semibold"
                                                    style="right: 12px; top: 12px;"
                                                >
                                                    @if($package->isDiscounted())
                                                        <del
                                                            class="small text-danger me-2">{{ $package->getOriginalPrice() }}</del>
                                                    @endif
                                                    {{ $package->getPrice() }} <img class="ms-2" src="{{theme_config('shop.img') ? image_url(theme_config('shop.img')): 'https://cdn-icons-png.flaticon.com/128/2933/2933116.png'}}" alt="Icône monnaie" width="16" height="16">
                                                </p>

                                                <div class="d-flex align-items-center gap-1 mt-auto">
                                                    <a href="#"
                                                       class="btn btn-success w-100 text-sm text-white"
                                                       data-package-url="{{ route('shop.packages.show', $package) }}">
                                                        Ajouter au panier
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
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            @include('shop::categories._sidebar')
        </div>
    </div>
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"
         aria-hidden="true"></div>
@endsection
