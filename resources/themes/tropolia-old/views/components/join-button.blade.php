@props([
    'icon' => true,
    'style' => 'special',
    'content' => theme_config('settings.server.text') ?? 'Télécharger le launcher'
])

<a href="{{theme_config('settings.server.url') ?? '#'}}" class="btn btn-primary"
>
    <span class="d-flex align-items-center gap-2 text-uppercase">
        {{$content}}
        @if($icon)
            <i class="bi bi-play-fill text-xl"></i>
        @endif
    </span>
</a>
