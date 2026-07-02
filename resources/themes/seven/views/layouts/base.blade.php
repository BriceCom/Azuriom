<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = '1.0';
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- SEO MAX SI SERVEUR SOUS SERVEURLISTE -->
    <meta name="robots" content="follow, index, all"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ favicon() }}">
    <link rel="icon" href="{{ favicon() }}" sizes="32x32">
    <link rel="shortcut icon" href="{{ favicon() }}">
    <meta name="msapplication-TileImage" content="{{ favicon() }}">
    <meta name="msapplication-TileColor" content="#3490DC">
    <link rel="canonical" href="{{url()->current()}}">
    <meta name="i18nDefaultLocale" content="fr_FR">
    <meta name="i18nLocale" content="fr_FR">

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

    @stack('styles')
    <style>
        @if(theme_config('premium.serveurliste.link') && theme_config('settings.font.on'))
            @import url({{theme_config('settings.font.url') ?? 'https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,700i,800,900&display=swap'}});
            body{
                font-family: "{{theme_config('settings.font.name') ?? 'Poppins'}}", sans-serif;
            }
        @endif
    </style>
</head>

<body
    @if(!theme_config('style.index.theme.dark.off'))
        @php($defaultDark = (bool)theme_config('style.index.theme.dark.prefer'))
        @if(dark_theme($defaultDark))
            data-bs-theme="dark"
        @else
            data-bs-theme="light"
        @endif
    @else
        @if(theme_config('style.index.theme.dark.prefer'))
            data-bs-theme="dark"
        @else
            data-bs-theme="light"
        @endif
    @endif
>

<div id="app">
    @include('elements.header.page-height-bar')
    @include('elements.header.announce-bar')

    <div class="d-flex flex-column">
        @if(theme_config('header.index.variant'))
            @switch(theme_config('header.index.variant'))
                @case(1)
                    @include('elements.header.variants.header-variant-1')
                    @break
                @case(0)
                    @include('elements.header.variants.header-variant-0')
                    @break
                @default
                    @include('elements.header.variants.header-variant-1')
            @endswitch
        @else
            @include('elements.header.variants.header-variant-1')
        @endif


        @yield('app')

        @if(theme_config('modules.ui.scrollToTop.on'))
            @include('modules/ui/scrollToTop')
        @endif
        <footer class="py-4">
            @include('elements.footer.footer')
        </footer>

    </div>
</div>

@stack('footer-scripts')
@include('components.general.discordAPI')
@include('components.utils.copy-button-script')
</body>
</html>
