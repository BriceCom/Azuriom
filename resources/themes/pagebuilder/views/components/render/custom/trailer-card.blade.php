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
        $classes = ['card', 'border-0', 'shadow-sm', 'overflow-hidden'];
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

    $title = trim((string) ($attributes['data-title'] ?? 'Trailer du serveur'));
    $text = trim((string) ($attributes['data-text'] ?? ''));
    $videoUrl = $sanitizeUrl($attributes['data-video-url'] ?? '#', '#');
    $posterUrl = $sanitizeUrl($attributes['data-poster-url'] ?? '', '');
    $buttonLabel = trim((string) ($attributes['data-button-label'] ?? 'Voir la vidéo'));
@endphp

<section @if($componentId) id="{{ $componentId }}" @endif @class($classes) @if($styleString) style="{{ $styleString }}" @endif>
    @if($posterUrl !== '')
        <img src="{{ $posterUrl }}" alt="{{ $title !== '' ? $title : site_name() }}" class="w-100" style="height: 220px; object-fit: cover;">
    @endif

    <div class="card-body p-4">
        @if($title !== '')
            <h2 class="h4 mb-2">{{ $title }}</h2>
        @endif

        @if($text !== '')
            <p class="text-muted mb-3">{{ $text }}</p>
        @endif

        @if($buttonLabel !== '')
            <a href="{{ $videoUrl }}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-play-fill"></i> {{ $buttonLabel }}
            </a>
        @endif
    </div>
</section>
