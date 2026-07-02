<header class="header position-relative" data-variant="1">
    @include('elements.navbar')
    <div class="header-bg"></div>
    <div class="header-bottom_circle">
    </div>
    <div class="postion-relative d-flex justify-content-center py-4 pb-10">
        <div class="d-flex justify-content-center container pb-5">
            <div class="row justify-content-center align-items-center gx-3 flex-grow-1">
                @if(!theme_config('hero.server.toggle'))
                    <div class="col-md-4 d-flex justify-content-center">
                        <a id="copyButton" href="#" class="copyButton d-flex flex-column text-decoration-none">
                            <div class="d-flex">
                                <p class="bg-quaternary bg-opacity-75 text-body-emphasis fw-semibold px-2 py-1 rounded-pill mb-1">
                                    @foreach($servers->where('home_display') as $server)
                                        @if($server->isOnline())
                                            {{$server->getOnlinePlayers()}}
                                        @else
                                            OFF
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <div class="text-quaternary">
                                    @if(!theme_config('hero.server.icon'))
                                        <svg role="presentation" viewBox="0 0 24 24" height="50" width="50">
                                            <path
                                                d="M4,2H20A2,2 0 0,1 22,4V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V4A2,2 0 0,1 4,2M6,6V10H10V12H8V18H10V16H14V18H16V12H14V10H18V6H14V10H10V6H6Z"
                                                style="fill: currentcolor;">
                                            </path>
                                        </svg>
                                    @else
                                        <i class="{{theme_config('hero.server.icon') ?? 'bi bi-controller'}} h1"></i>
                                    @endif
                                </div>
                                <div class="copyButton d-flex flex-column" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.server_address_copied')}}" aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual">
                                    <span
                                        class="text-uppercase fw-semibold text-quaternary">{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}</span>
                                    <small id="copyButton_text"
                                           class="text-white text-uppercase fw-semibold">{{trans('theme::theme.copy_server_address')}}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <div class="col-md-4 text-center">
                    <a href="/">
                        <img class="hero-logo w-100 img-fluid object-fit-contain" src="{{site_logo()}}"
                             alt="{{site_name()}}"
                            style="height: {{theme_config("header.index.hero.img.height") ? theme_config("header.index.hero.img.height")."px":"auto"}}">
                    </a>
                </div>
                @if(!theme_config('hero.discord.toggle'))
                    <div class="col-md-4 d-flex justify-content-center">
                        <a href="{{theme_config('settings.discord.link') ?? 'https://discord.gg/Gh2yBxUWvV'}}"
                           target="_blank" class="d-flex flex-column text-decoration-none">
                            <div class="d-flex justify-content-end">
                                <p id="discordCount"
                                   class="bg-quaternary  bg-opacity-75 fw-semibold px-3 py-1 rounded-pill mb-1 text-body-emphasis">
                                    0</p>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex flex-column text-end">
                                    <span class="text-uppercase fw-semibold text-quaternary">{{ "Discord" }}</span>
                                    <small
                                        class="text-white text-uppercase fw-semibold">{{trans('theme::theme.copy_discord_address')}}</small>
                                </div>
                                <div class="text-quaternary">
                                    <i class="{{ theme_config('hero.discord.icon') ?? 'bi bi-discord' }} h1"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
