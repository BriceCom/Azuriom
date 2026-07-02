@php
    $items = is_array($params['items'] ?? null) ? $params['items'] : [];
    if (count($items) === 0) {
        $items = [
            ['icon' => '⚡', 'title' => 'Performances', 'text' => 'Serveurs dédiés avec protection DDoS et ping stable pour les joueurs européens.'],
            ['icon' => '🛡', 'title' => 'Anti-cheat', 'text' => 'Système anti-triche maison, mis à jour régulièrement pour un jeu équitable.'],
            ['icon' => '🎮', 'title' => 'Modes de jeu', 'text' => 'Survie PvP, Skyblock, OneBlock, Earth. Un mode pour chaque style.'],
            ['icon' => '💬', 'title' => 'Communauté', 'text' => 'Discord actif, support réactif et événements hebdomadaires.'],
        ];
    }
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'features',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    <div id="features" class="te-landing-section">
        <p class="badge bg-primary-subtle text-primary-emphasis text-uppercase fw-bold mb-2" data-te-param="badge">{{ $params['badge'] ?? 'Pourquoi nous ?' }}</p>
        <h2 class="mb-0" data-te-param="title">{{ $params['title'] ?? 'Conçu pour une expérience sans friction.' }}</h2>
        <p class="text-body-secondary mt-2 mb-0" data-te-param="subtitle">{{ $params['subtitle'] ?? 'Performances, équité, communauté — les trois piliers qui font la différence.' }}</p>

        <div class="te-landing-grid te-landing-grid-features" data-te-param-list="items">
            @foreach($items as $item)
                <article class="card h-100">
                    <div class="card-body">
                        <span class="te-landing-feature-icon">
                            @include('theme-editor.blocks.home.partials.te-icon', ['icon' => $item['icon'] ?? '★'])
                        </span>
                        <h3 class="h5 mb-2">{{ $item['title'] ?? 'Feature' }}</h3>
                        <p class="text-body-secondary mb-0">{{ $item['text'] ?? '' }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
    <div class="te-landing-divider"></div>
@endcomponent
