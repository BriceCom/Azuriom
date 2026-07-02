<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = json_decode(file_get_contents(theme_path().'/theme.json'), true);

    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom, Dixept">
    <meta name="publisher" content="{{site_name()}}, Dixept">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:image:alt" content="Favicon {{site_name()}}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="Serveur Minecraft {{ site_name() }}">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">

    <!-- Scripts -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link rel="preload" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}"
          as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}">
    </noscript>
    <link href="{{ theme_asset('css/styles.css').'?ver='.$version_theme['version'] }}" rel="stylesheet">
    @stack('styles')
</head>

<body id="{{$plugname}}" class="position-relative">

<div id="app" class="position-relative overflow-hidden">
    <header class="position-relative">
        @include('elements.navbar')

        <div class="background">
            <div class="background-wrapper overflow-hidden">
                <img class="object-fit-cover" tabindex="-1" src="{{ setting('background') ? image_url(setting('background')) : 'https://cdn.rinaorc.com/banner_blur.png' }}" alt="Illustration du jeu Minecraft">
                <div class="background-content">
                    <div class="container mx-auto row align-items-center py-4">
                        <div class="col-md-4 d-flex justify-content-center">
                            <button
                                class="copyButton d-flex flex-column align-items-center bg-transparent cursor-pointer border-0 mb-0"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual"
                            >
                                <i class="text-primary mb-4">
                                    <svg role="presentation" viewBox="0 0 24 24" height="50" width="50">
                                        <path d="M4,2H20A2,2 0 0,1 22,4V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V4A2,2 0 0,1 4,2M6,6V10H10V12H8V18H10V16H14V18H16V12H14V10H18V6H14V10H10V6H6Z" style="fill: currentcolor;">
                                        </path>
                                    </svg>
                                </i>
                                <span class="position-relative d-block text-uppercase h4 fw-bold text-primary mb-0">
                                    {{theme_config('home.ip.text') ?? 'play.pandonia.fr'}}
                                    <span class="position-absolute px-3_5 py-1 text-xs rounded-pill bg-white text-primary text-uppercase fw-bold fst-normal" style="top: -24px; right: 0;">Clic!</span>
                                </span>
                                <span class="fw-semibold text-uppercase text-white">
                                    @if($servers)
                                        @php($connected = 0)
                                        @foreach($servers as $server)
                                            @if($server->isOnline())
                                                @php($connected += $server->getOnlinePlayers())
                                            @endif
                                        @endforeach
                                        <span class="h5">{{$connected}}</span> joueurs connectés
                                    @else
                                        Serveur hors-ligne
                                    @endif
                                </span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <img class="logo" src="{{site_logo()}}" alt="Logo de {{site_name()}}">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <div>
                                <a class="d-flex flex-column align-items-center text-decoration-none" href="{{theme_config('home.discord.url') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" target="_blank">
                                    <i class="text-primary mb-4">
                                        <svg fill="#9CD3FF" height="50" width="50" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg"><path d="M20.222 0c1.406 0 2.54 1.137 2.607 2.475V24l-2.677-2.273-1.47-1.338-1.604-1.398.67 2.205H3.71c-1.402 0-2.54-1.065-2.54-2.476V2.48C1.17 1.142 2.31.003 3.715.003h16.5L20.222 0zm-6.118 5.683h-.03l-.202.2c2.073.6 3.076 1.537 3.076 1.537-1.336-.668-2.54-1.002-3.744-1.137-.87-.135-1.74-.064-2.475 0h-.2c-.47 0-1.47.2-2.81.735-.467.203-.735.336-.735.336s1.002-1.002 3.21-1.537l-.135-.135s-1.672-.064-3.477 1.27c0 0-1.805 3.144-1.805 7.02 0 0 1 1.74 3.743 1.806 0 0 .4-.533.805-1.002-1.54-.468-2.14-1.404-2.14-1.404s.134.066.335.2h.06c.03 0 .044.015.06.03v.006c.016.016.03.03.06.03.33.136.66.27.93.4.466.202 1.065.403 1.8.536.93.135 1.996.2 3.21 0 .6-.135 1.2-.267 1.8-.535.39-.2.87-.4 1.397-.737 0 0-.6.936-2.205 1.404.33.466.795 1 .795 1 2.744-.06 3.81-1.8 3.87-1.726 0-3.87-1.815-7.02-1.815-7.02-1.635-1.214-3.165-1.26-3.435-1.26l.056-.02zm.168 4.413c.703 0 1.27.6 1.27 1.335 0 .74-.57 1.34-1.27 1.34-.7 0-1.27-.6-1.27-1.334.002-.74.573-1.338 1.27-1.338zm-4.543 0c.7 0 1.266.6 1.266 1.335 0 .74-.57 1.34-1.27 1.34-.7 0-1.27-.6-1.27-1.334 0-.74.57-1.338 1.27-1.338z"/></svg>
                                    </i>
                                    <span class="position-relative d-block text-uppercase h4 fw-bold mb-0" style="color: #9CD3FF">
                                        Notre discord
                                    </span>
                                    <span class="discord-list_count fw-semibold text-white">
                                        <span class="h4">{online}</span> <span class="text-uppercase">membres connectés</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('app')

    @include('elements.footer')
    @includeIf('components.general.discordAPI')
</div>

@stack('footer-scripts')

<script type="text/javascript">
    let copyButton = document.querySelectorAll(".copyButton");

    console.log(copyButton)
    copyButton.forEach(function(e) {
        e.addEventListener("click", function() {
            let textToCopy = '{!! theme_config('home.ip.text') ?? 'play.pandonia.fr' !!}';

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
            setTimeout(function() {
                tooltip.hide();
            }, 2000);
        })

        e.addEventListener("mouseover", function() {
            let tooltip = bootstrap.Tooltip.getInstance(e);
            if (tooltip) {
                tooltip.hide();
            }
        });
    });
</script>


</body>
</html>
