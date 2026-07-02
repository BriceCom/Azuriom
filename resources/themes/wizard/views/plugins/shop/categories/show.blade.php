@extends('layouts.app')

@section('title', $category->name)

@push('footer-scripts')
    <script>
        document.querySelectorAll('[data-package-url]').forEach(function (el) {
            el.addEventListener('click', function (ev) {
                ev.preventDefault()

                axios.get(el.dataset['packageUrl']).then(function (response) {
                    const itemModal = document.getElementById('itemModal')
                    itemModal.innerHTML = response.data
                    new bootstrap.Modal(itemModal).show()
                }).catch(function (error) {
                    createAlert('danger', error, true)
                })
            })
        })
    </script>
@endpush

@php
    // Récupérer l'URL actuelle
    $url = URL::current();
    $segments = explode('/', $url);
    $categoryIndex = array_search('categories', $segments);
    $lastStringUrlCategory = mb_strtolower($segments[$categoryIndex + 1]);
@endphp

@section('content')

    <div class="row" id="shop">
        <div class="col-lg-3">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-lg-9">
            @if($lastStringUrlCategory === 'grades')
                <div class="bg-gray-900 pb-2 text-center pb-3">
                    <div class="block_title d-flex align-items-center justify-content-center pt-3 pb-1">
                        <img src="{{theme_asset('/images/petits/badge.png')}}"
                             alt="décoration">
                        <h1 class="mx-3 mb-0 py-0 fs-3 bg-image-none text-capitalize">{{ $category->name }}</h1>
                        <img src="{{theme_asset('/images/petits/badge.png')}}"
                             alt="décoration">
                    </div>
                    @if($category->description)
                        <p class="mb-0">{!! $category->description !!}</p>
                    @endif
                </div>
            @else
                <div class="visually-hidden">
                    <h1>{{ $category->name }}</h1>
                </div>
            @endif
            @if($lastStringUrlCategory === 'grades')
                <div class="table-responsive">
                    <table class="table__grade w-100">
                        <thead>
                        <tr>
                            <th class="bg-purple-800"></th>
                            @forelse($category->packages as $package)
                                <th class="bg-purple-800 text-center">
                                <span
                                    class="d-inline-block border border-purple-500 bg-purple-600 rounded-pill px-2 py-1 fs-6 fw-normal mx-auto">{{ $package->name }}</span>
                                    <span class="d-block pb-2 pt-3 text-purple-200">
                                     @if($package->isDiscounted())
                                            <del class="small">{{ $package->getOriginalPrice() }}</del>
                                        @endif
                                        {{ shop_format_amount($package->getPrice()) }} <span
                                            class="text-purple-500 fw-normal">/version</span>
                                </span>
                                </th>
                            @empty
                                <th class="col">
                                    <div class="alert alert-warning" role="alert">
                                        <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.categories.empty') }}
                                    </div>
                                </th>
                            @endforelse
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="table__grade-title fs-5 font-family-azul text-start">
                            <td colspan="5" class="text-start bg-purple-900">Commandes</td>
                        </tr>
                        @foreach(theme_config('shop.commandes.index') ?? [] as $value)
                            <tr>
                                @foreach($value as $val)
                                    @if($val === "true")
                                        <td>
                                            <svg style="color: #77B5FE;" role="img" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                      d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                                            </svg>
                                        </td>

                                    @elseif($val === null)
                                        <td>
                                            <svg style="color: #a0aec0; opacity: .3;" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                      d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
                                            </svg>
                                        </td>
                                    @else
                                        <td class="{{$loop->index === 0 ? 'text-start' :''}}">
                                            {{$val}}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="table__grade-title fs-5 font-family-azul text-start">
                            <td colspan="5" class="text-start bg-purple-900">Kits</td>
                        </tr>
                        @foreach(theme_config('shop.kits.index') ?? [] as $value)
                            <tr>
                                @foreach($value as $val)
                                    @if($val === "true")
                                        <td>
                                            <svg style="color: #77B5FE;" role="img" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                      d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                                            </svg>
                                        </td>

                                    @elseif($val === null)
                                        <td>
                                            <svg style="color: #a0aec0; opacity: .3;" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                      d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
                                            </svg>
                                        </td>
                                    @else
                                        <td class="{{$loop->index === 0 ? 'text-start' :''}}">
                                            {{$val}}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="table__grade-title fs-5 font-family-azul text-start">
                            <td colspan="5" class="text-start bg-purple-900">Divers</td>
                        </tr>
                        @foreach(theme_config('shop.divers.index') ?? [] as $value)
                            <tr>
                                @foreach($value as $val)
                                    @if($val === "true")
                                        <td>
                                            <svg style="color: #77B5FE;" role="img" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                      d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                                            </svg>
                                        </td>

                                    @elseif($val === null)
                                        <td>
                                            <svg style="color: #a0aec0; opacity: .3;" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                      d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
                                            </svg>
                                        </td>
                                    @else
                                        <td class="{{$loop->index === 0 ? 'text-start' :''}}">
                                            {{$val}}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        <tfooter>
                            <th class="bg-purple-800"></th>
                            @foreach($category->packages as $package)
                                <th class="bg-purple-800">
                                    <a href="#" class="btn btn-primary btn-block"
                                       data-package-url="{{ route('shop.packages.show', $package) }}">
                                        {{ trans('shop::messages.buy') }}
                                    </a>
                                </th>
                            @endforeach
                        </tfooter>
                        </tbody>
                    </table>
                </div>

            @else
                <div class="row gy-4 shop__card">

                    @forelse($category->packages as $package)
                        <div class="col-md-4">
                            <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}" title="{{ trans('shop::messages.buy') }}" class="d-block h-100 position-relative">
                                @if($package->hasImage())
                                        <img class="card-img-top" src="{{ $package->imageUrl() }}"
                                             alt="{{ $package->name }}">
                                @endif
                                    <span class="position-absolute top-0 end-0 m-1 d-inline-block border border-purple-500 bg-purple-600 text-white rounded-pill px-2 py-1 fs-6 fw-normal">
                                     @if($package->isDiscounted())
                                            <del class="small">{{ $package->getOriginalPrice() }}</del>
                                        @endif
                                        {{ shop_format_amount($package->getPrice()) }}
                                    </span>
                                <div class="card-body">
                                    <h4>{{ $package->name }}</h4>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col">
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.categories.empty') }}
                            </div>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"
         aria-hidden="true"></div>
@endsection
