@php
    $items = is_array($params['items'] ?? null) ? $params['items'] : [];
    if (count($items) === 0) {
        $items = [
            ['title' => 'Ouvre Minecraft', 'text' => 'Lance Java Edition ou Bedrock puis clique sur "Multijoueur".'],
            ['title' => 'Ajoute un serveur', 'text' => 'Clique sur "Ajouter un serveur" et renseigne l’adresse IP.'],
            ['title' => 'Connecte-toi et joue', 'text' => 'Choisis ton mode de jeu et rejoins la communauté.'],
        ];
    }
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'steps',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    <div id="join" class="te-landing-section">
        <p class="badge bg-primary-subtle text-primary-emphasis text-uppercase fw-bold mb-2" data-te-param="badge">{{ $params['badge'] ?? 'Comment rejoindre' }}</p>
        <h2 class="mb-0" data-te-param="title">{{ $params['title'] ?? 'En ligne en moins de 60 secondes.' }}</h2>
        <p class="text-body-secondary mt-2 mb-0" data-te-param="subtitle">{{ $params['subtitle'] ?? 'Accessible sur Java et Bedrock, sans mod, sans inscription obligatoire.' }}</p>

        <div class="te-landing-steps" data-te-param-list="items">
            @foreach($items as $index => $item)
                <article class="card">
                    <div class="card-body d-flex gap-3">
                        <span class="badge rounded-pill bg-primary font-monospace d-inline-flex align-items-center justify-content-center" style="min-width: 2.15rem;">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <h3 class="h5 mb-1">{{ $item['title'] ?? 'Étape' }}</h3>
                            <p class="text-body-secondary mb-0">{{ $item['text'] ?? '' }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
    <div class="te-landing-divider"></div>
@endcomponent
