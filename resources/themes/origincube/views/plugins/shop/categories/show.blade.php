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
    <div class="pageTitle">
        <h1>BOUTIQUE D'{{site_name()}}</h1>
        <p class="fw-normal text-light">Achetez des crédits afin d'acquérir différents avantages.</p>
    </div>


    <div class="row" id="shop">
        <div class="col-lg-12">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="row p-6 py-12 gx-4 gy-8">
                    @forelse($category->packages as $package)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card bg-black h-100">
                                <div class="position-relative card-body p-2">
                                    <div class="position-absolute package-img">
                                        @if($package->hasImage())
                                            <img class="w-100 h-100 object-fit-contain" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="h1 package-title card-title mb-0">{{ $package->name }}</h3>
                                        <span class="card-subtitle text-lg">
                                        @if($package->isDiscounted())
                                                <del class="small">{{ $package->getOriginalPrice() }}</del>
                                            @endif
                                            {{ shop_format_amount($package->getPrice()) }}
                                        </span>
                                    </div>

                                    <div class="d-flex flex-column">
                                        <a href="#" class="btn bg-dark border-dark btn-block mt-3 text-light fw-normal" data-package-url="{{ route('shop.packages.show', $package) }}">
                                            En savoir plus
                                        </a>
                                        <a href="#" class="btn btn-primary btn-block mt-2" data-package-url="{{ route('shop.packages.show', $package) }}">
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
{{--                @if($category->description)--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-body pb-1">--}}
{{--                                {!! $category->description !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
@endsection
