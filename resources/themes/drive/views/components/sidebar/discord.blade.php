@if(!theme_config('sidebar.discord.off'))
    <div class="card">
        <div class="card-body">
            <h2 class="h3">{{theme_config('sidebar.discord.title') ?? 'Discord'}}</h2>

            <div data-editable="true" class="d-flex align-items-center justify-content-end gap-2 mb-1">
                <span class="pulse"></span>
                <small
                    class="text-xs fw-semibold text-uppercase">{{ theme_config('header.hero.discord.title') ?? str_replace(':count', '{discord_online}', trans('theme::theme.discord_online')) }}</small>
            </div>

            <ul class="discord-list d-flex flex-column gap-2 p-3 bg-body rounded-2"></ul>

            <a href="{{theme_config('settings.discord.link')  ?? "https://discord.gg/ZdSPkxK5xT"}}" target="_blank"
               class="btn btn-primary">{{ trans('theme::theme.join') }}</a>
        </div>
    </div>

@endif
