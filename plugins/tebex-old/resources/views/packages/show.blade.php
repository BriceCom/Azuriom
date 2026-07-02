<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        coucou


{{--        <div class="modal-header">--}}
{{--            <h3 class="modal-title" id="itemModalLabel">{{ $package->name }}</h3>--}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--        </div>--}}
{{--        <div class="modal-body">--}}
{{--            {!! $package->description !!}--}}
{{--        </div>--}}
{{--        <div class="modal-footer">--}}
{{--            <span class="flex-md-fill font-weight-bold">--}}
{{--                {{ $package->price->normal . tebex_currency_symbol($package->price->currency) }}--}}
{{--            </span>--}}

{{--            @auth--}}
{{--                <form action="{{ route('tebex.cart.add') }}" method="POST" class="row row-cols-lg-auto g-0 gy-2 align-items-center">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="package_id" value="{{ $package->id }}">--}}

{{--                    <div class="mx-3">--}}
{{--                        <label for="username" class="visually-hidden">{{ trans('tebex::messages.modal.mc_pseudo') }}</label>--}}
{{--                        <input type="text" class="form-control" id="username" name="username"--}}
{{--                               value="{{ session('tebex_username', Auth::user()->name ?? '') }}"--}}
{{--                               placeholder="{{ trans('tebex::messages.modal.mc_pseudo') }}" required>--}}
{{--                    </div>--}}

{{--                    <div class="mx-3">--}}
{{--                        <label for="quantity" class="visually-hidden">{{ trans('tebex::messages.fields.quantity') }}</label>--}}
{{--                        <input type="number" min="1" max="10" size="5" class="form-control" name="quantity" id="quantity" value="1" required>--}}
{{--                    </div>--}}

{{--                    <button type="submit" class="btn btn-primary">--}}
{{--                        {{ trans('tebex::messages.packages.buy') }}--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            @else--}}
{{--                <div class="alert alert-info" role="alert">--}}
{{--                    {{ trans('tebex::messages.cart.guest') }}--}}
{{--                </div>--}}
{{--            @endauth--}}
{{--        </div>--}}
    </div>
</div>
