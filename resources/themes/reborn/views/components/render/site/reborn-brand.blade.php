@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $showLogo = (bool) ($settings['show_logo'] ?? true);
    $showName = (bool) ($settings['show_name'] ?? true);
    $tagline = trim((string) ($settings['tagline'] ?? ''));
@endphp

<a href="{{ route('home') }}" class="reborn-brand-link">
    @if($showLogo)
        <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="reborn-brand-logo">
    @endif
    <span class="reborn-brand-text">
        @if($showName)
            <span class="reborn-brand-name">{{ site_name() }}</span>
        @endif
        @if($tagline !== '')
            <span class="reborn-brand-tagline">{{ $tagline }}</span>
        @endif
    </span>
</a>
