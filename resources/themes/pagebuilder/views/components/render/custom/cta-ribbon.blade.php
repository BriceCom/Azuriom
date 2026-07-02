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

    $sanitizeUrl = static function ($value, string $fallback = '#'): string {
        $url = trim((string) $value);
        if ($url === '') {
            return $fallback;
        }

        $decoded = strtolower(html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $normalized = preg_replace('/\s+/', '', $decoded) ?? $decoded;
        if (str_starts_with($normalized, 'javascript:') || str_starts_with($normalized, 'vbscript:') || str_starts_with($normalized, 'data:')) {
            return $fallback;
        }

        if (str_starts_with($url, '#') || str_starts_with($url, '/') || str_starts_with($url, './') || str_starts_with($url, '../')) {
            return $url;
        }

        if (preg_match('/^(https?:|mailto:|tel:)/i', $url) === 1) {
            return $url;
        }

        return $fallback;
    };

    $normalizeIconClass = static function ($value, string $fallback = 'bi bi-megaphone-fill'): string {
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

    $icon = $normalizeIconClass($attributes['data-icon'] ?? null);
    $title = trim((string) ($attributes['data-title'] ?? 'Annonce importante'));
    $text = trim((string) ($attributes['data-text'] ?? ''));
    $buttonLabel = trim((string) ($attributes['data-button-label'] ?? 'En savoir plus'));
    $buttonUrl = $sanitizeUrl($attributes['data-button-url'] ?? '#', '#');
@endphp

<section @if($componentId) id="{{ $componentId }}" @endif @class($classes) @if($styleString) style="{{ $styleString }}" @endif>
    <div class="card-body p-4">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <i class="{{ $icon }}"></i>
            </div>

            <div class="flex-grow-1">
                @if($title !== '')
                    <h2 class="h5 mb-1">{{ $title }}</h2>
                @endif
                @if($text !== '')
                    <p class="text-muted mb-0">{{ $text }}</p>
                @endif
            </div>

            @if($buttonLabel !== '')
                <a href="{{ $buttonUrl }}" class="btn btn-primary">{{ $buttonLabel }}</a>
            @endif
        </div>
    </div>
</section>
