
@if(theme_config('settings.server.launcher.on'))
    <a
        class="d-flex flex-column align-items-center btn btn-primary rounded"
        href="{{ theme_config('settings.server.launcher.url') ?? 'https://dixept.fr' }}">
        {{theme_config('settings.server.text') ?? 'play.dixept.fr'}}
    </a>
@else
    <button
        class="d-flex flex-column align-items-center btn btn-primary mb-4 mb-md-0 rounded"
        data-copyboard="true"
        data-copyboard-text="{{theme_config('settings.server.ip')?? 'play.dixept.fr'}}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.server_address_copied')}}" aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
    >
        <span class="d-flex align-items-center gap-2 text-uppercase">
            {{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}
            <i class="bi bi-copy"></i>
        </span>
    </button>
@endif
