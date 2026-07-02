@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="home-background" style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;
    ">
        <div class=" d-flex align-items-center justify-content-center py-5 py-md-15">
            <img src="{{site_logo()}}" alt="Logo de {{site_name()}}" height="440" class="logo my-md-5 mb-4">
        </div>

        <div class="home-stats mb-10">
            <div class="container">
                <div class="row gap-5 gap-xl-0 ">
                    <div class="card-stat justify-content-between">
                        <div class="p-0 pe-xl-5">
                            <div class="h-100 card-bottom-shadow card-gradient-from-bottom p-2">
                                <div class="h-100 card card-gradient-from-bottom-content">
                                    <h2 class="h4 px-3 py-2 fw-semibold">Statistiques</h2>
                                    <div class="h-100 d-flex flex-column gap-4 px-3 pt-4">
                                        <div>
                                            @php
                                                $allUsers = \Azuriom\Models\User::all()->count();
                                            @endphp
                                            <b class="d-block fs-1 text-tertiary-gradient">{{$allUsers}}</b>
                                            <span class="fw-medium">Joueurs inscrits</span>
                                        </div>
                                        @for($i = 1; $i <= 1; $i++)
                                            <div class="py-2">
                                                <b class="d-block fs-1 text-tertiary-gradient">{{theme_config('home.stats.'.$i.'.title') ?? "202"}}</b>
                                                <span class="fw-medium">{{theme_config('home.stats.'.$i.'.text') ?? "Record de connectés"}}</span>
                                            </div>
                                        @endfor
                                        <div>
                                            @if($servers)
                                                @php
                                                    $connected = 0
                                                @endphp
                                                @foreach($servers as $server)
                                                    @if($server->isOnline())
                                                        @php
                                                            $connected += $server->getOnlinePlayers()
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            <b class="d-block fs-1 text-tertiary-gradient">{{$connected}}</b>
                                            <span class="fw-medium">Joueurs en ligne</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8 px-md-0 px-3">
                            <div class="h-100 card-bottom-shadow card-gradient-from-bottom pe-2 pb-2">
                                <div class="h-100 card d-flex flex-column flex-lg-row">
                                    @foreach($posts->take(1) as $post)
                                        <div class="col-12 col-lg-8">
                                            @if($post->hasImage())
                                                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-100 object-fit-cover first-post-img" height="404">
                                            @endif
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="h-100 card-wrapper-shadow card-gradient-from-bottom d-flex flex-column m-2 me-0 mt-0">
                                                <h2 class="line-clamp-2 gradient-left-100-dark py-3 px-3">{{ $post->title }}</h2>
                                                <div class="flex-grow-1 d-flex flex-column justify-content-between p-3 py-2">
                                                    <p>{{ Str::limit(strip_tags($post->content), 259) }}</p>
                                                    <a href="{{ route('posts.show', $post) }}" class="w-fit btn btn-primary mb-3">Lire plus
                                                        <i><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g filter="url(#filter0_d_3_115)">
                                                                    <path d="M1.98568 15L10 7.5L1.98568 0L0 1.85824L6.02865 7.5L0 13.1418L1.98568 15Z" fill="white"/>
                                                                </g>
                                                                <defs>
                                                                    <filter id="filter0_d_3_115" x="0" y="0" width="10" height="18" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                                        <feOffset dy="3"/>
                                                                        <feComposite in2="hardAlpha" operator="out"/>
                                                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.17 0"/>
                                                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3_115"/>
                                                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3_115" result="shape"/>
                                                                    </filter>
                                                                </defs>
                                                            </svg>
                                                        </i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">

            @include('elements.session-alerts')

            @if($message)
                <div class="card mb-4">
                    <div class="card-body">
                        {{ $message }}
                    </div>
                </div>
            @endif
        </div>

        <div class="home-overbackground">
            <div class="container">
                @if(! $posts->isEmpty())
                    <div class="row card-bottom-shadow card-wrapper-shadow gy-3 mb-15 pb-2">
                        @foreach($posts->take(4) as $post)
                            @if(!$loop->first)
                                <div class="col-lg-4 m-0 p-0">
                                    <div class="card p-3 h-100 d-flex flex-column gap-4">
                                        @if($post->hasImage())
                                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="card-img-top card-bottom-shadow object-fit-cover mt-2" height="250">
                                        @endif
                                        <div class="card-body d-flex flex-column text-center pt-2 p-0">
                                            <h2 class="card-title gradient-left-100 p-1 line-clamp-1">{{ $post->title }}</h2>
                                            <p class="flex-grow-1 card-text pt-2 fw-medium">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                                            <a class="w-fit btn btn-primary mx-auto" href="{{ route('posts.show', $post) }}">Lire plus
                                                <i><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g filter="url(#filter0_d_3_115)">
                                                            <path d="M1.98568 15L10 7.5L1.98568 0L0 1.85824L6.02865 7.5L0 13.1418L1.98568 15Z" fill="white"/>
                                                        </g>
                                                        <defs>
                                                            <filter id="filter0_d_3_115" x="0" y="0" width="10" height="18" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                                <feOffset dy="3"/>
                                                                <feComposite in2="hardAlpha" operator="out"/>
                                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.17 0"/>
                                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3_115"/>
                                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3_115" result="shape"/>
                                                            </filter>
                                                        </defs>
                                                    </svg>
                                                </i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif


                <div class="row mb-15">
                    <div class="col-md-4">
                        @include('components.general.discord')
                    </div>
                    <div class="col-md-8">
                        <div class="minecraft-steps p-4 py-5">
                            <ul class="list-unstyled d-flex flex-column gap-4">
                                <li class="d-flex align-items-center gap-2 py-1">
                                    <span class="minecraft-steps__number me-2">1</span>
                                    <p class="m-0">Lancez <b>Minecraft Java Edition</b> dans la version de votre choix.</p>
                                </li>
                                <li class="d-flex align-items-center gap-2 py-1">
                                    <span class="minecraft-steps__number me-2">2</span>
                                    <p class="m-0">Cliquez sur <b>Multijoueur</b>.</p>
                                </li>
                                <li class="d-flex align-items-center gap-2 py-1">
                                    <span class="minecraft-steps__number me-2">3</span>
                                    <p class="m-0">Cliquez sur <b>nouveau serveur</b>.</p>
                                </li>
                                <li class="d-flex align-items-start gap-2 py-1">
                                    <span class="minecraft-steps__number me-2">4</span>
                                    <p class="m-0 d-flex flex-wrap gap-1 mt-md-1">Saisissez l'IP
                                        <button
                                            class="copyButton d-flex flex-column  bg-transparent cursor-pointer border-0 mb-0 p-0"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual"
                                        >
                                            <span class="fw-medium text-uppercase text-warning">{{theme_config('settings.server.ip')??"play.dixept.fr"}}</span>
                                        </button>
                                        dans la barre <b>Adresse du serveur</b> et appuyez sur le bouton <b>Terminé</b>.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@includeIf('components.general.discordAPI')
