@props([
    'link' => null
])

@if($link)
    <li>
        <a href="{{ $link->value }}" target="_blank" rel="noopener noreferrer"
           class="social text-decoration-none"
           style="--di-btn-color: {{ $link->color }}; --di-btn-color-rgb: {{ color_rgb($link->color) }};}">
            <i class="d-flex {{ $link->icon }} text-xl"></i>
        </a>
    </li>
@endif
