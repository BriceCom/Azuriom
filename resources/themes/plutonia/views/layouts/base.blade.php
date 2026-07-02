<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = json_decode(file_get_contents(theme_path().'/theme.json'), true);
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#292e32">
    <meta name="author" content="{{ site_name() }}">
    <meta name="publisher" content="{{ site_name() }}">
    <meta name="i18nDefaultLocale" content="fr_FR">
    <meta name="i18nLocale" content="fr_FR">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ site_name() }} | @yield('title')">
    <meta name="twitter:description" content="@yield('description', setting('description', ''))">
    <meta name="twitter:image" content="{{ favicon() }}">
    <meta name="twitter:site" content="{{'@'.site_name()}}">
    <meta name="twitter:creator" content="{{'@'.site_name()}}">
    <meta property="og:title" content="{{ site_name() }} | @yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
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
    <link href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}" rel="stylesheet">
    <link href="{{ theme_asset('css/styles.css').'?ver='.$version_theme['version'] }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

<div id="app">
    <header>
        @include('elements.navbar')
    </header>

    @yield('app')
</div>

<footer class="text-center text-white bg-dark mt-auto py-4">
    @include('elements.footer')
</footer>

@stack('footer-scripts')

</body>
</html>
