<section>
    @include('components.cta')

    @if(theme_config('home.video.trailer.off') !== 'on')
        <div class="card">
            <div class="card-body">
                <iframe style="width: 100%; border-radius: var(--di-border-radius-sm);" height="520" src="{{theme_config('home.video.url') ?? "https://www.youtube.com/embed/jNQXAC9IVRw?si=lTKgsFHHbmwglXdX"}}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    @endif
</section>
