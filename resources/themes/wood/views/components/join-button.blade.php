<button
    class="d-flex flex-column align-items-center btn btn-secondary rounded"
    data-copyboard="true"
    data-copyboard-text="{{theme_config('settings.server.ip')?? 'play.dixept.fr'}}"
    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.server_address_copied')}}" aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
>
    <span class="d-flex align-items-center gap-2 text-uppercase">
        {{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}
        <i class="bi bi-copy"></i>
    </span>
</button>
