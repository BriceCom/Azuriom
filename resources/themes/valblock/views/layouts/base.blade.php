<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- SEO MAX -->
    <meta name="robots" content="follow, index, all"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ favicon() }}">
    <meta name="msapplication-TileImage" content="{{ favicon() }}">
    <meta name="msapplication-TileColor" content="#3490DC">
    <link rel="canonical" href="{{url()->current()}}">

    <!-- SEO BON -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{'@'.site_name()}}">
    <meta name="twitter:creator" content="{{'@'.site_name()}}">
    <meta name="twitter:creator:id" content="{{'@'.site_name()}}">
    <meta name="twitter:title" content="{{site_name()}} | @yield('title')">
    <meta name="twitter:description" content="@yield('description', setting('description', ''))">
    <meta name="twitter:image" content="{{ favicon() }}">

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
