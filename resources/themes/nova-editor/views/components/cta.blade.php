@props([
    'icon' => "bi bi-megaphone",
    'title' => null,
    'button_text' => null,
    'button_url' => null,
])
<div class="card p-3">
    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-3">
        <div class="btn btn-icon bg-body" style="min-width: 48px; height: 48px">
            <i class="
                   {{$icon}}"></i>
        </div>

        <div data-editable="true">
            <p class="mb-0 fw-bold">{{$title}}</p>
            @if($text)
                <p class="mb-0 opacity-75">{{ $text }}</p>
            @endif
        </div>

        @if($button_text)
            <a href="{{ $button_url ?? '#' }}" class="btn btn-primary ms-auto">

                @if(theme_config('home.cta.button.icon'))
                    <i class="{{theme_config('home.cta.button.icon')}}"></i>
                @endif

                {{ $button_text }}
            </a>
        @endif
    </div>
</div>
