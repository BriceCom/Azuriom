@php
    $items = is_array($params['items'] ?? null) ? $params['items'] : [];
    if (count($items) === 0) {
        $playersOnline = isset($servers)
            ? (int) $servers->sum(static fn ($server) => $server->isOnline() ? $server->getOnlinePlayers() : 0)
            : 1247;

        $items = [
            ['value' => '+500k', 'label' => 'Joueurs uniques'],
            ['value' => '40k', 'label' => 'Membres Discord'],
            ['value' => number_format(max(0, $playersOnline), 0, ',', ' '), 'label' => 'En ligne maintenant'],
            ['value' => '4.8/5', 'label' => 'Note moyenne'],
        ];
    }
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'stats',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    <div class="te-landing-section">
        <p class="badge bg-primary-subtle text-primary-emphasis text-uppercase fw-bold mb-2" data-te-param="badge">{{ $params['badge'] ?? 'En chiffres' }}</p>
        <h2 class="mb-0" data-te-param="title">{{ $params['title'] ?? 'Un serveur solide depuis 2021.' }}</h2>

        <div class="te-landing-grid te-landing-grid-stats" data-te-param-list="items">
            @foreach($items as $item)
                <article class="card text-center">
                    <div class="card-body">
                        <h3 class="display-6 mb-1 fw-bold">{{ $item['value'] ?? '0' }}</h3>
                        <p class="text-body-secondary text-uppercase small mb-0">{{ $item['label'] ?? 'Stat' }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endcomponent
