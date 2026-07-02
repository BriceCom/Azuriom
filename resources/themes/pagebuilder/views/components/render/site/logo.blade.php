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
    $hasCustomHeight = isset($componentStyles['height']) && is_scalar($componentStyles['height']) && trim((string) $componentStyles['height']) !== '';
@endphp

<div @if($componentId) id="{{ $componentId }}" @endif @class($componentClasses) @if($componentStyleString) style="{{ $componentStyleString }}" @endif>
    <a href="{{ route('home') }}" class="d-inline-block w-100">
        <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" class="w-100 object-fit-contain @if($hasCustomHeight) h-100 @endif"
             @if(!$hasCustomHeight) height="{{ theme_config('header.index.hero.img.height') ?? 100 }}" @endif
             draggable="false">
    </a>
</div>
