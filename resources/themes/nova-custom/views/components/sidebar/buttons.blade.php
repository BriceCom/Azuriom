@if(!theme_config('sidebar.buttons.off'))
    <div class="home-sideblock home-sideblock-actions">
        <ul class="row list-unstyled g-2 mb-0">
            <li class="col-12">
                <a href="{{ theme_config('settings.server.url') ?? '#' }}"
                   data-copyboard="true"
                   data-copyboard-text="{{theme_config('settings.server.ip')?? 'play.dixept.fr'}}"
                   data-bs-toggle="tooltip" data-bs-placement="bottom"
                   data-bs-original-title="{{trans('theme::theme.server_address_copied')}}"
                   aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
                   class="w-100 btn btn-outline-primary">
                    {{ theme_config('settings.server.text') ?? 'play.dixept.fr' }}
                </a>
            </li>
            @if(plugins()->isEnabled('vote'))
                <li class="col-6">
                    <a href="{{ theme_config('sidebar.vote_button.url') ?? '#' }}" class="w-100 btn btn-outline-quaternary">{{theme_config('sidebar.vote_button.text') ?? 'Voter'}}</a>
                </li>
            @endif
            @if(plugins()->isEnabled('shop'))
                <li class="col-6">
                    <a href="{{ theme_config('sidebar.shop_button.url') ?? '#' }}" class="w-100 btn btn-outline-tertiary">{{theme_config('sidebar.shop_button.text') ?? 'Boutique'}}</a>
                </li>
            @endif
        </ul>
    </div>
@endif
