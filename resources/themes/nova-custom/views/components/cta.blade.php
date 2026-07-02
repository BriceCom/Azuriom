@props([
    'icon' => "bi bi-megaphone",
    'title' => null,
    'button_text' => null,
    'button_url' => null,
])
<div class="home-cta d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 gap-md-4">
    <div class="home-cta-icon d-inline-flex align-items-center justify-content-center">
        <i class="{{ $icon }}"></i>
    </div>

    <div data-editable="true" class="home-cta-copy">
        <p class="mb-1 fw-bold text-1xl">{{ $title }}</p>
        @if($text)
            <p class="mb-0 opacity-75">{{ $text }}</p>
        @endif
    </div>

    @if($button_text)
        <a href="{{ $button_url ?? '#' }}" class="btn btn-primary home-cta-action ms-md-auto">

            @if(theme_config('home.cta.button.icon'))
                <i class="{{theme_config('home.cta.button.icon')}}"></i>
            @endif

            {{ $button_text }}
        </a>
    @endif
</div>
