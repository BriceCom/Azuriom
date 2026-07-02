@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $title = trim((string) ($settings['title'] ?? ''));
    $subtitle = trim((string) ($settings['subtitle'] ?? ''));
    $items = is_array($settings['items'] ?? null) ? array_values($settings['items']) : [];
@endphp

<section class="container my-5">
    <div class="mb-4">
        @if($title !== '')
            <h2 class="h3 mb-1">{{ $title }}</h2>
        @endif
        @if($subtitle !== '')
            <p class="text-muted mb-0">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="row g-3">
        @foreach($items as $item)
            @php
                $icon = trim((string) ($item['icon'] ?? 'bi bi-shield-fill'));
                $name = trim((string) ($item['name'] ?? 'Classe'));
                $role = trim((string) ($item['role'] ?? 'Rôle'));
                $text = trim((string) ($item['text'] ?? ''));
            @endphp

            <div class="col-md-6 col-xl-4">
                <article class="card h-100 reborn-dungeon-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <i class="{{ $icon }} fs-3 text-primary"></i>
                            <span class="badge text-bg-dark">{{ $role }}</span>
                        </div>
                        <h3 class="h5">{{ $name }}</h3>
                        @if($text !== '')
                            <p class="text-muted mb-0">{{ $text }}</p>
                        @endif
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>
