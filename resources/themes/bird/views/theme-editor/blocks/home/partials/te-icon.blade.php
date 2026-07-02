@php
    $resolvedIcon = trim((string) ($icon ?? ''));
    if ($resolvedIcon === '') {
        $resolvedIcon = '★';
    }

    $isBootstrapIcon = preg_match('/(^|\s)bi(\s|$)/', $resolvedIcon) === 1;
@endphp

@if($isBootstrapIcon)
    <i class="{{ $resolvedIcon }}" aria-hidden="true"></i>
@else
    {{ $resolvedIcon }}
@endif
