@php
    $serverAddress = trim((string) theme_config('global.server_address', ''));
    if ($serverAddress === '' && isset($servers) && $servers->count() > 0) {
        $serverAddress = (string) $servers->first()->fullAddress();
    }

    $playersOnline = isset($servers)
        ? (int) $servers->sum(static fn ($server) => $server->isOnline() ? $server->getOnlinePlayers() : 0)
        : 0;

    $badgeText = trim((string) ($params['badge_text'] ?? ''));
    if ($badgeText === '') {
        $badgeText = $playersOnline > 0 ? number_format($playersOnline, 0, ',', ' ').' joueurs en ligne maintenant' : 'Serveur en ligne';
    }

    $heroTitle = trim((string) ($params['title'] ?? ''));
    if ($heroTitle === '') {
        $heroTitle = 'Le serveur Minecraft';
    }

    $heroHighlight = trim((string) ($params['highlight'] ?? ''));
    if ($heroHighlight === '') {
        $heroHighlight = 'sans compromis.';
    }

    $heroSubtitle = trim((string) ($params['subtitle'] ?? ''));
    if ($heroSubtitle === '') {
        $heroSubtitle = 'Survie, PvP, Skyblock — un seul serveur, une communauté francophone active depuis 2021.';
    }

    $ipLabel = trim((string) ($params['ip_label'] ?? ''));
    if ($ipLabel === '') {
        $ipLabel = 'IP';
    }

    $ipStatus = trim((string) ($params['ip_status'] ?? ''));
    if ($ipStatus === '') {
        $ipStatus = 'En ligne';
    }

    $ipAddress = trim((string) ($params['ip_address'] ?? ''));
    if ($ipAddress === '') {
        $ipAddress = $serverAddress;
    }
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'hero',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    <div class="te-landing-hero">
        <div class="te-landing-hero-body">
            <p class="badge rounded-pill border text-bg-primary border-primary bg-opacity-10 border-opacity-10 text-uppercase fw-bold px-3 py-2 d-inline-flex align-items-center gap-2 mb-0">
                <span class="opacity-75">●</span>
                <span data-te-param="badge_text">{{ $badgeText }}</span>
            </p>

            <h1 class="mt-4 mb-0">
                <span data-te-param="title">{{ $heroTitle }}</span>
                <span class="text-primary" data-te-param="highlight">{{ $heroHighlight }}</span>
            </h1>

            <p class="text-body-secondary mt-3 mb-0 mx-auto" data-te-param="subtitle" style="max-width: 560px;">{{ $heroSubtitle }}</p>

            <div class="te-landing-actions">
                @include('theme-editor.blocks.home.partials.te-button', [
                    'variant' => $params['primary_button_variant'] ?? 'primary',
                    'text' => $params['primary_button_text'] ?? 'Commencer à jouer',
                    'url' => $params['primary_button_url'] ?? '#join',
                    'serverAddress' => $serverAddress,
                    'paramTextKey' => 'primary_button_text',
                    'paramUrlKey' => 'primary_button_url',
                    'nodeKey' => 'landing-hero-primary-button',
                ])
                @include('theme-editor.blocks.home.partials.te-button', [
                    'variant' => $params['secondary_button_variant'] ?? 'secondary',
                    'text' => $params['secondary_button_text'] ?? 'Voir les serveurs',
                    'url' => $params['secondary_button_url'] ?? '#servers',
                    'serverAddress' => $serverAddress,
                    'paramTextKey' => 'secondary_button_text',
                    'paramUrlKey' => 'secondary_button_url',
                    'nodeKey' => 'landing-hero-secondary-button',
                ])
            </div>

            <div class="te-landing-ip-bar">
                <span class="small text-uppercase text-body-secondary" data-te-param="ip_label">{{ $ipLabel }}</span>
                <span class="small font-monospace" data-te-node="landing-hero-ip">{{ $ipAddress }}</span>
                <span class="small text-uppercase text-primary" data-te-param="ip_status">{{ $ipStatus }}</span>
            </div>
        </div>
    </div>
    <div class="te-landing-divider"></div>
@endcomponent
