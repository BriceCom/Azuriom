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
    <h1 class="d-none">{{ $category->name }}</h1>

    <div class="row" id="shop">
        <div class="col-12">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-12">
            <div class="row gy-10 gx-7">
                @if($category->description)
                    <div class="col-12 mb-5 mb-md-8">
                        <div class="card">
                            <div class="card-body pb-1">
                                {!! $category->description !!}
                            </div>
                        </div>
                    </div>
                @endif


                <div class="col-12">
                    <div class="d-flex flex-wrap justify-content-between package-wrapper">
                        @forelse($category->packages as $package)
                            <div class="d-flex justify-content-center package">
                                <div class="card flex-grow-1 @if($loop->last) last @endif">
                                    @if(theme_config('shop.index.offer.'.$loop->iteration.'.text'))
                                        <span class="package__discount" style="background-color: {{theme_config('shop.index.offer.'.$loop->iteration.'.hex')}};">{{theme_config('shop.index.offer.'.$loop->iteration.'.text')}}</span>
                                    @endif
                                    <div class="package__img">
                                        @if($package->hasImage())
                                            <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                                <img height="260" class="card-img-top" src="{{ $package->imageUrl() }}"
                                                     alt="{{ $package->name }}">
                                            </a>
                                        @endif
                                    </div>

                                    <div class="card-body d-flex flex-column align-items-center text-center justify-content-between gap-2 pt-0">
                                        <div>
                                            @php
                                                $number = null;
                                                $text = $package->name;
                                                preg_match('/(\d+)/', $package->name, $matches);
                                                if($matches){
                                                    $number = $matches[0];
                                                    $text = preg_replace('/\d+/', '', $package->name);
                                                }

                                            @endphp

                                            <span class="d-block card-title fw-bold h4 mb-1"><img class="me-2 object-fit-contain" src="{{ theme_config('shop.index.art-image') ? image_url(theme_config('shop.index.art-image')) : theme_asset('images/illu_rubis.png') }}" width="20" alt="Rubis"/> @if($number) <span class="fw-bold text-primary">{{ $number }}</span> @endif {{ $text }}</span>
                                            <span class="card-subtitle mb-3 fw-normal h6">
                                        @if($package->isDiscounted())
                                                    <del class="small text-danger">{{ $package->getOriginalPrice() }}</del>
                                                @endif
                                                {{ shop_format_amount($package->getPrice()) }}
                                    </span>
                                        </div>

                                        <a href="#" class="btn btn-primary btn-block rounded-2 text-sm py-1"
                                           data-package-url="{{ route('shop.packages.show', $package) }}">
                                            Ajouter au panier
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
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"
         aria-hidden="true"></div>
@endsection
