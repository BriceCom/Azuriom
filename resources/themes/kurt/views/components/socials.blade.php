<div class="d-flex align-items-center gap-2">
    @foreach(social_links() as $link)
        <a href="{{ $link->value }}" title="{{ $link->title }}" data-bs-toggle="tooltip" target="_blank" rel="noopener noreferrer"
           class="social d-inline-flex align-items-center justify-content-center text-decoration-none" style="--social-color: {{ $link->color }}; --social-color-opacity: {{ $link->color }}b0">
            <i class="d-flex {{ $link->icon }} align-items-center"></i>
        </a>
    @endforeach
</div>
