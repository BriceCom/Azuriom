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
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row gap-10" id="shop">
            <div class="min-w-[380px] order-2 lg:order-1">
                @include('shop::categories._sidebar')
            </div>

            <div class="card h-fit grow order-1">
                <div class="mb-16">
                    <h1 class="text-lg font-medium mb-2">{{ $category->name }}</h1>
                    @if($category->description)
                        <div class="mb-4 text-white/50">
                            {!! $category->description !!}
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-1 mg:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($category->packages as $package)
                        <div class=" border bg-steel-300 border-steel-200 rounded-2xl text-white py-6 p-4 ">
                            <div class="h-full flex flex-col items-center text-center gap-4">
                                <div class="grow">
                                    @if($package->hasImage())
                                        <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                            <img class="-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                                        </a>
                                    @endif
                                </div>

                                <div class="w-full">
                                    <h4 class="text-xl">{{ $package->name }}</h4>
                                    <h5>
                                        @if($package->isDiscounted())
                                            <del class="small text-red-400">{{ $package->getOriginalPrice() }}</del>
                                        @endif
                                        <span class="opacity-75">
                                            {{ shop_format_amount($package->getPrice()) }}
                                        </span>
                                    </h5>

                                    <a href="#" class="btn btn-green mt-6 " data-package-url="{{ route('shop.packages.show', $package) }}">
                                        {{ trans('shop::messages.buy') }} <small> <i class="bi bi-cart-fill"></i></small>
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

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
@endsection
