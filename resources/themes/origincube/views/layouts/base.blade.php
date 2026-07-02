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
    <meta name="theme-color" content="#121212">
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
</head>

<body>

<div id="app" class="mb-8 mb-md-15">
    <header class="position-absolute top-0 start-0 end-0">
        @include('elements.navbar')
    </header>

    @yield('app')
</div>

<footer class="bg-dark pt-5">
    @include('elements.footer')
</footer>

@stack('footer-scripts')

</body>
</html>
