<div class="card-header">
    <h3 class="m-0 font-weight-bold text-primary">{{trans('theme::lang.shop.title')}}</h3>
</div>
<div class="card-body">
    <div class="row">
        @foreach($menus[$page_current]['configs'] ?? [] as $config)
            @include('admin.pattern.builder-items', $config)
        @endforeach
    </div>
</div>
