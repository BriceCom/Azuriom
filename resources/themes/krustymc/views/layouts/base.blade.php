<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = '1.1';
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="robots" content="follow, index, all"/>
    <link rel="icon" href="{{ favicon() }}" sizes="32x32">
    <link rel="shortcut icon" href="{{ favicon() }}">
    <link rel="canonical" href="{{url()->current()}}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{'@'.site_name()}}">
    <meta name="twitter:creator" content="{{'@'.site_name()}}">
    <meta name="twitter:creator:id" content="{{'@'.site_name()}}">
    <meta name="twitter:title" content="{{site_name()}} | @yield('title')">
    <meta name="twitter:description" content="@yield('description', setting('description', ''))">
    <meta name="twitter:image" content="{{ favicon() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Page level scripts -->
    @stack('scripts')
    <script type="text/javascript">
        const defaultTheme = "{{(theme_config('settings.theme.dark.prefer') == 'on')}}";
    </script>
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    @include('layouts/styles')

    <link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme }}">
    <link rel="stylesheet" href="{{ theme_asset('css/styles.css').'?ver='.$version_theme }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    @stack('styles')
    <style>
        @import url({{theme_config('style.index.font.url') ?? 'https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,700i,800,900&display=swap'}});
        @import url(https://fonts.bunny.net/css?family=vt323:400);

        body{
            font-family: "{{theme_config('style.index.font.name') ?? 'Poppins'}}", sans-serif;
        }

        :root {
            --di-quaterny-font: "vt323", sans-serif;
        }
    </style>
</head>

<body data-bs-theme="light">

<div id="app">
        <header class="position-absolute top-0 start-0 end-0">
            @include('elements.navbar')
        </header>

        @yield('app')

        <footer class="mt-15">
            @include('elements.footer.footer')
        </footer>
</div>

@stack('footer-scripts')
<script type="text/javascript">
    let copyButton = document.querySelectorAll([".copyButton", ".copyIp"]);

    copyButton.forEach(function(e) {
        e.addEventListener("click", function() {
            let textToCopy = '{!! theme_config('settings.server.ip') ?? 'serveurliste.fr' !!}';

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
<script>
    document.querySelectorAll('.card').forEach((el, index) => {
        el.setAttribute('data-aos', 'fade-up');
        el.setAttribute('data-aos-delay', `${index * 100}`);
        el.setAttribute('data-aos-offset', '0');
    });

    AOS.init({
        duration: 700,
        once: true
    });
</script>
</body>
</html>
