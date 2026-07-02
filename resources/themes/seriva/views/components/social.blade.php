@props([
    'link' => null
])

@if($link)
    <li>
        <a href="{{ $link->value }}" target="_blank" rel="noopener noreferrer"
           class="btn btn-outline-primary seriva-social-btn"
           style="color: {{ $link->color }}; border-color: {{ $link->color }};">
            <i class="d-flex {{ $link->icon }} text-xl"></i>
        </a>
    </li>
@endif
