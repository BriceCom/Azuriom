<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="referrer" content="origin-when-crossorigin" id="meta_referrer">
    <meta content="origin" name="referrer">
    <meta name="title" content="Faylora - La survie du moment ! | 1.21+">
    <meta name="Subject" content="Minecraft">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="keywords" content="@yield('keywords', setting('keywords', ''))">
    <meta name="author" content="Faylora">
    <meta name="copyright" content="{{ site_name() }}">
    <meta name="reply-to" content="contact@faylora.fr">
    <meta name="rating" content="settings">
    <meta name="distribution" content="global">
    <meta name="language" content="French">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="2 days">
    <meta name="apple-mobile-web-app-title" content="Faylora">
    <meta name="apple-mobile-web-app-status-bar-style" content="#1a1c24">
    <meta name="theme-color" content="#1a1c24">
    <meta property="og:title" content="Faylora - La survie du moment ! | 1.21+">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="faylora.fr">
    <meta property="twitter:title" content="Faylora - La survie du moment ! | 1.21+">
    <meta property="twitter:description" content="@yield('description', setting('description', ''))">
    <meta property="twitter:image" content="{{ theme_asset('banner.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">
    <link rel="icon" href="{{ favicon() }}" type="image/x-icon">
    <link rel="manifest" href="{{  theme_asset('manifest.json') }}" crossorigin="use-credentials" rel="manifest">

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="{{ theme_asset('css/tailwind.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body class="font-display bg-steel-300 overflow-x-hidden">
    @include('elements.navbar')

    @yield('app')

    @include('elements.footer')

    @if(setting('captcha.type') === 'recaptcha')
    <script src="https://www.recaptcha.net/recaptcha/api.js?hl={{ app()->getLocale() }}" async defer></script>
    @elseif(setting('captcha.type') === 'hcaptcha')
    <script src="https://hcaptcha.com/1/api.js?hl={{ app()->getLocale() }}" async defer></script>
    @elseif(setting('captcha.type') === 'turnstile')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif

    <script src="{{ theme_asset('js/ripple.js') }}"></script>
    <script src="{{ theme_asset('js/preline.js') }}"></script>
    <script src="{{ theme_asset('js/index.js') }}"></script>
    @stack('footer-scripts')
</body>

</html>
