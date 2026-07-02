@if(!theme_config('sidebar.discord.off'))
    <div class="home-sideblock home-sideblock-discord">
        <h2 class="h3 mb-3">{{theme_config('sidebar.discord.title') ?? 'Discord'}}</h2>

        <div data-editable="true" class="d-flex align-items-center justify-content-end gap-2 mb-2">
            <span class="pulse"></span>
            <small
                class="text-xs fw-semibold text-uppercase">{{ theme_config('header.hero.discord.title') ?? str_replace(':count', '{discord_online}', trans('theme::theme.discord_online')) }}</small>
        </div>

        <ul class="discord-list d-flex flex-column gap-2 p-3 bg-body rounded-2 mb-3"></ul>

        <a href="{{theme_config('settings.discord.link')  ?? "https://discord.gg/ZdSPkxK5xT"}}" target="_blank"
           class="btn btn-primary w-100">{{ trans('theme::theme.join') }}</a>
    </div>

@endif
