@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $height = max(0, min(400, (int) ($settings['height'] ?? 48)));
    $heightMobile = max(0, min(400, (int) ($settings['height_mobile'] ?? 24)));
@endphp

<div class="reborn-spacer" style="--reborn-spacer-height: {{ $height }}px; --reborn-spacer-height-mobile: {{ $heightMobile }}px;"></div>
