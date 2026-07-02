@extends('layouts.base')

@section('app')
    @php
        $launcherMode = theme_config('hero.server.launcher.on') && theme_config('hero.server.launcher.url');
    @endphp
    <div class="home-background d-flex align-items-center justify-content-end flex-column text-white pb-md-15 pb-3 @if(theme_config('hero.appHide.toggle')) appHide @endif" style="background: rgb(87,110,247);background: radial-gradient(circle, rgba(87,110,247,0) 6%, rgba(var(--bs-black-rgb),0.6) 98%),linear-gradient(rgba(18,23,37,0.79), rgba(var(--bs-light-rgb),0.8)),url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') no-repeat center; background-size: cover">

        @if(!theme_config('hero.appHide.toggle'))
        <div class="container d-flex flex-column flex-md-row justify-content-center align-items-center gap-md-4">
            @if($launcherMode)
                <a href="{{ theme_config('hero.server.launcher.url') }}" class="hero-small-box d-flex align-items-center gap-3 bg-dark bg-opacity-25 p-3 text-white text-decoration-none">
                    <div>
                        <h2 class="m-0 fs-5">{{ theme_config('hero.server.launcher.text') ?? 'PLAY' }}</h2>
                        <p class="m-0">{{ str_replace(['https://', 'http://'], '', theme_config('hero.server.launcher.url')) }}</p>
                    </div>
                    <i class="{{theme_config('hero.server.icon') ?? 'bi bi-box-fill'}} fs-1"></i>
                </a>
            @else
                <div data-clipboard-text="{{theme_config('hero.server.ip') ?? 'play.dixept.fr'}}" class="copy_ip hero-small-box d-flex align-items-center gap-3 bg-dark bg-opacity-25 p-3" style="cursor : pointer;">
                    <div>
                        <h2 class="m-0 fs-5 server_count">
                            @if($servers->where('home_display')->count() > 1)
                                @php
                                    $totalPlayers = 0;
                                @endphp
                                @foreach($servers->where('home_display') as $server)
                                    @php
                                        $totalPlayers += $server->getOnlinePlayers();
                                    @endphp
                                @endforeach
                            @endif
                            @if($servers->where('home_display')->count() > 0)
                                <span class="server_count_span">{{$totalPlayers??$server->getOnlinePlayers()}}</span> {{theme_config('hero.server.text') ?? 'PLAYERS ONLINE'}}
                            @else
                                {{theme_config('hero.server.text') ?? 'SERVER OFFLINE'}}
                            @endif
                        </h2>
                        <div class="position-relative">
                            <p class="ip_address m-0">{{theme_config('hero.server.ip') ?? 'play.dixept.fr'}}</p>
                            <span class="ip_copy position-absolute text-nowrap bg-secondary rounded-3 mx-5 px-2 py-1 text-center d-none">{{theme_config('hero.server.textcopied') ?? 'IP COPIED!'}}</span>
                        </div>
                    </div>
                    <i class="{{theme_config('hero.server.icon') ?? 'bi bi-box-fill'}} fs-1"></i>
                </div>
            @endif
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(setting('logo'))
                    <img width="200" height="200" style="object-fit: contain;" src="{{ image_url(setting('logo')) }}" alt="Logo">
                @else
                    {{ site_name() }}
                @endif
            </a>
            <a href="{{theme_config('hero.discord.url') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" target="_blank" class="hero-small-box d-flex align-items-center gap-3 bg-dark bg-opacity-25 p-3 text-white text-decoration-none">
                <i class="{{theme_config('hero.discord.icon') ?? 'bi bi-discord'}} fs-1"></i>
                <div>
                    <h2 class="m-0 fs-5 discord-list_count"><span>{{theme_config('hero.discord.text') ?? 'USERS ONLINE'}}</span></h2>
                    <p class="m-0">{{theme_config('hero.discord.url') ? str_replace(['https://', 'http://', 'discord.gg'], ['','','DISCORD.GG'], theme_config('hero.discord.url')):'DISCORD.GG/Gh2yBxUWvV'}}</p>
                </div>
            </a>

        </div>
            @endif
    </div>
    @push('footer-scripts')
        @include('components.general.discordAPI', ['onlyCounter' => true])
    @endpush
    </div>
    <main class="content bg-body">
        <div id="{{str_contains(request()->route()->uri, 'cps') ? '':(request()->route()->uri)}}" class="container py-10">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
