<!DOCTYPE html>
@include('elements.base')
@php
    $versionTheme = '1.1.0';
    $serverCollection = collect();

    if (isset($servers)) {
        if ($servers instanceof \Illuminate\Support\Collection) {
            $serverCollection = $servers;
        } elseif (is_iterable($servers)) {
            $serverCollection = collect($servers);
        }
    }

    $totalPlayers = $serverCollection->sum(function ($server) {
        return $server->isOnline() ? $server->getOnlinePlayers() : 0;
    });
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="follow, index, all">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="author" content="Azuriom, Seriva Theme">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ site_name() }} | @yield('title')">
    <meta name="twitter:description" content="@yield('description', setting('description', ''))">
    <meta name="twitter:image" content="{{ favicon() }}">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    @stack('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ site_name() }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ favicon() }}">
    <link rel="icon" href="{{ favicon() }}" sizes="32x32">
    <link rel="shortcut icon" href="{{ favicon() }}">

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    @stack('scripts')

    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    @include('layouts/styles')
    <link rel="stylesheet" href="{{ theme_asset('css/override-bootstrap.css') }}?ver={{ $versionTheme }}">
    <link rel="stylesheet" href="{{ theme_asset('css/styles.css') }}?ver={{ $versionTheme }}">
    @stack('styles')
</head>

<body
    @if(!theme_config('style.index.theme.dark.off'))
        @php($defaultDark = (bool) theme_config('style.index.theme.dark.prefer'))
        data-bs-theme="{{ dark_theme($defaultDark) ? 'dark' : 'light' }}"
    @else
        data-bs-theme="{{ theme_config('style.index.theme.dark.prefer') ? 'dark' : 'light' }}"
    @endif
>
<div id="app" class="seriva-app">
    @include('elements.header.page-height-bar')
    @include('elements.header.announce-bar')
    @include('elements.navbar')

    @yield('app')

    @include('elements.footer.footer')
</div>

@stack('footer-scripts')
@include('components.oauth.oauth-script')
<script type="text/javascript">
    window.THEME = {
        discord_key: "{{ theme_config('settings.discord.id') ?? '' }}",
        server_online: {{ $totalPlayers }},
        discord_online: 0
    };
</script>
<script src="{{ theme_asset('js/app.js') }}?ver={{ $versionTheme }}" defer></script>
<script src="{{ theme_asset('js/copyboard.js') }}" defer></script>
<script src="{{ theme_asset('js/counters.js') }}" defer></script>
@if(theme_config('settings.discord.id'))
    <script src="{{ theme_asset('js/discord.js') }}" defer></script>
@endif
</body>
</html>
