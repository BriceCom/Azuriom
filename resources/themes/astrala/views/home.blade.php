@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main id="home" class="d-flex flex-column align-items-center justify-content-center">
        <div>
            <div class="background">
                <div class="background-wrapper overflow-hidden">
                    <img class="object-fit-cover" tabindex="-1" src="{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}" alt="Illustration du jeu Minecraft">
                    <div class="background-gradient"></div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center gap-3_5 text-center">
                <img class="logo" src="{{ theme_config('home.image') ? image_url(theme_config('home.image')):site_logo() }}" alt="{{ site_name() }}" height="205">
                <hgroup class="d-contents text-center">
                    <h1 class="fw-bold">{{theme_config('home.title') ?? "Bienvenue sur ". site_name() . "!"}}</h1>
                    <p>{{theme_config('home.subtitle') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation."}}</p>
                </hgroup>
                <button id="copyButton" class="btn btn-primary text-uppercase btn-ip">{{theme_config('home.ip.text') ?? 'play.astrala.fr'}}</button>
                <div class="d-flex align-items-center connected-player">
                    <span class="rounded-pill circle on"></span>
                    <p class="m-0 connected-player-infos">
                        Serveur en ligne -
                        @if($server)
                            @if($server->isOnline())
                                {{$server->getOnlinePlayers()}} Joueurs
                            @else
                                {{ trans('messages.server.offline') }}
                            @endif
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </main>
    @include('elements.footer_small')
@endsection
