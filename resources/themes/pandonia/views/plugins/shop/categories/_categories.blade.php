@php
    $slug = isset(request()->route()->parameters['category']) ? request()->route()->parameters['category']->slug:"";
@endphp
<div class="d-block @if($slug != "grades") d-md-none @endif mb-4">
    @includeIf('shop::categories._user-infos')
</div>
<div class="card overflow-visible mb-4">
    <div class="category-links card-body d-flex flex-wrap justify-content-center gap-4">
        @if($displayHome)
            <a href="{{ route('shop.home') }}" class="text-decoration-none fw-bold h5 @if($category === null) text-warning active @else text-white-50 @endif">
                {{ trans('messages.home') }}
            </a>
        @endif

        @foreach($categories as $subCategory)
            <div>
                <a href="{{ route('shop.categories.show', $subCategory) }}" class="text-decoration-none fw-bold h5 @if($subCategory->is($category)) text-warning active @else text-white-50 @endif">
                    {{ $subCategory->name }}

                    <a id="{{ $subCategory->name }}" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i></i>
                    </a>
                </a>

                <div class="dropdown-menu dropdown-menu-end"  aria-labelledby="{{ $subCategory->name }}">
                    @foreach($subCategory->categories as $cat)
                        <a href="{{ route('shop.categories.show', $cat) }}" class="dropdown-item text-decoration-none ps-2 @if($cat->is($category)) active @endif">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

        @endforeach
    </div>
</div>
