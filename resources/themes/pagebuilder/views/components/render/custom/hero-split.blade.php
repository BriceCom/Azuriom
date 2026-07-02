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
        $classes = ['card', 'text-bg-dark', 'border-0', 'shadow-sm', 'overflow-hidden'];
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

    $badge = trim((string) ($attributes['data-badge'] ?? 'Nouveau'));
    $title = trim((string) ($attributes['data-title'] ?? site_name()));
    $subtitle = trim((string) ($attributes['data-subtitle'] ?? ''));
    $primaryLabel = trim((string) ($attributes['data-primary-label'] ?? 'Commencer'));
    $secondaryLabel = trim((string) ($attributes['data-secondary-label'] ?? 'Découvrir'));
    $primaryUrl = $sanitizeUrl($attributes['data-primary-url'] ?? '#', '#');
    $secondaryUrl = $sanitizeUrl($attributes['data-secondary-url'] ?? '#', '#');
    $imageUrl = $sanitizeUrl($attributes['data-image-url'] ?? '', '');
@endphp

<section @if($componentId) id="{{ $componentId }}" @endif @class($classes) @if($styleString) style="{{ $styleString }}" @endif>
    <div class="card-body p-4 p-lg-5">
        @if($badge !== '')
            <span class="badge text-bg-light mb-2">{{ $badge }}</span>
        @endif

        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                @if($title !== '')
                    <h2 class="display-6 fw-bold mb-3">{{ $title }}</h2>
                @endif

                @if($subtitle !== '')
                    <p class="lead mb-4">{{ $subtitle }}</p>
                @endif

                <div class="d-flex flex-wrap gap-2">
                    @if($primaryLabel !== '')
                        <a href="{{ $primaryUrl }}" class="btn btn-primary">{{ $primaryLabel }}</a>
                    @endif

                    @if($secondaryLabel !== '')
                        <a href="{{ $secondaryUrl }}" class="btn btn-outline-light">{{ $secondaryLabel }}</a>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                @if($imageUrl !== '')
                    <img src="{{ $imageUrl }}" alt="{{ $title !== '' ? $title : site_name() }}" class="img-fluid rounded-3 border">
                @endif
            </div>
        </div>
    </div>
</section>
