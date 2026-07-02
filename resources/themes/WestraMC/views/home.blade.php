@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="container content">
        <div class="container my-5 my-md-15">
            <div class="row align-items-center gap-8 gap-md-0">
                <div class="col-md-6 text-center text-md-start">
                    <h1>Bienvenue <br/><span class="h3">sur le meilleur <b class="text-primary">pvp/faction</b> tout simplement</span>
                    </h1>
                    <hr/>
                    <p>Notre équipe s’engage à vous faire découvrir
                        la meilleure expérience de jeu possible.</p>
                    <p><i class="fw-lighter">De plus, chez {{site_name()}}, votre sécuritée est 100% garantie !<br/>
                            Nos bases de données sont sécurisée, et vos mots de passes
                            sont cryptés</i></p>
                    <p>Vous êtes notre priorité !</p>
                    <button
                        class="copyButton d-flex flex-column align-items-center bg-transparent cursor-pointer border-0 mb-0 mx-auto mx-md-0"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!"
                        aria-label="Adresse copiée!" data-bs-trigger="manual">
                        <a href="#" class="btn btn-primary fs-3 px-5 text-uppercase">
                            Jouer
                        </a>
                        <span class="fw-semibol font-paytone mt-2">
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
                                <span class="d-flex align-items-center">{{$connected}} joueurs en ligne</span>
                            @else
                                <span class="d-flex align-items-center">Serveur hors-ligne</span>
                            @endif
                        </span>
                    </button>
                </div>
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <img src="{{theme_config('home.discord.image.url') ? image_url(theme_config('home.discord.image.url')) : theme_asset('/images/discord-mascotte.png')}}" alt="Mascotte de discord" height="{{theme_config('home.discord.image.height') ?? '200' }}">
                    <a href="{{theme_config('settings.discord.link') ?? "https://discord.gg/ZdSPkxK5xT"}}" target="_blank" class="btn btn-tertiary fs-3 px-5 text-uppercase">Discord</a>
                </div>
            </div>
        </div>

        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif
        <div class="d-flex flex-column gap-15 my-15">
            @if(! $posts->isEmpty())
                <div>
                    <h2 class="text-uppercase custom-underline mx-auto  mb-5 mb-md-13">Actualités</h2>
                    <div class="container row">
                        @foreach($posts->take(3) as $post)
                            <div data-article-id="{{ $post->id }}"
                                 class="col-12 @if($loop->first) d-block @else d-none @endif my-7">
                                <div
                                    class="row align-items-center justify-content-center gx-5 gy-4 @if($loop->iteration % 2) flex-row @else flex-row-reverse @endif">
                                    <div class="col-md-4 rounded-3">
                                        @if($post->hasImage())
                                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                                 class="card-img-top object-fit-cover rounded-3" style="height: 160px">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <span class="opacity-50">{{format_date($post->published_at)}}</span>
                                        <h3>
                                            <a class="text-primary text-decoration-none"
                                               href="{{ route('posts.show', $post) }}">{{ $post->title }}
                                            </a>
                                        </h3>
                                        <p>{{ Str::limit(strip_tags($post->content), 250) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center">
                            <a id="show-article-button" class="btn btn-primary text-uppercase"
                               onclick="showNextArticle()">Afficher la prochaine actualité</a>
                        </div>
                        @endif
                    </div>
                </div>

            @if(theme_config('home.more'))
                <div class="mt-15 mb-md-13">
                    <h2 class="text-uppercase custom-underline mx-auto text-center mb-8 mb-md-15">En savoir
                        plus</h2>
                    <div class="row justify-content-center text-center ">
                        @foreach(theme_config('home.more') as $about)
                            <div class="col-md-3">
                                <i class="{{$about['icon']}} fs-2"></i>
                                <div>
                                    <h2 class="h3">{{$about['title']}}</h2>
                                    <p class="fw-lighter">{{$about['text']}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @endsection
        @push('footer-scripts')
            <script>
                function showNextArticle() {
                    let articles = document.querySelectorAll('[data-article-id]');
                    let articlesButton = document.getElementById('show-article-button')

                    for (let i = 0; i < articles.length; i++) {
                        if (articles[i].classList.contains('d-none')) {
                            articles[i].classList.remove('d-none');

                            if (i === articles.length - 1) {
                                articlesButton.innerText = 'Toutes les actualités';

                                setTimeout(() => {
                                    articlesButton.setAttribute('href', '{{ route('posts.index') }}');
                                    articlesButton.setAttribute('target', '_blank');
                                }, 200)
                            }
                            return;
                        }
                    }
                }
            </script>

            <script type="text/javascript">
                let copyButton = document.querySelectorAll(".copyButton");

                console.log(copyButton)
                copyButton.forEach(function (e) {
                    e.addEventListener("click", function () {
                        let textToCopy = '{!! theme_config('settings.server.ip') ?? 'play.westramc.fr' !!}';

                        // Création d'un élément temporaire pour la copie du texte
                        let tempInput = document.createElement("input");
                        tempInput.setAttribute("value", textToCopy);
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand("copy");
                        document.body.removeChild(tempInput);

                        let tooltip = new bootstrap.Tooltip(e);
                        tooltip.show();

                        // Masquer le tooltip après 3 secondes
                        setTimeout(function () {
                            tooltip.hide();
                        }, 2000);
                    })

                    e.addEventListener("mouseover", function () {
                        let tooltip = bootstrap.Tooltip.getInstance(e);
                        if (tooltip) {
                            tooltip.hide();
                        }
                    });
                });
            </script>
    @endpush
