<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#fdb800">
    <meta name="author" content="Azuriom">
    @if(str_starts_with(\Azuriom\Azuriom::version(), '1.0.'))
        <meta http-equiv="refresh" content="1">
        @php themes()->changeTheme(null); @endphp
    @endif
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
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ theme_asset('js/particles.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/particles-init.js') }}" defer></script>
    <script src="{{ theme_asset('js/clipboard.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Raleway:300,400,600,800&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
    @include('elements.theme-color', ['color' => '#af153a'])
    <style>
        :root {
            --background-url: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}')
        }
    </style>
    <!-- Bloc AJOUTÉ pour appliquer la variable en background -->
    <style>
        .header {
            background: var(--background-url) no-repeat center / cover !important;
        }
    </style>
</head>

<body data-bs-theme="dark">
@yield('app')

<footer>
    @include('elements.footer')
</footer>

@stack('footer-scripts')

</body>
</html>
