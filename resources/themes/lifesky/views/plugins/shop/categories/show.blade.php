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
        <div>
            @include('shop::categories._top-bar')
        </div>

        <div>
            @include('shop::categories._user-infos')
        </div>

        <div class="col-lg-3">
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
                        <div class="card h-100">
                            @if($package->hasImage())
                                <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                    <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                                </a>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title fw-semibold">{{ $package->name }}</h5>
                                <h5 class="card-subtitle mb-3 text-sm">
                                    @if($package->isDiscounted())
                                        <del class="small text-danger">{{ $package->getOriginalPrice() }}</del>
                                    @endif
                                    {{ shop_format_amount($package->getPrice()) }}
                                </h5>


                               <div class="d-flex flex-row-reverse justify-content-between gap-2">
                                   @for($i=0; $i<5; $i++)
                                       @php

                                           if($i!=0){
                                              $quantity= $i*5;
                                           } else{
                                              $quantity=1;
                                           }
                                       @endphp
                                       <form action="{{ route('shop.packages.buy', $package) }}" method="POST">
                                           @csrf

                                           @if($package->has_quantity)
                                               <div>
                                                   <input type="hidden" class="form-control" name="quantity" id="quantity" value="5" required>
                                               </div>
                                           @endif

                                           <button type="submit" class="btn btn-primary py-1 px-2">
                                               {{$quantity}}x
                                           </button>
                                       </form>
                                   @endfor
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
