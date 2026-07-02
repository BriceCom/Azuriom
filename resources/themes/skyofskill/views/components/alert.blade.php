@props([
    'class' => null,
    'type' => 'info',
    'message' => '',
    'href' => false,
    'target' => false,
    'hrefText' => false,
    'icon' => false,
    'baseClass' => 'd-flex align-items-center gap-4 border-0 text-body mb-0'
])


@if($href)
    <a href="{{ $href }}" target="{{ $target }}" class="alert alert-{{ $type }} {{ $baseClass }} {{ $class }} text-decoration-none anim-hover-up">
        @if($icon) <i class="{{$icon}} text-xxl mb-0"></i> @endif
        <div class="wysiwyg no-margin"> {!! $message !!}</div>
    </a>
@else
    <div class="alert alert-{{ $type }} {{ $baseClass }} {{ $class }}">
        @if($icon) <i class="{{$icon}} text-xxl mb-0"></i> @endif
        <div class="wysiwyg no-margin"> {!! $message !!}</div>
    </div>
@endif
