<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header text-white">
            <h3 class="modal-title" id="itemModalLabel">{{ $package->name }}</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {!! $package->description !!}
        </div>
        <div class="flex items-center justify-between">
            <span class="font-bold text-2xl">
                @if($package->isDiscounted())
                    <del class="small">{{ shop_format_amount($package->getOriginalPrice()) }}</del>
                @endif
                {{ shop_format_amount($package->getPrice()) }}
            </span>

            @auth
                @if($package->isSubscription())
                    @if($package->isUserSubscribed())
                        <a href="{{ route('shop.profile') }}" class="btn btn-green">
                            {{ trans('shop::messages.actions.manage') }}
                        </a>
                    @else
                        <form action="{{ route('shop.subscriptions.select', $package) }}" method="POST" class="form-inline">
                            @csrf

                            <button type="submit" class="btn btn-green">
                                {{ trans('shop::messages.actions.subscribe') }}
                            </button>
                        </form>
                    @endif
                @elseif($package->isInCart())
                    <form action="{{ route('shop.cart.remove', $package) }}" method="POST" class=" form-inline">
                        @csrf

                        <button type="submit" class=" ms-auto btn btn-red">
                            {{ trans('messages.actions.remove') }} <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                @elseif($package->getMaxQuantity() < 1)
                    {{ trans('shop::messages.packages.limit') }}
                @elseif(! $package->hasBoughtRequirements())
                    {{ trans('shop::messages.packages.requirements') }}
                @else
                    <form action="{{ route('shop.packages.buy', $package) }}" method="POST" class="flex gap-4 items-center">
                        @csrf

                        @if($package->custom_price)
                            <div class="form-input">
                                <label for="price" class="form-label">{{ trans('shop::messages.fields.price') }}</label>
                                <input type="number" min="{{ $package->getPrice() }}" size="5" class="form-control" name="price" id="price" value="{{ $package->price }}">
                            </div>
                        @endif

                        <div class="flex items-center gap-4 ms-auto">
                            @if($package->has_quantity)
                                <div class="form-input">
                                    <label for="quantity" class="form-label">{{ trans('shop::messages.fields.quantity') }}</label>
                                    <input class="form-control" type="number" min="1" max="{{ $package->getMaxQuantity() }}" size="5" name="quantity" id="quantity" value="1" required>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-green">
                                Ajouter au panier <i class="bi bi-basket-fill"></i>
                            </button>
                        </div>
                    </form>
                @endif
            @else
                <div class="alert alert-info" role="alert">
                    {{ trans('shop::messages.cart.guest') }}
                </div>
            @endauth
        </div>
    </div>
</div>
