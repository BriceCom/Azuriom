@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <!-- Preload du logo du loader pour un affichage instantané -->
    <link rel="preload" href="https://pixelrealm.fr/storage/img/loader-pr.webp" as="image">

    <!-- Loader -->
{{--    <div id="loader">--}}
{{--        <div class="loader-content">--}}
{{--            <img src="https://pixelrealm.fr/storage/img/loader-pr.webp" alt="{{ site_name() }}" class="loader-logo">--}}
{{--            <div class="lds-dual-ring"></div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div id="content" style="opacity: 1; visibility: visible;">
        <header class="header home-header min-vh-100 overflow-hidden">
            @include('elements.navbar')

         <div class="container position-relative z-2">
                <div class="row gy-4 pt-5">
                <!-- Colonne de gauche : Launcher et bouton -->
                <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                    <div class="text-center">
                        <!-- Image du launcher avec effet de flottement -->
                        <div class="launcher-container">
                            <img src="https://pixelrealm.fr/storage/img/launcher.png" class="launcher-floating" alt="Launcher">
                        </div>

                        <!-- Bouton noir opaque placé sous l'image -->
                        <button class="custom-button" onclick="openModal()">Rejoindre l'aventure</button>

                        <div id="downloadModal" class="modal-overlay">
                            <div class="modal-container">
                                <span class="close-btn" onclick="closeModal()">✖</span>
                                <h2>COMMENT NOUS REJOINDRE ?</h2>

                                <!-- Vidéo YouTube centrée -->
                                <div class="modal-video">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/hVhUKj0u5aw?si=Dbl4Qy1T0YzGKNLP"
                                        frameborder="0" allowfullscreen>
                                    </iframe>
                                </div>

                                <!-- Texte sous la vidéo -->
                                <p class="modal-text">
                                    Grâce à notre launcher, accède à deux modes de jeu : Cobblemon (1.21.1) et Pixelmon (1.16.5).
                                    Notre serveur réunit ces deux univers au sein d'une structure commune, partageant des valeurs et engagements qui nous sont propres.
                                </p>

                                <!-- Nouveau bloc pour choisir la plateforme -->
                                <h2 class="mt-4">Choisis ta plateforme</h2>
                                <p>Clique sur ce qui correspond à ta plateforme (Windows, Mac ou Linux) pour télécharger le launcher,
                                    il te suffira ensuite de l'installer comme montré dans la vidéo ci-dessus.</p>

                                <div class="download-buttons">
                                    <a href="https://pixelrealm.fr/storage/packages/PixelRealm.exe" target="_blank" class="btn btn-windows d-flex align-items-center">
                                        <i class="bi bi-windows me-2"></i> Windows
                                    </a>
                                    <a href="https://pixelrealm.fr/storage/packages/PixelRealm.exe" target="_blank" class="btn btn-mac d-flex align-items-center">
                                        <i class="bi bi-apple me-2"></i> Mac
                                    </a>
                                    <a href="https://pixelrealm.fr/storage/packages/PixelRealm.exe" target="_blank" class="btn btn-linux d-flex align-items-center">
                                        <i class="bi bi-ubuntu me-2"></i> Linux
                                    </a>
                                </div>
                                <p class="modal-text text-center mt-3">
                                    Des difficultés pour installer le launcher ? Ouvre un ticket sur le Discord en cliquant
                                    <b><a href="https://discord.gg/pixelrealm" target="_blank" style="color: #AF153A;">ici</a></b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex flex-column align-items-center">
                    {{-- Logo --}}
                    <div class="d-flex align-items-center">
                        <img id="logo" src="https://pixelrealm.fr/storage/img/logo-ombre.png" class="img-fluid d-block mx-auto" width="550" alt="{{ site_name() }}">
                    </div>

                    {{-- Statuts sous le logo --}}
                    @php
                        $totalPlayers = 0;
                        $allowedProxies = ['Pixelmon', 'Cobblemon'];
                        $offlineProxies = [];

                        foreach ($servers as $server) {
                            if (in_array($server->name, $allowedProxies)) {
                                if ($server->isOnline()) {
                                    $totalPlayers += $server->getOnlinePlayers();
                                } else {
                                    $offlineProxies[] = $server->name;
                                }
                            }
                        }
                    @endphp

                    <div class="status-box text-white rounded shadow-lg mt-3 p-3 text-center">
                        @if(count($offlineProxies) === 2)
                            {{-- Tous les proxys hors ligne --}}
                            <div class="d-inline-flex align-items-center">
                                <span class="status-dot red-dot me-2"></span>
                                <span>Serveurs hors-lignes</span>
                            </div>
                        @else
                            {{-- Au moins un proxy en ligne --}}
                            <div class="d-inline-flex align-items-center">
                                <span class="status-dot green-dot me-2"></span>
                                <span class="fw-bold">{{ $totalPlayers }} dresseurs en ligne</span>
                            </div>

                            @if(count($offlineProxies) === 1)
                                {{-- Un seul proxy hors ligne --}}
                                <div class="text-warning small mt-1">
                                    Serveur {{ $offlineProxies[0] }} en maintenance
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('elements.waves')
    </header>

    <main class="content home">
        <div class="container">
            <h2 class="text-uppercase text-center mb-4">
                <span class="home-title">{{ trans('messages.news') }}</span>
            </h2>

            <div class="col-md-10 px-3 mx-auto">
                <div id="news" class="carousel slide mb-5 mx-auto" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($posts as $id => $post)
                            <div class="carousel-item @if($id === 0) active @endif">
                                <div class="card">
                                    @if($post->hasImage())
                                        <img src="{{ $post->imageUrl() }}" class="card-img-top" alt="{{ $post->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h3>
                                            <a href="{{ route('posts.show', $post) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        <p>{{ format_date($post->published_at) }}</p>

                                        <a class="btn btn-primary" href="{{ route('posts.show', $post) }}">
                                            {{ trans('messages.posts.read') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev d-md-block d-none" type="button" data-bs-target="#news" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next d-md-block d-none" type="button" data-bs-target="#news" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="flex-shrink-0 py-3 mx-3 mb-3">
                            <div class="feature fs-1 text-primary mx-auto rounded">
                                <img src="https://pixelrealm.fr/storage/img/mordudor-crop.gif" alt="Mordudor" class="rounded">
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <h2 class="text-primary text-uppercase">
                                {{ theme_config('title_1') }}
                            </h2>
                            <p>{{ theme_config('description_1') }}</p>
                        </div>
                    </div>

                    <div class="d-flex flex-md-row flex-column-reverse">
                        <div class="flex-grow-1 me-3">
                            <h2  class="text-primary text-uppercase text-md-end">
                                {{ theme_config('title_2') }}
                            </h2>
                            <p>{{ theme_config('description_2') }}</p>
                        </div>

                        <div class="flex-shrink-0 py-3 mx-3 mb-3">
                            <div class="feature fs-1 text-primary mx-auto rounded">
                                <img src="https://pixelrealm.fr/storage/img/porygonz-50-crop.gif" alt="PorygonZ" class="rounded">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-md-row flex-column">
                        <div class="flex-shrink-0 py-3 mx-3 mb-3">
                            <div class="feature fs-1 text-primary mx-auto rounded">
                                <img src="https://pixelrealm.fr/storage/img/garchomp-x-cynthia-crop.gif" alt="Garchomp" class="rounded">
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <h2 class="text-primary text-uppercase">
                                {{ theme_config('title_3') }}
                            </h2>
                            <p>{{ theme_config('description_3') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <iframe src="https://discord.com/widget?id={{ theme_config('discord_id') }}&theme=dark" class="w-100 mb-3 rounded" height="500"></iframe>
                </div>
            </div>
        </div>

        <div id="particles-js"></div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .status-box {
            background-color: #1e1e1e;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
            background: rgba(0,20,43,0.5);
            text-align: center;
            border: 2px solid #002D61;

            backdrop-filter: blur(4px); /* Ajoute un flou de 10px sous l'overlay */
            -webkit-backdrop-filter: blur(4px); /* Pour compatibilité Safari */
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }

        /* Animation pulsante */
        @keyframes pulse-green {
            0% {
            transform: scale(1);
            box-shadow: 0 0 4px rgba(76, 175, 80, 0.8);
            }
            50% {
            transform: scale(1.2);
            box-shadow: 0 0 9px rgba(76, 175, 80, 1);
            }
            100% {
            transform: scale(1);
            box-shadow: 0 0 4px rgba(76, 175, 80, 0.8);
            }
        }

        @keyframes pulse-red {
            0% {
            transform: scale(1);
            box-shadow: 0 0 4px rgba(244, 67, 54, 0.8);
            }
            50% {
            transform: scale(1.2);
            box-shadow: 0 0 9px rgba(244, 67, 54, 1);
            }
            100% {
            transform: scale(1);
            box-shadow: 0 0 4px rgba(244, 67, 54, 0.8);
            }
        }

        .green-dot {
            background-color: #4CAF50;
            animation: pulse-green 1.2s infinite ease-in-out;
        }

        .red-dot {
            background-color: #F44336;
            animation: pulse-red 1.2s infinite ease-in-out;
        }

        /* Style du bouton */
        .custom-button {
            position: relative; /* Permet de gérer le placement du gif */
            top: 30px; /* Ajuste la position si nécessaire */
            left: 218px !important;
            background-color: #171717;
            color: white;
            padding: 12px 24px 12px 50px; /* Ajoute de l'espace à gauche pour le gif */
            font-size: 16px;
            border: 2px solid #212121;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.1s ease-in-out,
                box-shadow 0.2s ease-in-out,
                border-color 0.2s ease-in-out;
            display: flex;
            align-items: center;
        }

        /* Style du GIF de la Pokéball */
        .custom-button::before {
            content: "";
            background: url("https://pixelrealm.fr/storage/img/master.gif") no-repeat center;
            background-size: contain;
            width: 120px; /* Taille du gif */
            height: 120px; /* Taille du gif */
            position: absolute;
            left: -50px; /* Décale vers la gauche pour dépasser du bouton */
            top: 50%;
            transform: translateY(-50%); /* Centre verticalement */
        }

        /* Effet de survol */
        .custom-button:hover {
            border-color: #ddafc9; /* Apparition du liseré */
            box-shadow: 0 0 15px 3px #412334;
        }

        /* Effet de clic */
        .custom-button:active {
            background-color: #212121; /* Transition progressive */
        }

        #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #1c2833;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }

        .loader-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .loader-logo {
            width: 800px; /* Ajuste la taille du logo */
            margin-bottom: 20px;
            opacity: 1 !important; /* Force l'affichage immédiat */
        }

        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 8px;
            border-radius: 50%;
            border: 6px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
            transform: rotate(0deg);
            }
            100% {
            transform: rotate(360deg);
            }
        }

        #content {
            transition: opacity 1s ease, visibility 1s ease;
        }

        /* Conteneur pour centrer l'image */
        .launcher-container {
            display: flex;
            justify-content: center;
            align-items: center;
            animation: floatAnimation 3s ease-in-out infinite;
        }

        .launcher-floating {
            max-width: 100%;
            height: auto;
            pointer-events: auto;
            position: relative;
            z-index: 10;
            transition: transform 0.4s ease-in-out;
        }

        .launcher-floating:hover {
            transform: scale(1.08) rotateX(9deg);
        }

        /* Animation de flottement */
        @keyframes floatAnimation {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        /* Effet de flou et d'assombrissement */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Assombrit le fond */
            backdrop-filter: blur(8px); /* Applique le flou */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Assure que c'est au premier plan */
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        /* Affichage de la modale */
        .modal-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        /* Container de la modale */
        .modal-container {
            background: rgba(32, 47, 61, 0.7);
            border: 2px solid #263746;
            border-radius: 8px;
            padding: 20px;
            width: 50%;
            max-width: 700px;
            text-align: center;
            position: relative;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        /* Bouton de fermeture */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        /* Rotation sur elle-même au survol */
        .close-btn:hover {
            transform: rotate(180deg);
        }

        /* Centrage de la vidéo */
        .modal-video {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        /* Espacement entre la vidéo et le texte */
        .modal-text {
            margin-top: 15px;
            color: white;
        }

        /* Style de la modale */
        .download-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5); /* Effet de fond assombri */
            backdrop-filter: blur(5px); /* Floutage du fond */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100; /* Mettre la modale au-dessus de tout */
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        /* Quand la modale est active */
        .download-modal.active {
            opacity: 1;
            visibility: visible;
        }

        /* Animation de disparition en douceur */
        .download-modal.closing {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        /* Désactive les éléments qui ne doivent pas apparaître au premier plan */
        body.modal-active .navbar,
        body.modal-active .header-separator .svg-2,
        body.modal-active .header-separator .boat {
            z-index: 0 !important; /* S'assurer qu'ils passent derrière la modale */
        }

        .download-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .modal-text {
            text-align: center;
        }

        /* Bouton Windows */
        .btn-windows {
            background-color: #0078D7; /* Bleu Windows */
            color: white;
        }

        .btn-windows:hover {
            background-color: #005A9E;
        }

        /* Bouton Mac */
        .btn-mac {
            background-color: #A2AAAD; /* Gris Mac */
            color: white;
        }

        .btn-mac:hover {
            background-color: #7D8589;
        }

        /* Bouton Linux */
        .btn-linux {
            background-color: #E95420; /* Orange Ubuntu */
            color: white;
        }

        .btn-linux:hover {
            background-color: #C34113;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            VanillaTilt.init(document.querySelector("#logo"), {
                max: 15,
                speed: 400,
                glare: true,
                "max-glare": 0.3
            });

            const modal = document.getElementById("downloadModal");
            const body = document.body;
            const video = document.getElementById("youtubeVideo");

            // Ouvrir la modale
            window.openModal = function () {
                modal.classList.add("active");
                body.classList.add("modal-active"); // Désactive l'interaction avec les autres éléments
            };

            // Fermer la modale avec transition fluide et arrêt de la vidéo
            window.closeModal = function () {
                modal.classList.add("closing"); // Déclenche l'animation de fermeture
                setTimeout(() => {
                    modal.classList.remove("active", "closing");
                    body.classList.remove("modal-active"); // Réactive la page

                    // Réinitialiser la vidéo pour l'arrêter
                    video.src = video.src;
                }, 300); // Attendre la fin de l'animation (0.3s)
            };

            // Fermer en cliquant en dehors
            modal.addEventListener("click", function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>

    <script>
        window.addEventListener("load", function () {
            setTimeout(function () {
                document.getElementById("loader").style.display = "none";
                var content = document.getElementById("content");
                content.style.visibility = "visible";
                content.style.opacity = "1";
            }, 1000);
        });
    </script>
@endpush
