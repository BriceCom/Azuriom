@if(request()->routeIs('shop.home') && isset($welcome))
    <div class="card">
        <div class="card-body">
            {!! $welcome !!}
        </div>
    </div>
@else
    <div class="alert alert-warning mb-0">
        {{ trans('theme::reborn.page_component_unavailable', ['component' => trans('theme::reborn.page_shop_home_welcome')]) }}
    </div>
@endif
