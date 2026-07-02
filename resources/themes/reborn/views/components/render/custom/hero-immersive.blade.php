@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $badge = trim((string) ($settings['badge'] ?? ''));
    $title = trim((string) ($settings['title'] ?? ''));
    $subtitle = trim((string) ($settings['subtitle'] ?? ''));
    $backgroundUrl = trim((string) ($settings['background_url'] ?? ''));
    $primaryLabel = trim((string) ($settings['primary_label'] ?? ''));
    $primaryUrl = trim((string) ($settings['primary_url'] ?? '#'));
    $secondaryLabel = trim((string) ($settings['secondary_label'] ?? ''));
    $secondaryUrl = trim((string) ($settings['secondary_url'] ?? '#'));
@endphp

<section class="reborn-hero-immersive" @if($backgroundUrl !== '') style="--reborn-hero-bg:url('{{ e($backgroundUrl) }}');" @endif>
    <div class="reborn-hero-overlay"></div>
    <div class="container reborn-hero-content">
        @if($badge !== '')
            <span class="badge text-bg-light mb-3">{{ $badge }}</span>
        @endif
        @if($title !== '')
            <h1 class="display-4 fw-bold mb-3">{{ $title }}</h1>
        @endif
        @if($subtitle !== '')
            <p class="lead mb-4">{{ $subtitle }}</p>
        @endif
        <div class="d-flex flex-wrap gap-2">
            @if($primaryLabel !== '')
                <a href="{{ $primaryUrl }}" class="btn btn-primary btn-lg">{{ $primaryLabel }}</a>
            @endif
            @if($secondaryLabel !== '')
                <a href="{{ $secondaryUrl }}" class="btn btn-outline-light btn-lg">{{ $secondaryLabel }}</a>
            @endif
        </div>
    </div>
</section>
