@extends('layouts.app')

@section('title', $category->name)

@php
    $slug = isset(request()->route()->parameters['category']) ? request()->route()->parameters['category']->slug:"";
@endphp

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
        <div class="@if($slug != "grades") col-lg-9 @endif">
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
                        <div class="card-body @if($slug == "grades") pb-8 @endif">
                            <div class="row">
                                @php $count=0 @endphp
                                @forelse($category->packages as $package)
                                    @php
                                        $hexpattern = '/^#[0-9a-fA-F]+$/';
                                        $pattern = '/<tr[^>]*>.*?<td[^>]*>(.*?)<\/td>.*?<\/tr>/s';
                                        preg_match_all($pattern, $package->description, $matches);

//                                        $count++;

                                        if($loop->iteration % 5 == 0) {
                                            $count=0;
                                        } else {
                                            $count++;
                                        }
                                    @endphp
                                    <div class="@if($slug != "grades") col-md-6 col-lg-4 @else col-md-6 col-lg-3 @endif"
                                         style="margin-top: {{100 - $count * (10 + $count) }}px">
                                        <div class="card overflow-visible h-100">
                                            @if($package->hasImage())
                                                <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}" class="@if(!empty($matches[1])) position-absolute top-0 start-50 translate-middle @endif text-center" >
                                                    <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}" @if(!empty($matches[1])) height="117" @endif>
                                                </a>
                                            @endif
                                            @if(empty($matches[1]))
                                                <div class="h-100">

                                                </div>
                                            @endif

                                            <div
                                                class="card-body @if(!empty($matches[1])) card-comparate rounded-2 pt-5 @endif border-0 d-flex flex-column align-items-center m-2 gap-3"
                                                @if(!empty($matches[1]))
                                                    style="@if(preg_match($hexpattern, $matches[1][0])) border-color:{{$matches[1][0]}} !important;@endif
                                                            padding-top: {{48 + $count * (10 + $count) }}px !important"
                                                @endif
                                            >
                                                <h5 class="card-title fw-semibold text-warning text-center mb-0 @if(!empty($matches[1])) h4 text-uppercase fw-bold @endif"
                                                    @if(!empty($matches[1]))style="@if(preg_match($hexpattern, $matches[1][0]))color:{{$matches[1][0]}} !important;@endif"@endif
                                                >{{ $package->name }}</h5>

                                                <p class="d-block card-subtitle fw-semibold">
                                                    @if($package->isDiscounted())
                                                        <del
                                                            class="small text-danger">{{ $package->getOriginalPrice() }}</del>
                                                    @endif
                                                    {{ shop_format_amount($package->getPrice()) }}
                                                </p>

                                                @if(!empty($matches[1]))
                                                    <ul class="w-100 d-none d-lg-flex list-unstyled flex-column align-items-center gap-1 pt-3">
                                                        @foreach($matches[1] as $data)
                                                            @if(!preg_match($hexpattern, $data))
                                                                <li class="px-2 text-center"> {!! $data !!}</li>
                                                                @if(!$loop->last)
                                                                    <hr class="w-100 border-secondary opacity-25 my-1"/>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                <div class="@if(!empty($matches[1])) cat-grade @endif d-flex align-items-center gap-1 mt-auto">
                                                    <a href="#" class="btn btn-info text-white text-sm fw-bold"
                                                       data-package-url="{{ route('shop.packages.show', $package) }}">
                                                        <i class="bi bi-info-lg"></i>
                                                    </a>
                                                    <a href="#"
                                                       class="btn btn-success @if(!empty($matches[1])) w-75 btn-warning text-black p-2  fw-bold position-absolute top-100 start-50 translate-middle @else w-100 text-sm text-white @endif"
                                                       data-package-url="{{ route('shop.packages.show', $package) }}">
                                                        @if(empty($matches[1]))
                                                            <i class="bi bi-plus-lg"></i> Ajouter au panier
                                                        @else
                                                            Voir plus
                                                        @endif
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
        @if($slug != "grades")
            <div class="col-lg-3">
                @include('shop::categories._sidebar')
            </div>
        @endif
    </div>
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"
         aria-hidden="true"></div>
@endsection
