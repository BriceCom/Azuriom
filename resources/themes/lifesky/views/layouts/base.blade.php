<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = json_decode(file_get_contents(theme_path().'/theme.json'), true);
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- SEO MIN -->
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

    <title>@yield('title') | {{ site_name() }}</title>

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
    <link rel="preload" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}"></noscript>
    <link href="{{ theme_asset('css/styles.css').'?ver='.$version_theme['version'] }}" rel="stylesheet">
    @stack('styles')
    <style>
        .card-header::after{
            background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') top / cover no-repeat;
        }
        .card-header::before{
            background-image: linear-gradient(7deg, #ffffff 25%, #ffffffcc);
        }
    </style>
</head>

<body>

<div id="app">
    <div class="hero"
         style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;"
    >
        <header class="pt-3">
            @include('elements.navbar')
        </header>

        <div class="hero__bottom">
            <div class="container d-flex justify-content-between">
                <button
                    class="hero__content copyButton d-flex flex-column  bg-transparent cursor-pointer border-0 mb-0"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual"
                >
                <span class="fw-bold text-uppercase">{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}</span>
                <span class="fw-semibold text-uppercase">
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
                        <span class="d-inline-flex px-1 text-xs fw-semibold bg-tertiary bg-opacity-50 border border-1 border-tertiary border-tertiary rounded-pill px-2">{{$connected}} connectés</span>
                    @else
                        Serveur hors-ligne
                    @endif
                </span>
                </button>

                <img src="{{site_logo()}}" alt="Logo de {{site_name()}}" height="260">
                <a href="{{theme_config('settings.discord.link') ?? 'https://www.dixept.fr/discord'}}" target="_blank" class="hero__content text-uppercase  text-decoration-none d-flex align-items-center btn btn-quaternary text-xs rounded-pill py-1 px-3 fw-semibold" style="height: 40px">Rejoindre le Discord</a>
            </div>
        </div>
    </div>

    @yield('app')
</div>

<footer>
    @include('elements.footer')
</footer>

@includeIf('components.general.discordAPI')

@stack('footer-scripts')
<script type="text/javascript">
    let copyButton = document.querySelectorAll(".copyButton");

    console.log(copyButton)
    copyButton.forEach(function(e) {
        e.addEventListener("click", function() {
            let textToCopy = '{!! theme_config('settings.server.ip') ?? 'play.dixept.fr' !!}';

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
