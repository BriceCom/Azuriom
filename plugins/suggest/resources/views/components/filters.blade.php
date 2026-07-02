@props([
    'filter',
    'categories' => collect(),
    'selectedCategory' => null,
    'categoryQuery' => [],
    'disableCategoryFilters' => false,
])

@if($categories->isNotEmpty() && ! $disableCategoryFilters)
    <form method="GET" action="{{ route('suggest.index') }}" class="mb-3">
        <input type="hidden" name="filter" value="{{ $filter }}">
        <label for="suggest-category-filter" class="form-label">
            {{ trans('suggest::messages.fields.category') }}
        </label>
        <select id="suggest-category-filter" name="category" class="form-select" onchange="this.form.submit()">
            <option value="">{{ trans('suggest::messages.filter.all_categories') }}</option>
            @foreach($categories as $categoryOption)
                <option value="{{ $categoryOption->id }}" @selected((string) $categoryOption->id === (string) $selectedCategory)>
                    {{ $categoryOption->name }}
                </option>
            @endforeach
        </select>
    </form>
@endif

<div class="list-group">
    @if(setting('suggest.filters.all', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'all'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'all') active @endif">
            <span><i class="bi bi-list-ul"></i> {{ trans('suggest::messages.filter.all') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.pending', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'pending'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'pending') active @endif">
            <span><i class="bi bi-hourglass-top"></i> {{ trans('suggest::messages.filter.pending') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.approved', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'approved'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'approved') active @endif">
            <span><i class="bi bi-check-circle-fill"></i> {{ trans('suggest::messages.filter.approved') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.rejected', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'rejected'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'rejected') active @endif">
            <span><i class="bi bi-x-circle-fill"></i> {{ trans('suggest::messages.filter.rejected') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.recent', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'recent'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'recent') active @endif">
            <span><i class="bi bi-clock"></i> {{ trans('suggest::messages.filter.recent') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.oldest', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'oldest'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'oldest') active @endif">
            <span><i class="bi bi-calendar"></i> {{ trans('suggest::messages.filter.oldest') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.popular', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'popular'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'popular') active @endif">
            <span><i class="bi bi-star-fill"></i> {{ trans('suggest::messages.filter.popular') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.unpopular', true))
        <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'unpopular'])) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'unpopular') active @endif">
            <span><i class="bi bi-star"></i> {{ trans('suggest::messages.filter.unpopular') }}</span>
        </a>
    @endif

    @if(setting('suggest.filters.mine', true))
        @auth
            <a href="{{ route('suggest.index', array_merge($categoryQuery, ['filter' => 'mine'])) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if($filter === 'mine') active @endif">
                <span><i class="bi bi-person-fill"></i> {{ trans('suggest::messages.filter.mine') }}</span>
            </a>
        @endauth
    @endif
</div>
