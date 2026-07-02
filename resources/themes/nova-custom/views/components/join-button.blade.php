@props([
    'icon' => true,
    'variant' => 'primary',
    'content' => theme_config('settings.server.text') ?? 'Télécharger le launcher',
    'class' => null
])

@if(theme_config('settings.server.launcher'))
    <a
        class="d-flex flex-column align-items-center btn btn-{{$variant}} rounded {{ $class }}"
        href="{{ theme_config('settings.server.url') ?? 'https://dixept.fr' }}">
        {{$content}}
    </a>
@else
    <button
        class="d-flex flex-column align-items-center btn btn-{{$variant}} rounded {{ $class }}"
        data-copyboard="true"
        data-copyboard-text="{{theme_config('settings.server.ip')?? 'play.dixept.fr'}}"
        data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{trans('theme::theme.server_address_copied')}}"
        aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
    >
    <span class="d-flex align-items-center gap-2 text-uppercase">
            <i class="bi bi-copy"></i>
            {{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}
    </span>
    </button>
@endif
