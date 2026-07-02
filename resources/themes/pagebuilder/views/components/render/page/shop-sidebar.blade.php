@if(request()->routeIs('shop.*') && isset($categories))
    @if(isset($displayHome))
        @include('shop::categories._sidebar')
    @else
        <div class="alert alert-warning mb-0">
            {{ trans('theme::pagebuilder.page_component_unavailable', ['component' => trans('theme::pagebuilder.page_shop_sidebar')]) }}
        </div>
    @endif
@else
    <div class="alert alert-warning mb-0">
        {{ trans('theme::pagebuilder.page_component_unavailable', ['component' => trans('theme::pagebuilder.page_shop_sidebar')]) }}
    </div>
@endif
