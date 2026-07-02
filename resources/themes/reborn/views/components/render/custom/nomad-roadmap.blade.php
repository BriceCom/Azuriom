@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $title = trim((string) ($settings['title'] ?? 'Roadmap'));
    $subtitle = trim((string) ($settings['subtitle'] ?? ''));
    $items = is_array($settings['items'] ?? null) ? array_values($settings['items']) : [];

    $statusClass = static function ($status) {
        return match ((string) $status) {
            'done' => 'text-bg-success',
            'progress' => 'text-bg-warning',
            default => 'text-bg-secondary',
        };
    };

    $statusLabel = static function ($status) {
        return match ((string) $status) {
            'done' => 'Done',
            'progress' => 'In progress',
            default => 'Planned',
        };
    };
@endphp

<section class="container my-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
        <div>
            <h2 class="h3 mb-1">{{ $title }}</h2>
            @if($subtitle !== '')
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    <div class="reborn-roadmap">
        @foreach($items as $item)
            @php
                $phase = trim((string) ($item['phase'] ?? ''));
                $itemTitle = trim((string) ($item['title'] ?? ''));
                $itemText = trim((string) ($item['text'] ?? ''));
                $itemStatus = trim((string) ($item['status'] ?? 'planned'));
            @endphp

            <article class="reborn-roadmap-item card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                        <span class="badge text-bg-dark">{{ $phase !== '' ? $phase : 'Phase' }}</span>
                        <span class="badge {{ $statusClass($itemStatus) }}">{{ $statusLabel($itemStatus) }}</span>
                    </div>
                    <h3 class="h5 mb-2">{{ $itemTitle !== '' ? $itemTitle : 'Étape' }}</h3>
                    @if($itemText !== '')
                        <p class="text-muted mb-0">{{ $itemText }}</p>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
