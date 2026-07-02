@if(request()->routeIs('shop.categories.show') && isset($category) && $category && !empty($category->description))
    <div class="card">
        <div class="card-body pb-1">
            {!! $category->description !!}
        </div>
    </div>
@elseif(!request()->routeIs('shop.categories.show') || !isset($category) || !$category)
    <div class="alert alert-warning mb-0">
        {{ trans('theme::reborn.page_component_unavailable', ['component' => trans('theme::reborn.page_shop_category_description')]) }}
    </div>
@endif
