@php
    $allowedVariants = ['server', 'primary', 'secondary', 'tertiary', 'quaternary'];
    $resolvedVariant = in_array($variant ?? null, $allowedVariants, true) ? $variant : 'primary';
    $resolvedServerAddress = trim((string) ($serverAddress ?? ''));
    $resolvedText = trim((string) ($text ?? ''));
    $resolvedUrl = trim((string) ($url ?? ''));

    $resolvedVariantClass = match ($resolvedVariant) {
        'secondary' => 'btn-secondary',
        'tertiary' => 'btn-tertiary',
        'quaternary' => 'btn-quaternary',
        'server' => 'btn-server',
        default => 'btn-primary',
    };

    $resolvedTextOutput = $resolvedVariant === 'server'
        ? ($resolvedServerAddress !== '' ? $resolvedServerAddress : 'Serveur indisponible')
        : ($resolvedText !== '' ? $resolvedText : 'En savoir plus');
    $resolvedUrlOutput = $resolvedVariant === 'server'
        ? '#'
        : ($resolvedUrl !== '' ? $resolvedUrl : '#');
@endphp

<a
    href="{{ $resolvedUrlOutput }}"
    class="btn {{ $resolvedVariantClass }}"
    data-te-param="{{ $paramTextKey }}"
    data-te-param-href="{{ $paramUrlKey }}"
    data-te-node="{{ $nodeKey }}"
    data-te-server-ip="{{ $resolvedServerAddress }}"
    data-te-button-variant="{{ $resolvedVariant }}"
    @if($resolvedVariant === 'server')
        data-copyboard="true"
        data-copyboard-text="{{ $resolvedServerAddress }}"
        data-bs-toggle="tooltip"
        data-bs-title="Copié !"
    @endif
>
    {{ $resolvedTextOutput }}
</a>
