@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="home-background d-flex align-items-center justify-content-center flex-column text-white"
         style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 0%, #121212 100%),
                    linear-gradient(0deg, rgba(18, 18, 18, 0.35) 0%, rgba(18, 18, 18, 0.35) 100%),
                    url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;
                    height: 800px;
         ">
        <div class="d-flex flex-column justify-content-center align-items-center gap-5">
            <h1>
                <img class="hero-logo" src="{{theme_config('home.image') ? image_url(theme_config('home.image')):site_logo()}}" alt="Rejoindre le serveur {{site_name()}}" height="{{theme_config('home.imageHeightMax') ?? 200}}">
            </h1>
            @if($server)
                <div class="text-center">

                    <button id="copyButton" class="ip_address btn btn-secondary">
                        <span class="fw-bold text-uppercase text-white btn btn-primary fs-2 px-4">{{ $server->fullAddress() }}</span>

                        <span class="fw-bold text-uppercase text-white btn btn-secondary fs-2 px-2 ps-1">
                            @if($server->isOnline())
                                {{$server->getOnlinePlayers()}}
                            @else
                                OFF
                            @endif
                        </span>
                    </button>
                    <p id="copyButton-text" class="fw-light ip_address_clic mt-3">Cliquez sur le bouton pour copier l’IP</p>
                </div>
                @push('footer-scripts')
                    <script type="text/javascript">
                        const copyButton = document.getElementById("copyButton");
                        const copyButtonText = document.getElementById("copyButton-text");

                        copyButton.addEventListener("click", function() {
                            const textToCopy = '{!! theme_config('home.hero.server-button.ip') ? theme_config('home.hero.server-button.ip'):'play.origincube.fr'!!}';

                            let tempInput = document.createElement("input");
                            tempInput.setAttribute("value", textToCopy);
                            document.body.appendChild(tempInput);
                            tempInput.select();
                            document.execCommand("copy");
                            document.body.removeChild(tempInput);

                            let tempText = copyButtonText.textContent;
                            copyButtonText.textContent = 'IP COPIÉ!';

                            setTimeout(function() {
                                copyButtonText.textContent = tempText;
                            }, 2000);
                        });
                    </script>
                @endpush
            @endif
        </div>
    </div>

    <div class="container content">
        @include('elements.session-alerts')

        <section>
            <h2 class="text-center fw-bold">NOS DERNIERS ARTICLES</h2>
            <p class="text-center fw-normal text-light">Découvrez toute l’actualité et les nouveautés du serveur</p>
            <div class="row justify-content-center gx-md-5 gy-4 mt-8">
                @foreach($posts->take(3) as $post)
                    <div class="col-md-6 col-lg-4 d-flex flex-column">
                        <div class="post-img">
                            @if($post->hasImage())
                                <img class="rounded-4 w-100 h-100 object-fit-cover" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
                            @endif
                        </div>
                        <div class="ps-md-4 py-md-3 pe-md-3 flex-grow-1">
                            <h3 class="fs-2">{{ $post->title }}</h3>
                            <div class="post-content">
                                <p class="fw-light mb-0">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-2 px-xl-4 py-2 mt-md-4 mt-3 border border-1 border-primary rounded-4 bg-dark">
                            <span class="fs-5">{{ format_date($post->published_at)}}</span>
                            <a class="fw-bold text-uppercase fs-5" href="{{ route('posts.show', $post) }}" target="_blank" rel="noopener">En savoir plus</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="/news" class="btn btn-primary px-3 mt-md-6 mt-4 fs-2">LIRE TOUS NOS ARTICLES</a>
            </div>
        </section>
        <section class="mt-9 mt-md-15 mb-5">
            <div class="row justify-content-center gy-4">
                    <div class="col-12 col-xl-9 pe-xl-6 d-flex flex-column">
                        <div class="bg-blue p-7 py-5 rounded-3 text-center">
                            <h2 class="text-uppercase fw-bold">{{theme_config('home.discord.title')}}</h2>
                            <p class="fw-light my-4 fs-6">
                                {!! theme_config('home.discord.paragraph') !!}
                            </p>
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-5 pt-3 community-links">
                                <a class="discord-btn text-uppercase btn border border-1 border-white text-white fw-semibold" @if(theme_config('home.discordLink.blank')) target="_blank" @endif rel="noopener"  href="{{theme_config('home.discordLink.url') ??'https://discord.gg/Gh2yBxUWvV'}}"><i class="bi bi-discord me-2"></i> Rejoindre le discord</a>
                                <a class="youtube-btn text-uppercase btn bg-danger border border-1 border-danger text-white fw-semibold" @if(theme_config('home.youtubeLink.blank')) target="_blank" @endif rel="noopener"href="{{theme_config('home.youtubeLink.url') ??'https://discord.gg/Gh2yBxUWvV'}}"><i class="bi bi-youtube me-2"></i> S'abonner sur youtube</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-3 ps-xl-4  d-flex flex-column">
                        <div class="d-flex flex-column bg-dark rounded-3 p-3 flex-grow-1">
                            <h2 class="fw-bold text-center">Notre serveur discord</h2>
                            <div class="flex-grow-1 h-100">
                                @includeIf('components.general.discord')
                            </div>
                            @includeIf('components.general.discordAPI')
                        </div>
                    </div>
            </div>
        </section>
    </div>
@endsection
