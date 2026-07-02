<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = '1.22';

    $totalPlayers = $servers->where('home_display', true)->sum(function($server) {
        return $server->isOnline() ? $server->getOnlinePlayers() : 0;
    });
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="follow, index, all"/>
    <link rel="canonical" href="{{url()->current()}}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="author" content="Azuriom, Dixept">
    <meta name="publisher" content="{{site_name()}}, Dixept">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ favicon() }}">
    <link rel="icon" href="{{ favicon() }}" sizes="32x32">
    <link rel="shortcut icon" href="{{ favicon() }}">
    <meta name="msapplication-TileImage" content="{{ favicon() }}">
    <meta name="msapplication-TileColor" content="#3490DC">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{'@'.site_name()}}">
    <meta name="twitter:creator" content="{{'@'.site_name()}}">
    <meta name="twitter:creator:id" content="{{'@'.site_name()}}">
    <meta name="twitter:title" content="{{site_name()}} | @yield('title')">
    <meta name="twitter:description" content="@yield('description', setting('description', ''))">
    <meta name="twitter:image" content="{{ favicon() }}">

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
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    @include('layouts/styles')
    <link rel="preload" href="{{ theme_asset('css/override-bootstrap.css').'?ver='.$version_theme }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ theme_asset('css/override-bootstrap.css').'?ver='.$version_theme }}">
    </noscript>
    <link rel="preload" href="{{ theme_asset('css/styles.css').'?ver='.$version_theme }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ theme_asset('css/styles.css').'?ver='.$version_theme }}">
    </noscript>
    @stack('styles')
    <style>
            @import url({{theme_config('style.index.font.url') ?? 'https://fonts.bunny.net/css?family=poppins:200,300,400,500,600,700,800&display=swap'}});

        :root {
            --di-main-font: "{{theme_config('style.index.font.name') ?? 'poppins'}}", sans-serif;

        }
    </style>
    <script type="text/javascript">
        window.THEME = {
            discord_key: "{{theme_config('settings.discord.id') ?? '1025845189115400303'}}",
            server_online: {{ $totalPlayers }}
        }
    </script>
    <script src="{{ theme_asset('js/discord.js') }}"></script>
</head>

<body data-bs-theme="dark">
<div id="app">
    @include('elements.header.announce-bar')
    @include('elements.navbar')

    <div class="d-flex flex-column overflow-x-hidden">
        @yield('app')

        @include('elements.footer.footer')
    </div>
</div>

@stack('footer-scripts')
<script src="{{ theme_asset('js/app.js').'?ver='.$version_theme }}"></script>
<script src="{{ theme_asset('js/copyboard.js') }}"></script>
<script src="{{ theme_asset('js/counters.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/animejs/lib/anime.iife.min.js"></script>

<script>
    const {animate, createSpring, createTimeline, stagger, utils, onScroll, timeline} = anime;
</script>
<script src="{{ theme_asset('js/animations.js') }}" type="module"></script>

</body>
</html>
