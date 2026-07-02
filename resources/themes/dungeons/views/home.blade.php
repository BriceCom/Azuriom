@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
<main>
    <div class="container-fluid d-flex justify-content-between position-relative hero d-flex align-items-center overflow-hidden">
        <img loading="lazy" aria-hidden="true" class="dungeons_icon" src="{{theme_asset('image/tripe_icon_dungeons.svg')}}" alt="Triple icone du serveur {{site_name()}}" draggable="false">
            <div class="flex-grow-1 flex-lg-grow-0 row hero-content align-items-end px-lg-5">
                <div class="d-none d-lg-flex justify-content-center col-12 col-lg-5 hero-personnage order-{{theme_config('home.hero.order') != 1 ? theme_config('home.hero.order'):'1'}}">
                    <img loading="lazy" src="{{theme_config('home.hero.image') ? image_url(theme_config('home.hero.image')):theme_asset('image/steve_forgeron.png')}}" alt="Personnage du jeu minecraft" draggable="false">
                </div>
                <div class="flex-lg-grow-1 col-12 col-lg-7 align-self-center text-center text-lg-start px-4 px-md-5 px-lg-3 py-2">
                    <h1 class="fw-bold display-1">{{theme_config('home.hero.title') ? theme_config('home.hero.title') :'Dainesia sollicite ses héros pour défendre son royaume !'}}</h1>
                    <p>{!! theme_config('home.hero.paragraph') ? theme_config('home.hero.paragraph'):'Devenez un héros légendaire en explorant des donjons dangereux, en combattant des créatures maléfiques et en protégeant le royaume !'!!}</p>
                    <div class="hero-button d-flex justify-content-lg-start justify-content-center flex-column flex-sm-row">
                        <a href="{{theme_config('home.hero.play-button.url') ? theme_config('home.hero.play-button.url'):'https://wiki.dungeons.fr/gameplay/debuter-laventure'}}" target="_blank" rel="noopener" class="flex-xl-grow-0 flex-grow-1 btn btn-primary p-3 py-md-3 px-md-5 me-xxl-5 me-md-4 me-sm-2 text-nowrap fw-light">{{theme_config('home.hero.play-button.text') ? theme_config('home.hero.play-button.text'):'Jouer sur Dungeons'}}</a>
                        <button id="copyButton" class="flex-xl-grow-0 flex-grow-1 btn btn-secondary p-3 py-md-3 px-md-5 mt-sm-0 mt-2 text-nowrap"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="IP COPIÉ" aria-label="Ip copié" data-bs-trigger="manual">
                            <i class="me-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 13H15.8C16.9201 13 17.48 13 17.9078 12.782C18.2841 12.5902 18.5905 12.2844 18.7822 11.908C19.0002 11.4802 19.0002 10.9202 19.0002 9.80005V4.20002C19.0002 3.07992 19.0002 2.51986 18.7822 2.09204C18.5905 1.71572 18.2841 1.40973 17.9078 1.21799C17.48 1 16.9203 1 15.8002 1H10.2002C9.08009 1 8.51962 1 8.0918 1.21799C7.71547 1.40973 7.40973 1.71572 7.21799 2.09204C7 2.51986 7 3.07997 7 4.20007V7.00007M1 15.8001V10.2001C1 9.07997 1 8.51986 1.21799 8.09204C1.40973 7.71572 1.71547 7.40973 2.0918 7.21799C2.51962 7 3.08009 7 4.2002 7H9.8002C10.9203 7 11.48 7 11.9078 7.21799C12.2841 7.40973 12.5905 7.71572 12.7822 8.09204C13.0002 8.51986 13.0002 9.07992 13.0002 10.2V15.8C13.0002 16.9202 13.0002 17.4802 12.7822 17.908C12.5905 18.2844 12.2841 18.5902 11.9078 18.782C11.48 19 10.9203 19 9.8002 19H4.2002C3.08009 19 2.51962 19 2.0918 18.782C1.71547 18.5902 1.40973 18.2844 1.21799 17.908C1 17.4802 1 16.9202 1 15.8001Z" stroke="#9A9EBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </i>
                            {{theme_config('home.hero.server-button.text') ? theme_config('home.hero.server-button.text'):'PLAY.DUNGEONS.FR'}}
                        </button>
                    </div>
                </div>
            </div>
        <img loading="lazy" aria-hidden="true" class="dungeons_icon" src="{{theme_asset('image/tripe_icon_dungeons.svg')}}" alt="Triple icone du serveur {{site_name()}}" draggable="false">
    </div>

    @push('footer-scripts')
        <script type="text/javascript">
            var copyButton = document.getElementById("copyButton");

            copyButton.addEventListener("click", function() {
                var textToCopy = '{!! theme_config('home.hero.server-button.ip') ? theme_config('home.hero.server-button.ip'):'play.dungeons.fr'!!}';

                // Création d'un élément temporaire pour la copie du texte
                var tempInput = document.createElement("input");
                tempInput.setAttribute("value", textToCopy);
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);

                var tooltip = new bootstrap.Tooltip(copyButton);
                tooltip.show();

                // Masquer le tooltip après 3 secondes
                setTimeout(function() {
                    tooltip.hide();
                }, 2000);
            });

            // Désactiver l'affichage de la tooltip au survol du bouton
            copyButton.addEventListener("mouseover", function() {
                var tooltip = bootstrap.Tooltip.getInstance(copyButton);
                if (tooltip) {
                    tooltip.hide();
                }
            });
        </script>
    @endpush

    <div class="container content my-5 py-5">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        @if(! $posts->isEmpty())
            <h2 class="text-center">{{theme_config('home.article.title') ? theme_config('home.article.title'):'Nos articles'}}</h2>
            <p class="text-center">{{theme_config('home.article.paragraph') ? theme_config('home.article.paragraph'):'Découvrez l’actualité de Dungeons'}}</p>

        <div class="mt-5 mb-5 pb-5">
            <div class="row gy-4 justify-content-center">
                @foreach($posts->take(3) as $post)
                    <div class="col-md-4 post-wrapper flex-grow-1 d-flex">
                        <article class="post-preview card flex-grow-1">
                            <div class="post-image-wrapper">
                                <div class="post-stats d-flex justify-content-center align-items-center flex-column gap-2 position-absolute">
                                    <span class="d-flex align-items-center bg-secondary py-1 px-2 rounded rounded-5"><i class="d-flex bi bi-heart-fill text-primary me-2"></i> {{$post->likes->count()}}</span>
                                    <span class="d-flex align-items-center bg-secondary py-1 px-2 rounded rounded-5"><i class="d-flex bi bi-chat-fill text-primary me-2"></i> {{$post->comments->count()}}</span>
                                </div>
                                @if($post->hasImage())
                                    <img loading="lazy" src="{{ $post->imageUrl() }}" alt="Illustration de l'article {{$post->title}}" height="210">
                                @endif
                            </div>
                            <div class="card-body pb-0">
                                <h3 class="card-title">
                                    <a href="{{ route('posts.show', $post) }}" class="post-title text-white fw-bold" rel="noopener">{{ $post->title }}</a>
                                </h3></div>
                            <a href="{{ route('posts.show', $post) }}" rel="noopener" class="post-read card-footer text-muted d-flex justify-content-between align-items-center">
                                <span class="h5">Lire l’article</span>
                                <i>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 11L11 1M11 1L3 1M11 1V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </i>
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="text-center my-5">
                <a href="{{route('posts.index')}}" rel="noopener" class="posts-see-articles btn btn-secondary py-3 px-4">Voir tous les articles</a>
            </div>
        </div>
        @endif
        <div class="my-5 py-5">
            <h2 class="text-center">{{theme_config('home.trailer.title') ? theme_config('home.article.title'):'Trailers'}}</h2>
            <p class="text-center">{{theme_config('home.article.paragraph') ? theme_config('home.article.paragraph'):'Découvrez nos trailers pour annoncer Dungeons'}}</p>

            <div class="row gy-4 mt-5 justify-content-between">
                <div class="col-md-6 trailer-wrapper text-end">
                    <iframe
                        loading="lazy"
                        src="{{theme_config('home.trailer.trailer-one.url') ? theme_config('home.trailer.trailer-one.url'):'https://www.youtube.com/embed/m_yqOoUMHPg'}}"
                        srcdoc="
                        <style>
                              * {
                              padding: 0;
                              margin: 0;
                              overflow: hidden;
                              }

                              body, html {
                                height: 100%;
                              }

                              img, .load-button {
                                position: absolute;
                                width: 100%;
                                top: 0;
                                bottom: 0;
                                margin: auto;
                              }
                              .trailer-link:focus-visible .load-button{
                                border: white 2px solid;
                              }

                              .lazy-loading-img{
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                object-position: center;
                                background: linear-gradient(180deg, rgba(34, 35, 40, 0.8) 0%, rgba(34, 35, 40, 0) 13.12%), url('{{theme_config('home.trailer.trailer-one.image') ? image_url(theme_config('home.trailer.trailer-one.image')):theme_asset('image/trailer-image.png')}}');
                                background-size: cover;
                                background-position: center;
                              }


                              .load-button-wrapper{
                                justify-content: center;
                                display: flex;
                              }
                              .load-button {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                width: 58px;
                                height: 58px;
                                background: rgba(34, 35, 40, 0.8);
                                border-radius: 50%;
                                transition: all 200ms ease-in-out;
                              }

                              body:hover .load-button {
                                transform: scale(1.1);
                              }
                        </style>
                        <a title='Voir la présentation du serveur {{site_name()}}'class='trailer-link' tabindex='1' href='{{theme_config('home.trailer.trailer-one.url') ? theme_config('home.trailer.trailer-one.url'):'https://www.youtube.com/embed/m_yqOoUMHPg'}}' rel='noopener'>
                          <div class='lazy-loading-img'></div>
                          <div class='load-button-wrapper'>
                              <div class='load-button'>
                                <svg width='22' height='24' viewBox='0 0 22 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M0 20.7309V3.26893C0 1.82902 0 1.10907 0.293488 0.683042C0.54964 0.311209 0.94446 0.0666734 1.38278 0.00830626C1.88452 -0.0585056 2.49852 0.27958 3.7268 0.95591L3.73026 0.957817L19.5866 9.68881C20.9494 10.4392 21.6308 10.8145 21.8541 11.3141C22.0486 11.7493 22.0486 12.2506 21.8541 12.6858C21.6308 13.1854 20.9494 13.5607 19.5866 14.3111L3.73026 23.0421L3.72588 23.0445C2.49821 23.7205 1.8844 24.0585 1.38278 23.9917C0.94446 23.9333 0.54964 23.6888 0.293488 23.3169C0 22.8909 0 22.1708 0 20.7309Z' fill='white' fill-opacity='0.8'/>
                                </svg>
                              </div>
                          </div>
                        </a>
                        "
                        title="Présentation du serveur {{site_name()}}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="col-md-6 trailer-wrapper text-start">
                    <iframe
                        loading="lazy"
                        src="{{theme_config('home.trailer.trailer-two.url') ? theme_config('home.trailer.trailer-two.url'):'https://www.youtube.com/embed/m_yqOoUMHPg'}}"
                        srcdoc="
                        <style>
                              * {
                              padding: 0;
                              margin: 0;
                              overflow: hidden;
                              }

                              body, html {
                                height: 100%;
                              }

                              img, .load-button {
                                position: absolute;
                                width: 100%;
                                top: 0;
                                bottom: 0;
                                margin: auto;
                              }
                              .trailer-link:focus-visible .load-button{
                                border: white 2px solid;
                              }

                              .lazy-loading-img{
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                object-position: center;
                                background: linear-gradient(180deg, rgba(34, 35, 40, 0.8) 0%, rgba(34, 35, 40, 0) 13.12%), url('{{theme_config('home.trailer.trailer-two.image') ? image_url(theme_config('home.trailer.trailer-two.image')):theme_asset('image/trailer-image.png')}}');
                                background-size: cover;
                                background-position: center;
                              }


                              .load-button-wrapper{
                                justify-content: center;
                                display: flex;
                              }
                              .load-button {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                width: 58px;
                                height: 58px;
                                background: rgba(34, 35, 40, 0.8);
                                border-radius: 50%;
                                transition: all 200ms ease-in-out;
                              }

                              body:hover .load-button {
                                transform: scale(1.1);
                              }
                        </style>
                        <a title='Voir le trailer du serveur {{site_name()}}' class='trailer-link' tabindex='1' href='{{theme_config('home.trailer.trailer-two.url') ? theme_config('home.trailer.trailer-two.url'):'https://www.youtube.com/embed/m_yqOoUMHPg'}}' rel='noopener'>
                          <div class='lazy-loading-img'></div>
                          <div class='load-button-wrapper'>
                              <div class='load-button'>
                                <svg width='22' height='24' viewBox='0 0 22 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M0 20.7309V3.26893C0 1.82902 0 1.10907 0.293488 0.683042C0.54964 0.311209 0.94446 0.0666734 1.38278 0.00830626C1.88452 -0.0585056 2.49852 0.27958 3.7268 0.95591L3.73026 0.957817L19.5866 9.68881C20.9494 10.4392 21.6308 10.8145 21.8541 11.3141C22.0486 11.7493 22.0486 12.2506 21.8541 12.6858C21.6308 13.1854 20.9494 13.5607 19.5866 14.3111L3.73026 23.0421L3.72588 23.0445C2.49821 23.7205 1.8844 24.0585 1.38278 23.9917C0.94446 23.9333 0.54964 23.6888 0.293488 23.3169C0 22.8909 0 22.1708 0 20.7309Z' fill='white' fill-opacity='0.8'/>
                                </svg>
                              </div>
                          </div>
                        </a>
                        "
                        title="Trailer du serveur {{site_name()}}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
        <div class="mt-5 pt-5">
            <h2 class="text-center">{{theme_config('home.assurance.title') ? theme_config('home.assurance.title'):'Une expérience unique'}}</h2>
            <p class="text-center">{{theme_config('home.assurance.paragraph') ? theme_config('home.assurance.paragraph'):'Les 3 principaux services que nous mettons à votre disposition'}}</p>
            <div class="row gy-4">
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card p-3 pb-5">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            @if(theme_config('home.assurance.card-one.icon') != null)
                                <i class="display-2 d-flex {{theme_config('home.assurance.card-one.icon')}}" style="color: #B56BFF;"></i>
                            @else
                                <svg width="80" height="72" viewBox="0 0 80 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M68 32C68 16.536 55.464 4 40 4C24.536 4 12 16.536 12 32M56 46V54C56 55.8586 56 56.7879 56.1537 57.5607C56.785 60.7342 59.264 63.2149 62.4375 63.8462C63.2103 63.9999 64.1414 63.9999 66 63.9999C67.8586 63.9999 68.7879 63.9999 69.5607 63.8462C72.7342 63.2149 75.2164 60.7342 75.8477 57.5607C76.0014 56.7879 76 55.8586 76 54V46C76 44.1414 76.0014 43.2122 75.8477 42.4395C75.2164 39.2659 72.7342 36.785 69.5607 36.1537C68.7879 36 67.8586 36 66 36C64.1414 36 63.2103 36 62.4375 36.1537C59.264 36.785 56.785 39.2659 56.1537 42.4395C56 43.2122 56 44.1414 56 46ZM24 46V54C24 55.8586 24.0014 56.7879 23.8477 57.5607C23.2164 60.7342 20.7342 63.2149 17.5607 63.8462C16.7879 63.9999 15.8568 63.9999 13.9982 63.9999C12.1396 63.9999 11.2103 63.9999 10.4375 63.8462C7.26398 63.2149 4.78497 60.7342 4.15372 57.5607C4 56.7879 4 55.8586 4 54V46C4 44.1414 4 43.2122 4.15372 42.4395C4.78497 39.2659 7.26398 36.785 10.4375 36.1537C11.2103 36 12.1396 36 13.9982 36C15.8568 36 16.7879 36 17.5607 36.1537C20.7342 36.785 23.2164 39.2659 23.8477 42.4395C24.0014 43.2122 24 44.1414 24 46Z" stroke="#B56BFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            @endif

                                <h3 class="assurance-title flex-grow-1 text-center my-3">{{theme_config('home.assurance.card-one.title') ?theme_config('home.assurance.card-one.title'):'Un support à l\'écoute'}}</h3>
                                <hr class="assurance-separator w-25 m-0 mb-4"/>

                                <p class="assurance-text m-0 text-start flex-grow-1">{{theme_config('home.assurance.card-one.paragraph') ?theme_config('home.assurance.card-one.paragraph'):'Notre équipe met un point d’honneur sur l’écoute des retours transmis par nos joueurs pour améliorer votre expérience de jeu parmis nous.'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card p-3 pb-5">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            @if(theme_config('home.assurance.card-two.icon') != null)
                                <i class="display-2 {{theme_config('home.assurance.card-one.icon')}}" style="color: #B56BFF;"></i>
                            @else
                                <svg width="80" height="72" viewBox="0 0 80 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 12L76 12M48 32L56 40L48 48M32 48L24 40L32 32M4 55.2001V16.8C4 12.3196 4 10.0795 4.87195 8.36816C5.63893 6.86287 6.86189 5.63894 8.36719 4.87195C10.0785 4 12.3204 4 16.8008 4H63.2008C67.6812 4 69.9198 4 71.6311 4.87195C73.1364 5.63893 74.3619 6.86287 75.1289 8.36816C76.0009 10.0795 76 12.3196 76 16.8V55.2001C76 59.6804 76.0008 61.9206 75.1289 63.6319C74.3619 65.1372 73.1364 66.3612 71.6311 67.1282C69.9198 68.0001 67.6812 68 63.2008 68L16.8008 68C12.3204 68 10.0785 68.0001 8.36719 67.1282C6.86189 66.3612 5.63894 65.1372 4.87195 63.6319C4 61.9206 4 59.6805 4 55.2001Z" stroke="#B56BFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            @endif
                                <h3 class="assurance-title flex-grow-1 my-3 text-center">{{theme_config('home.assurance.card-two.title') ?theme_config('home.assurance.card-two.title'):'Des ajouts inédits'}}</h3>
                                <hr class="assurance-separator w-25 m-0 mb-4"/>
                                <p class="assurance-text m-0 text-start flex-grow-1">{{theme_config('home.assurance.card-two.paragraph') ?theme_config('home.assurance.card-two.paragraph'):'Découvrez de nouvelles fonctionnalités encore inconnue du publique ! Vous faire découvrir un nouveau gameplay est devenue l’une de nos ambitions.'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card p-3 pb-5">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            @if(theme_config('home.assurance.card-three.icon') != null)
                                <i class="display-2 {{theme_config('home.assurance.card-one.icon')}}" style="color: #B56BFF;"></i>
                            @else
                                <svg width="80" height="72" viewBox="0 0 72 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 76V12M68 54.7466V9.25295C44.7273 27.4504 27.2727 -8.94429 4 9.25318V54.7466C27.2727 36.5492 44.7273 72.9441 68 54.7466Z" stroke="#B56BFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            @endif
                                <h3 class="assurance-title flex-grow-1 my-3 text-center">{{theme_config('home.assurance.card-three.title') ?theme_config('home.assurance.card-three.title'):'Des événements régulier'}}</h3>
                                <hr class="assurance-separator w-25 m-0 mb-4"/>
                                <p class="assurance-text m-0 text-start flex-grow-1">{{theme_config('home.assurance.card-three.paragraph') ?theme_config('home.assurance.card-three.paragraph'):'De nombreux événements fonts régulièrement leur apparitions sur notre serveur ainsi que sur notre discord, vous pourrez y participer à tout moment.'}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "AboutPage",
          "about": {
            "@type": "Thing",
            "url": "{{url()->current()}}",
            "image": "{{site_logo()}}",
            "additionalType": "",
            "name": "{{site_name()}}",
            "description": "{!! setting('description', '') !!}"
          },
          "image": "{{site_logo()}}",
          "keywords": "{{site_name()}}, serveur minecraft {{site_name()}}, serveur {{site_name()}}, jouer sur {{site_name()}}"
        }
</script>
@endpush
