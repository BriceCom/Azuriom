@php
    $resolvedTag = trim((string) ($tag ?? 'section'));
    if (!preg_match('/^[a-z][a-z0-9:_-]*$/i', $resolvedTag)) {
        $resolvedTag = 'section';
    }

    $resolvedBlockId = trim((string) ($blockId ?? ''));
    $resolvedClass = trim((string) ($class ?? ''));
    $resolvedAos = trim((string) ($params['aos'] ?? 'none'));
    $useAos = $resolvedAos !== '' && $resolvedAos !== 'none';
@endphp

<{{ $resolvedTag }}
    @if($resolvedBlockId !== '')
        data-te-block="{{ $resolvedBlockId }}"
    @endif
    @if($useAos)
        data-aos="{{ $resolvedAos }}"
    @endif
    @if($resolvedClass !== '')
        class="{{ $resolvedClass }}"
    @endif
>
    {{ $slot }}
</{{ $resolvedTag }}>
