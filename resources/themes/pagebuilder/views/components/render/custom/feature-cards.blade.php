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

    $normalizeIconClass = static function ($value, string $fallback = 'bi bi-star-fill'): string {
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

    $title = trim((string) ($attributes['data-title'] ?? 'Pourquoi nous rejoindre ?'));
    $subtitle = trim((string) ($attributes['data-subtitle'] ?? ''));
    $features = collect([1, 2, 3, 4])->map(function (int $index) use ($attributes, $normalizeIconClass) {
        return [
            'icon' => $normalizeIconClass($attributes["data-feature-{$index}-icon"] ?? null),
            'title' => trim((string) ($attributes["data-feature-{$index}-title"] ?? "Feature {$index}")),
            'text' => trim((string) ($attributes["data-feature-{$index}-text"] ?? '')),
        ];
    })->all();
@endphp

<section @if($componentId) id="{{ $componentId }}" @endif @class($classes) @if($styleString) style="{{ $styleString }}" @endif>
    <div class="card-body p-4">
        @if($title !== '')
            <h2 class="h4 mb-1">{{ $title }}</h2>
        @endif

        @if($subtitle !== '')
            <p class="text-muted mb-3">{{ $subtitle }}</p>
        @endif

        <div class="row g-3">
            @foreach($features as $feature)
                <div class="col-md-6">
                    <div class="h-100 border rounded-3 p-3">
                        <i class="{{ $feature['icon'] }} fs-4 text-primary"></i>
                        @if($feature['title'] !== '')
                            <h3 class="h6 mt-2 mb-1">{{ $feature['title'] }}</h3>
                        @endif
                        @if($feature['text'] !== '')
                            <p class="text-muted mb-0">{{ $feature['text'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
