<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $themeColor = dark_theme()
            ? (theme_config('style.colors.dark.primary') ?? '#3490DC')
            : (theme_config('style.colors.light.primary') ?? '#3490DC');
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="{{ $themeColor }}">
    <meta name="author" content="Azuriom">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    @stack('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <link rel="shortcut icon" href="{{ favicon() }}">

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    @stack('scripts')

    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('css/styles.css') }}">
    @include('layouts/styles')

    @stack('styles')
    <style>
        html,
        body {
            height: 100%;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="d-flex flex-column bg-body-secondary" @if(dark_theme()) data-bs-theme="dark" @endif>
<div id="app" class="flex-shrink-0">
    <header>
        @include('elements.navbar')
    </header>

    @yield('app')
</div>

@include('elements.footer')

@stack('footer-scripts')
<script src="{{ theme_asset('js/home.js') }}"></script>

</body>
</html>
