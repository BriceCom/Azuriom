@php
    $serverAddress = trim((string) theme_config('global.server_address', ''));
    if ($serverAddress === '' && isset($servers) && $servers->count() > 0) {
        $serverAddress = (string) $servers->first()->fullAddress();
    }
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'cta',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    <div class="card text-center te-landing-cta">
        <div class="card-body p-4 p-md-5">
            <p class="badge bg-primary-subtle text-primary-emphasis text-uppercase fw-bold mb-2" data-te-param="badge">{{ $params['badge'] ?? 'Prêt ?' }}</p>
            <h2 class="mb-0" data-te-param="title">{{ $params['title'] ?? 'Rejoins l’aventure dès aujourd’hui.' }}</h2>
            <p class="text-body-secondary mt-2 mb-0" data-te-param="subtitle">{{ $params['subtitle'] ?? 'Gratuit. Sans inscription. La communauté t’attend.' }}</p>

            <div class="te-landing-actions">
                @include('theme-editor.blocks.home.partials.te-button', [
                    'variant' => $params['primary_button_variant'] ?? 'primary',
                    'text' => $params['primary_button_text'] ?? 'Commencer à jouer',
                    'url' => $params['primary_button_url'] ?? '#join',
                    'serverAddress' => $serverAddress,
                    'paramTextKey' => 'primary_button_text',
                    'paramUrlKey' => 'primary_button_url',
                    'nodeKey' => 'landing-cta-primary-button',
                ])
                @include('theme-editor.blocks.home.partials.te-button', [
                    'variant' => $params['secondary_button_variant'] ?? 'secondary',
                    'text' => $params['secondary_button_text'] ?? 'Rejoindre le Discord',
                    'url' => $params['secondary_button_url'] ?? theme_config('global.discord_link', '#'),
                    'serverAddress' => $serverAddress,
                    'paramTextKey' => 'secondary_button_text',
                    'paramUrlKey' => 'secondary_button_url',
                    'nodeKey' => 'landing-cta-secondary-button',
                ])
            </div>
        </div>
    </div>
@endcomponent
