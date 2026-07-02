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
    <header class="position-relative d-flex align-items-center">
        @include('elements.navbar')
    </header>

    @yield('app')
</div>

@stack('footer-scripts')

<script type="text/javascript">
    var copyButton = document.getElementById("copyButton");

    copyButton.addEventListener("click", function() {
        var textToCopy = '{!! theme_config('home.ip.text') ?? 'play.astrala.fr' !!}';

        // Création d'un élément temporaire pour la copie du texte
        var tempInput = document.createElement("input");
        tempInput.setAttribute("value", textToCopy);
        copyButton.innerText="IP Copié!"
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        var tooltip = new bootstrap.Tooltip(copyButton);
        tooltip.show();

        // Masquer le tooltip après 3 secondes
        setTimeout(function() {
            tooltip.hide();
            copyButton.innerText='{!! theme_config('home.ip.text') ?? 'play.astrala.fr' !!}'
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


</body>
</html>
