@php
    $videoUrl = trim((string) (theme_config('home.video.url') ?? 'https://www.youtube.com/embed/sOE98frT3Uk?si=Xd-Io8SuMz6RN4Wy'));

    if (str_contains($videoUrl, 'watch?v=')) {
        $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
    } elseif (str_contains($videoUrl, 'youtu.be/')) {
        $videoUrl = preg_replace('#https?://(?:www\.)?youtu\.be/([A-Za-z0-9_-]+).*$#', 'https://www.youtube.com/embed/$1', $videoUrl) ?? $videoUrl;
    }
@endphp

<section class="trailer-section">
    <div class="container">
        <div class="section-copy text-center mb-5">
            <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">
                {{ theme_config('home.video.badge') ?? trans('theme::admin.menus.home.trailer') }}
            </span>
            <h2>{{ theme_config('home.video.title') ?? trans('theme::admin.menus.home.trailer') }}</h2>
            @if(theme_config('home.video.text'))
                <p>{{ theme_config('home.video.text') }}</p>
            @endif
        </div>

        <div class="trailer ratio ratio-16x9 overflow-hidden">
            <iframe class="w-100 h-100"
                    src="{{ $videoUrl }}"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
        </div>
    </div>
</section>
