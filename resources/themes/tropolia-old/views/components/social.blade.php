@props([
    'link' => null
])

@if($link)
    <li>
        <a href="{{ $link->value }}" target="_blank" rel="noopener noreferrer"
           class="btn btn-icon btn-currentColor" style="--di-btn-color: {{ $link->color }}; --di-btn-color-hsl: {{ hexToHSL($link->color) }}">
            <i class="d-flex {{ $link->icon }} text-xl"></i>
        </a>
    </li>
@endif
