<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ── SEO DE BASE ── --}}
    <title>@yield('title') | {{ site_name() }}</title>
    <meta name="description" content="@yield('meta_description', 'PokeCube est un serveur Minecraft Survie Cobblemon 1.21 avec launcher et modpack gratuit. Complète ton Pokédex, construis ta ville et deviens le plus riche ! Rejoins des centaines de joueurs dès maintenant.')">
    <meta name="keywords" content="serveur minecraft cobblemon, cobblemon 1.21, serveur pokémon minecraft, minecraft survie pokémon, pokecube, modpack cobblemon, launcher minecraft cobblemon, pokédex minecraft, serveur cobblemon français, minecraft pokemon fr">
    <meta name="author" content="{{ site_name() }}">
    <meta name="robots" content="index, follow">
    <meta name="language" content="fr">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- ── OPEN GRAPH (Facebook, Discord) ── --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ site_name() }}">
    <meta property="og:title" content="@yield('title') | {{ site_name() }}">
    <meta property="og:description" content="@yield('meta_description', 'Serveur Minecraft Cobblemon 1.21 — Complète ton Pokédex, construis ta ville et deviens le plus riche sur PokeCube !')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('img/og-banner.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="fr_FR">

    {{-- ── TWITTER CARD ── --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') | {{ site_name() }}">
    <meta name="twitter:description" content="@yield('meta_description', 'Serveur Minecraft Cobblemon 1.21 — Complète ton Pokédex, construis ta ville et deviens le plus riche sur PokeCube !')">
    <meta name="twitter:image" content="@yield('og_image', asset('img/banner.png'))">


    {{-- ── FAVICON ── --}}
    <link rel="icon" href="{{ favicon() }}">
    <link rel="shortcut icon" href="{{ favicon() }}">

    {{-- ── CSS ── --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/pokecube.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- ── GOOGLE ANALYTICS ── --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=GTM-M5ZJ2H75"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GTM-M5ZJ2H75', {
            'anonymize_ip': true
        });
    </script>
    @stack('scripts')

    {{-- ── SCRIPTS AZURIOM ── --}}
    @stack('styles')
    @stack('head')
</head>
    <body>


      {{-- Navbar --}}



      <main class="content-wrapper">
        @yield('content')
      </main>
      @include('elements.footer')
      {{-- JS --}}
      <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ theme_asset('js/script.js') }}"></script>
    </body>
</html>
