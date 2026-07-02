<div class="d-flex align-items-center gap-3">
    @foreach(social_links() as $link)
        <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
           data-bs-toggle="tooltip"
           class="social d-inline-block h5" style="--social-color: {{ $link->color }}">
            <i class="{{ $link->icon }}"></i>
        </a>
    @endforeach
</div>
