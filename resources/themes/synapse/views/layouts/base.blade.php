<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="robots" content="follow, index, all"/>
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
    <meta property="og:site_name" content="{{ site_name() }}">
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
    <link rel="preload" href="{{ theme_asset('css/override_bootstrap.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css') }}"></noscript>
    <link href="{{ theme_asset('css/styles.css') }}" rel="stylesheet">
    <style>
        :root {
            --bg-url: url({{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }});
            --bg-opacity: {{ theme_config('home.image.opacity') ?? '0.5' }};
            --bg-blur: {{ theme_config('home.image.blur').'px' ?? '7' }};
        }
    </style>
    @stack('styles')
    @include('elements.theme-color')
    <style>
        @if(theme_config('style.index.font.on'))
            @import url({{theme_config('style.index.font.url') ?? 'https://fonts.bunny.net/css?family=bai-jamjuree:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i'}});
            body{
                font-family: "{{theme_config('style.index.font.name') ?? 'Bai Jamjuree'}}", sans-serif;
            }
        @endif
    </style>
</head>

<body data-bs-theme="dark" class="bg-body">
    <span class="top gradient-circle"></span>
    <span class="bottom gradient-circle"></span>

    <div class="base-wrapper">
        <div class="base-content">
            <header>
                @include('elements.navbar')
            </header>

            <div id="app">

                @yield('app')
            </div>
            <footer>
                @include('elements.footer')
            </footer>
        </div>

    </div>
    @stack('footer-scripts')
</body>
</html>
