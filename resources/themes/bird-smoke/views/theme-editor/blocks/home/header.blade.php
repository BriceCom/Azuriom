@php
    $sticky = !empty($params['sticky']);
    $buttonStyles = is_array($params['button_styles'] ?? null)
        ? array_values(array_filter($params['button_styles'], static fn ($item) => is_array($item)))
        : [];
    $serverAddress = trim((string) theme_config('global.server_address', ''));
@endphp

<header data-te-block="header" data-te-node="layout-header" @if($sticky) class="sticky-top" @endif>
    <div
        data-te-node="layout-header-shell"
        data-te-header-button-rules='@json($buttonStyles)'
        data-te-server-address="{{ $serverAddress }}"
    >
        @include('elements.navbar')
    </div>
</header>
