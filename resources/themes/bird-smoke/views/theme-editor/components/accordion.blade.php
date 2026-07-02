@php
    $accordionTitle = $title ?? '';
    $accordionOpen = $open ?? false;
    $accordionClass = trim('te-accordion '.($class ?? ''));
    $accordionSummaryClass = trim('te-accordion-summary '.($summaryClass ?? ''));
    $accordionContentClass = trim('te-accordion-content '.($contentClass ?? ''));
@endphp

<details class="{{ $accordionClass }}" @if($accordionOpen) open @endif>
    <summary class="{{ $accordionSummaryClass }}">
        <span class="te-accordion-title">{{ $accordionTitle }}</span>
    </summary>
    <div class="{{ $accordionContentClass }}">
        {{ $slot }}
    </div>
</details>
