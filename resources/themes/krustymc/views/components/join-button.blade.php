@props([
    'content' => null
])
<button
    class="copyIp d-flex flex-column align-items-center btn @if(!$content) copyButton @else btn-secondary @endif mb-4 mb-md-0"
    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.server_address_copied')}}" aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
>
    <span class="d-flex align-items-center gap-2 text-uppercase">
        @if($content)
            {{ $content }}
        @else
            {{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}
        @endif
        <i class="bi bi-copy"></i>
    </span>
</button>
