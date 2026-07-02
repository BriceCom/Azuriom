@php
    $attributes = is_array($component['attributes'] ?? null) ? $component['attributes'] : [];
    $classes = collect($component['classes'] ?? [])
        ->filter(fn ($className) => is_string($className) && trim($className) !== '')
        ->values()
        ->all();
    $style = is_array($component['style'] ?? null) ? $component['style'] : [];
    $componentId = isset($attributes['id']) && is_string($attributes['id']) ? $attributes['id'] : null;
    $styleString = collect($style)
        ->filter(fn ($value, $property) => is_string($property) && is_scalar($value) && trim((string) $value) !== '')
        ->map(fn ($value, $property) => $property.':'.trim((string) $value))
        ->implode(';');

    if (empty($classes)) {
        $classes = ['card', 'border-0', 'shadow-sm'];
    }

    $normalizeIconClass = static function ($value, string $fallback = 'bi bi-bar-chart-fill'): string {
        $icon = trim((string) $value);
        if ($icon === '' || preg_match('/[^a-z0-9\-_ ]/i', $icon) === 1) {
            return $fallback;
        }

        if (str_starts_with($icon, 'bi bi-')) {
            return $icon;
        }

        if (str_starts_with($icon, 'bi-')) {
            return 'bi '.$icon;
        }

        if (str_starts_with($icon, 'bi ')) {
            return $icon;
        }

        return 'bi '.$icon;
    };

    $title = trim((string) ($attributes['data-title'] ?? 'Statistiques du serveur'));
    $stats = collect([1, 2, 3])->map(function (int $index) use ($attributes, $normalizeIconClass) {
        return [
            'value' => trim((string) ($attributes["data-stat-{$index}-value"] ?? '0')),
            'label' => trim((string) ($attributes["data-stat-{$index}-label"] ?? "Label {$index}")),
            'icon' => $normalizeIconClass($attributes["data-stat-{$index}-icon"] ?? null),
        ];
    })->all();
@endphp

<section @if($componentId) id="{{ $componentId }}" @endif @class($classes) @if($styleString) style="{{ $styleString }}" @endif>
    <div class="card-body p-4">
        @if($title !== '')
            <h2 class="h4 mb-3">{{ $title }}</h2>
        @endif

        <div class="row g-3">
            @foreach($stats as $stat)
                <div class="col-md-4">
                    <div class="border rounded-3 h-100 p-3 text-center">
                        <i class="{{ $stat['icon'] }} fs-3 text-primary mb-2"></i>
                        <p class="h4 mb-0">{{ $stat['value'] !== '' ? $stat['value'] : '0' }}</p>
                        @if($stat['label'] !== '')
                            <p class="text-muted mb-0">{{ $stat['label'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
