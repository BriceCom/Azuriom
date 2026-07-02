@php
    $attributes = $component['attributes'] ?? [];
    $classes = $component['classes'] ?? [];
    $components = $component['components'] ?? [];
    $style = $component['style'] ?? [];
    $content = $component['content'] ?? '';

    $id = $attributes['id'] ?? '';
    $href = $attributes['href'] ?? '#';
    $target = $attributes['target'] ?? '';

    $cleanClasses = array_filter($classes, function($class) {
        return !empty($class) && is_string($class);
    });

    $styleString = '';
    if (!empty($style)) {
        $styleString = collect($style)->map(fn($value, $prop) => e($prop) . ':' . e($value))->implode(';');
    }

    // Get button text from components or content
    $buttonText = '';
    if (!empty($components)) {
        foreach ($components as $childComponent) {
            if (($childComponent['type'] ?? '') === 'textnode') {
                $buttonText .= $childComponent['content'] ?? '';
            }
        }
    } else {
        $buttonText = $content;
    }

    // Fallback button text
    if (empty($buttonText)) {
        $buttonText = 'Button';
    }
@endphp

@if(!empty($href) && $href !== '#')
    <a
        @if($id) id="{{ e($id) }}" @endif
        href="{{ e($href) }}"
        @if($target) target="{{ e($target) }}" @endif
        @class($cleanClasses)
        @if($styleString) style="{{ $styleString }}" @endif
    >
        {!! e($buttonText) !!}
    </a>
@else
    <button
        @if($id) id="{{ e($id) }}" @endif
        type="button"
        @class($cleanClasses)
        @if($styleString) style="{{ $styleString }}" @endif
    >
        {!! e($buttonText) !!}
    </button>
@endif
