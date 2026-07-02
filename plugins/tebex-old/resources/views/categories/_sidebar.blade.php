<a href="{{ route('tebex.cart.index') }}" class="w-100 btn btn-primary btn-block mb-3">
    <i class="bi bi-cart"></i> {{ trans('tebex::messages.cart.title') }}
</a>

<div class="list-group mb-3">
    <a href="{{ route('tebex.index') }}" class="list-group-item @if(!isset($category)) active @endif">
        {{ trans('tebex::messages.home.home') }}
    </a>
    @foreach($categories as $subCategory)
        <a href="{{ route('tebex.category', $subCategory->id) }}#packages" class="list-group-item @if(isset($category) && $category->id == $subCategory->id) active @endif">
            {{ $subCategory->name }}
        </a>

        @foreach($subCategory->subcategories as $cat)
            <a href="{{ route('tebex.category', $cat->id) }}#packages" class="list-group-item ms-3 @if(isset($category) && $category->id == $cat->id) active @endif">
                {{ $cat->name }}
            </a>
        @endforeach
    @endforeach
</div>
