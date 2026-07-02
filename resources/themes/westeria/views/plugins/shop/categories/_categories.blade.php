@php
    $slug = isset(request()->route()->parameters['category']) ? request()->route()->parameters['category']->slug:"";
@endphp
@includeIf('shop::categories._user-infos')
<div class="card overflow-visible mb-4">
    <div class="category-links card-body d-flex flex-wrap gap-3">
        @if($displayHome)
            <a href="{{ route('shop.home') }}" class="bg-black bg-opacity-25 border border-2 border-secondary border-opacity-25 py-2 px-3 text-decoration-none fw-semibold @if($category === null) text-warning active @else text-white @endif">
                {{ trans('messages.home') }}
            </a>
        @endif

        @foreach($categories as $subCategory)
            <div class="bg-black bg-opacity-25 border border-2 border-secondary border-opacity-25 py-2 px-3">
                <a href="{{ route('shop.categories.show', $subCategory) }}" class="text-decoration-none fw-semibold @if($subCategory->is($category)) text-warning active @else text-white @endif">
                    {{ $subCategory->name }}

                    <a id="{{ $subCategory->name }}" class="dropdown-toggle @if($subCategory->is($category)) text-warning @endif" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
