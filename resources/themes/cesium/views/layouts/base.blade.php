<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="referrer" content="origin-when-crossorigin" id="meta_referrer">
    <meta content="origin" name="referrer">
    <meta name="title" content="@yield('title')">
    <meta name="Subject" content="Minecraft">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="keywords" content="{{ theme_config('keywords') }}">
    <meta name="author" content="Afi">
    @if (str_starts_with(\Azuriom\Azuriom::version(), '1.0.'))
        <meta http-equiv="refresh" content="1">
        @php themes()->changeTheme(null); @endphp
    @endif
    <meta name="copyright" content="{{ site_name() }}">
    <meta name="reply-to" content="{{ theme_config('contact_email') }}">
    <meta name="rating" content="general">
    <meta name="distribution" content="global">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="2 days">
    <meta name="apple-mobile-web-app-title" content="{{ site_name() }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="#0f1217">
    <meta name="theme-color" content="#0f1217">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ theme_asset('static/embed.png') }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title')">
    <meta property="twitter:description" content="@yield('description', setting('description', ''))">
    <meta property="twitter:image" content="{{ theme_asset('static/embed.png') }}">
    <meta property="twitter:site" content="{{ site_name() }}">
    <meta property="twitter:creator" content="Afi">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <title>@yield('title') | {{ site_name() }}</title>
    <link rel="shortcut icon" href="{{ favicon() }}">
    <link rel="icon" href="{{ favicon() }}" type="image/x-icon">
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <link rel="manifest" href="{{ theme_asset('manifest.json') }}" crossorigin="use-credentials" rel="manifest">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/gen.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/swiper.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body class="overflow-x-hidden bg-steel-300">
    <div id="app">
        <header>
            @include('elements.navbar')
        </header>
        @yield('app')
    </div>
    <footer>
        @include('elements.footer')
    </footer>
    @stack('footer-scripts')
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ theme_asset('js/clipboard.js') }}" defer></script>
    <script src="{{ theme_asset('js/vanilla-tilt.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/preline.js') }}" defer></script>
    <script src="{{ theme_asset('js/swiper.js') }}" defer></script>
    <script src="{{ theme_asset('js/discordembed.js') }}" defer></script>
    <script src="{{ theme_asset('js/notification.js') }}" defer></script>
    <script src="{{ theme_asset('js/offercountdown.js') }}" defer></script>
    <script src="{{ theme_asset('js/skinview3d.js') }}" defer></script>
    <script src="{{ theme_asset('js/skin_init.js') }}" defer></script>
    <script src="{{ theme_asset('js/mount_countdown.js') }}" defer></script>
    @stack('scripts')

</body>

</html>
