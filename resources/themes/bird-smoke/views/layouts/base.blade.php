<!DOCTYPE html>
@include('elements.base')
@include('theme-editor.partials.mount')
@php
    $teThemeEditorVersion = view()->shared('teThemeEditorVersion', '1');
    $teLayoutBlockParams = view()->shared('teLayoutBlockParams', ['header' => [], 'footer' => []]);
    $teHeaderView = view()->shared('teHeaderView');
    $teFooterView = view()->shared('teFooterView');
    $themePriority = theme_config('styles.theme_priority', 'dark');
    $defaultDark = $themePriority === 'dark';
    $darkDisabled = theme_config('styles.theme_dark_disabled', false);
    $isDarkTheme = $darkDisabled ? $defaultDark : dark_theme($defaultDark);
@endphp
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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <link rel="shortcut icon" href="{{ favicon() }}">

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    @stack('scripts')

    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css').'?ver=1' }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css').'?ver=1' }}" rel="stylesheet">

    <link href="{{ theme_asset('css/override-bootstrap.css').'?ver=1' }}" rel="stylesheet">
    <link href="{{ theme_asset('css/styles.css').'?ver=1' }}" rel="stylesheet">
    <link href="{{ theme_asset('css/minecraft-landing.css').'?ver=1' }}" rel="stylesheet">
    @stack('styles')
</head>

<body class="d-flex flex-column bg-body-secondary" data-bs-theme="{{ $isDarkTheme ? 'dark' : 'light' }}">
<div data-te-node="layout-top-stack">
    @if(is_string($teHeaderView) && $teHeaderView !== '')
        @include($teHeaderView, ['params' => $teLayoutBlockParams['header'] ?? []])
    @endif
</div>

<div id="app" class="flex-shrink-0 d-flex flex-column">
    @yield('app')
    @include('theme-editor.partials.render-content')
</div>

@if(is_string($teFooterView) && $teFooterView !== '')
    @include($teFooterView, ['params' => $teLayoutBlockParams['footer'] ?? []])
@endif

@stack('footer-scripts')

@php
    $particlesImage = theme_config('global.particles_image');
    if (is_string($particlesImage) && $particlesImage !== '') {
        $particlesImage = image_url($particlesImage);
    }
@endphp
<script>
    window.THEME = Object.assign({}, window.THEME || {}, {
        discord_key: @json((string) theme_config('global.discord_id', '')),
        particles: {
            enabled: @json((bool) theme_config('global.particles_enabled', false)),
            count: {{ (int) theme_config('global.particles_count', 80) }},
            density: {{ (int) theme_config('global.particles_density', 50) }},
            speed: {{ (int) theme_config('global.particles_speed', 3) }},
            size: {{ (int) theme_config('global.particles_size', 3) }},
            image: @json($particlesImage),
            color: 'rgba(255, 255, 255, 0.8)',
        }
    });
</script>
<script src="{{ theme_asset('js/particles.js') }}" defer></script>
<script src="{{ theme_asset('js/theme-editor/aos.js').'?ver='.$teThemeEditorVersion }}" defer></script>
<script src="{{ theme_asset('js/app.js') }}" defer></script>
<script src="{{ theme_asset('js/copyboard.js') }}" defer></script>

</body>
</html>
