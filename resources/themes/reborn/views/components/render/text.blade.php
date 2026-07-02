@php
    $attributes = $component['attributes'] ?? [];
    $classes = $component['classes'] ?? [];
    $components = $component['components'] ?? [];
    $style = $component['style'] ?? [];
    $content = $component['content'] ?? '';
    $tagName = $component['tagName'] ?? 'p';

    $id = $attributes['id'] ?? '';
    $cleanClasses = array_filter($classes, function($class) {
        return !empty($class) && is_string($class);
    });

    $styleString = '';
    if (!empty($style)) {
        $styleString = collect($style)->map(fn($value, $prop) => e($prop) . ':' . e($value))->implode(';');
    }

    // Get text content from components or content
    $textContent = '';
    if (!empty($components)) {
        foreach ($components as $childComponent) {
            if (($childComponent['type'] ?? '') === 'textnode') {
                $textContent .= $childComponent['content'] ?? '';
            }
        }
    } else {
        $textContent = $content;
    }
@endphp

@switch($tagName)
    @case('h1')
        <h1
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </h1>
        @break

    @case('h2')
        <h2
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </h2>
        @break

    @case('h3')
        <h3
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </h3>
        @break

    @case('h4')
        <h4
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </h4>
        @break

    @case('h5')
        <h5
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </h5>
        @break

    @case('h6')
        <h6
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </h6>
        @break

    @case('div')
        <div
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </div>
        @break

    @default
        {{-- Default to paragraph --}}
        <p
            @if($id) id="{{ e($id) }}" @endif
            @class($cleanClasses)
            @if($styleString) style="{{ $styleString }}" @endif
        >
            {!! e($textContent) !!}
        </p>
@endswitch
