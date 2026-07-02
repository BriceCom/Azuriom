<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom">

    <meta property="og:title" content="@yield('title')">
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
    <script src="{{ theme_asset('js/bootstrap.bundle.min.js') }}" defer data-cfasync="false"></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ theme_asset('js/app.js') }}" defer data-cfasync="false"></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=asul:400,700|inter:100,200,300,400,500,600,700,800,900|mirza:400,500,600,700"
        rel="stylesheet"/>
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ theme_asset('css/styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
<div id="app">
    <header class="header position-relative z-3">
        @include('elements.navbar')
    </header>

    @yield('app')

    @include('layouts.footer')
</div>

{{--<script src="{{ theme_asset('js/vanilla-tilt.min.js') }}"></script>--}}
@stack('footer-scripts')

</body>
</html>
