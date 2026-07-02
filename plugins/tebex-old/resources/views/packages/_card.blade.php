<div class="card h-100">
    @if($package->image)
        <a href="#" data-package-url="{{ route('tebex.packages.show', $package->id) }}">
            <img class="card-img-top" src="{{ $package->image }}" alt="{{ $package->name }}">
        </a>    @endif

    <div class="card-body">
        <h4 class="card-title">{{ $package->name }}</h4>
        <h5 class="card-subtitle mb-3">
            @if(isset($package->price) && isset($package->price->discount) && $package->price->discount)
                <del class="small">{{ $package->price->discount + $package->price->normal }}</del>
            @elseif(isset($package->discount) && $package->discount)
                <del class="small">{{ $package->discount + $package->base_price }}</del>
            @endif

            @if(isset($package->price) && isset($package->price->normal))
                {{ $package->price->normal . tebex_currency_symbol($package->price->currency ?? 'USD') }}
            @else
                {{ $package->base_price . tebex_currency_symbol($package->currency ?? 'USD') }}
            @endif
        </h5>

{{--        <a href="#" class="btn btn-primary btn-block" data-package-url="{{ route('tebex.packages.show', $package->id) }}">--}}
{{--            {{ trans('tebex::messages.packages.buy') }}--}}
{{--        </a>--}}

        @auth
            <form action="{{ route('tebex.packages.buy', $package->id) }}" method="POST" class="row row-cols-lg-auto g-0 gy-2 align-items-center">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                <div class="mx-3">
                    <label for="quantity" class="visually-hidden">{{ trans('tebex::messages.fields.quantity') }}</label>
                    <input type="number" min="1" max="10" size="5" class="form-control" name="quantity" id="quantity" value="1" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ trans('tebex::messages.packages.buy') }}
                </button>
            </form>
        @else
            <div class="alert alert-info" role="alert">
                {{ trans('tebex::messages.cart.guest') }}
            </div>
        @endauth
    </div>
</div>
