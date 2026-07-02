<html>
    <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            {{-- ── SEO DE BASE ── --}}
            <title>Maintenance | {{ site_name() }}</title>
            <meta name="description" content="@yield('meta_description', 'PokeCube est un serveur Minecraft Survie Cobblemon 1.21 avec launcher et modpack gratuit. Complète ton Pokédex, construis ta ville et deviens le plus riche ! Rejoins des centaines de joueurs dès maintenant.')">
            <meta name="keywords" content="serveur minecraft cobblemon, cobblemon 1.21, serveur pokémon minecraft, minecraft survie pokémon, pokecube, modpack cobblemon, launcher minecraft cobblemon, pokédex minecraft, serveur cobblemon français, minecraft pokemon fr">
            <meta name="author" content="{{ site_name() }}">
            <meta name="robots" content="index, follow">
            <meta name="language" content="fr">
            <link rel="canonical" href="{{ url()->current() }}">

            {{-- ── OPEN GRAPH (Facebook, Discord) ── --}}
            <meta property="og:type" content="website">
            <meta property="og:site_name" content="{{ site_name() }}">
            <meta property="og:title" content="Maintenance | {{ site_name() }}">
            <meta property="og:description" content="@yield('meta_description', 'Serveur Minecraft Cobblemon 1.21 — Complète ton Pokédex, construis ta ville et deviens le plus riche sur PokeCube !')">
            <meta property="og:url" content="{{ url()->current() }}">
            <meta property="og:image" content="@yield('og_image', asset('img/og-banner.jpg'))">
            <meta property="og:image:width" content="1200">
            <meta property="og:image:height" content="630">
            <meta property="og:locale" content="fr_FR">

            {{-- ── TWITTER CARD ── --}}
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:title" content="Maintenance | {{ site_name() }}">
            <meta name="twitter:description" content="@yield('meta_description', 'Serveur Minecraft Cobblemon 1.21 — Complète ton Pokédex, construis ta ville et deviens le plus riche sur PokeCube !')">
            <meta name="twitter:image" content="@yield('og_image', asset('img/banner.png'))">


            {{-- ── FAVICON ── --}}
            <link rel="icon" href="{{ favicon() }}">
            <link rel="shortcut icon" href="{{ favicon() }}">
        <link rel="stylesheet" href="{{ theme_asset('css/maintenance.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    </head>
        <div class="maintenance-container">
            <img src="{{ theme_asset('img/maintenance.gif') }}" class="maintenance-bg" />

            <div class="maintenance-logo">
                <img src="{{ site_logo() }}" alt="Logo">
            </div>

            <div class="maintenance-box">
                <h3>Nous arrivons prochainement</h3>

                <a href="https://discord.gg/pokecube" class="discord-btn-maintenance">
                    <i class="fab fa-discord"></i>
                    Rejoindre le Discord
                </a>

            </div>
        <div class="snow">
            @for ($i = 0; $i < 40; $i++)
                <span style="
                    left: {{ rand(0, 100) }}%;
                    animation-duration: {{ rand(6, 14) }}s;
                    animation-delay: -{{ rand(0, 14) }}s;
                    width: {{ rand(3, 7) }}px;
                    height: {{ rand(3, 7) }}px;
                "></span>
            @endfor
        </div>

        </div>
</html>
@section('title', trans('messages.maintenance.title'))
@section('app')

@endsection
