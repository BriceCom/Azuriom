<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-5 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                <div class="my-4 text-center text-xl-start">
                    <h2 class="display-5 fw-bolder text-white mb-3">{{ $hero['title'] }}</h2>
                    <p class="lead fw-normal text-white-50 mb-4">{{ $hero['subtitle'] }}</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center justify-content-xl-start align-items-start">
                        @if(!empty($hero['primary_button_text']) && !empty($hero['primary_button_url']))
                            <a class="btn btn-primary btn-lg px-4 me-sm-2" href="{{ $hero['primary_button_url'] }}">
                                {{ $hero['primary_button_text'] }}
                            </a>
                        @endif

                        @if($serverIsLauncher)
                           <div>
                               <a class="d-block btn btn-outline-primary btn-lg px-4" href="{{ $serverLauncherUrl }}">
                                   {{ $serverLauncherText }}
                               </a>

                               @if($serverOnlinePlayers)
                                   <small class="d-block mt-2 pomodoro-hero-server-status">
                                       {{ trans('theme::theme.home.hero.online_players', ['count' => number_format($serverOnlinePlayers, 0, '.', '')]) }}
                                   </small>
                               @endif
                           </div>
                        @else
                            <div>
                                <button type="button"
                                        class="btn btn-outline-primary btn-lg px-4"
                                        data-copy-server-ip="true"
                                        data-copyboard-text="{{ $serverIp }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        data-bs-original-title="{{ $serverCopiedText }}"
                                        data-bs-trigger="manual">
                                    <i class="bi bi-copy me-1"></i> {{ $serverIp }}
                                </button>
                                @if($serverOnlinePlayers)
                                    <small class="d-block mt-2 pomodoro-hero-server-status">
                                        {{ trans('theme::theme.home.hero.online_players', ['count' => number_format($serverOnlinePlayers, 0, '.', '')]) }}
                                    </small>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                <img class="img-fluid rounded-3 my-5 pomodoro-hero-image" src="{{ $hero['image'] }}" alt="{{ $hero['title'] }}">
            </div>
        </div>
    </div>
</header>
