@php
    $attributes = $component['attributes'] ?? [];
    $classes = $component['classes'] ?? [];
    $components = $component['components'] ?? [];
    $style = $component['style'] ?? [];
    $context = is_array($context ?? null) ? $context : [];

    $id = $attributes['id'] ?? '';
    $cleanClasses = array_filter($classes, function($class) {
        return !empty($class) && is_string($class);
    });

    $styleString = '';
    if (!empty($style)) {
        $styleString = collect($style)->map(fn($value, $prop) => e($prop) . ':' . e($value))->implode(';');
    }
@endphp

<div
    @if($id) id="{{ e($id) }}" @endif
    @class($cleanClasses)
    @if($styleString) style="{{ $styleString }}" @endif
>
    @if(!empty($components))
        @foreach($components as $childComponent)
            {{-- Skip placeholder components --}}
            @if(!isset($childComponent['attributes']['data-gjs-placeholder']))
                <x-render-component :component="$childComponent" :context="$context" />
            @endif
        @endforeach
    @endif
</div>
