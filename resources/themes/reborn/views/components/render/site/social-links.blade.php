@php
    $componentAttributes = is_array($component['attributes'] ?? null) ? $component['attributes'] : [];
    $componentClasses = collect($component['classes'] ?? [])
        ->filter(fn ($className) => is_string($className) && trim($className) !== '')
        ->values()
        ->all();
    $componentStyles = is_array($component['style'] ?? null) ? $component['style'] : [];
    $componentId = isset($componentAttributes['id']) && is_string($componentAttributes['id']) ? $componentAttributes['id'] : null;
    $componentStyleString = collect($componentStyles)
        ->filter(fn ($value, $property) => is_string($property) && is_scalar($value) && trim((string) $value) !== '')
        ->map(fn ($value, $property) => $property.':'.trim((string) $value))
        ->implode(';');
@endphp

<div @if($componentId) id="{{ $componentId }}" @endif @class($componentClasses) @if($componentStyleString) style="{{ $componentStyleString }}" @endif>
    <div class="d-flex flex-wrap justify-content-center gap-2">
        @foreach(social_links() as $link)
            <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
               data-bs-toggle="tooltip"
               class="d-inline-flex align-items-center justify-content-center rounded-circle"
               style="width: 40px; height: 40px; background: {{ $link->color }};">
                <i class="{{ $link->icon }} text-white"></i>
            </a>
        @endforeach
    </div>
</div>
