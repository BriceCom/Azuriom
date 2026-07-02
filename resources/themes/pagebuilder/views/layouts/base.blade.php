<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">


    <!-- Scripts -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    @stack('styles')

    @php
        $themeMode = 'light';
        $themeStyles = '';
        $globalSectionsCss = '';
        $globalHeaderComponents = [];
        $globalFooterComponents = [];
        $savedTheme = setting('themes.config.pagebuilder')['styles'] ?? null;
        $themeData = is_string($savedTheme) ? json_decode($savedTheme, true) : (is_array($savedTheme) ? $savedTheme : null);
        $pagebuilderRaw = setting('themes.config.pagebuilder')['pagebuilder'] ?? null;
        $pagebuilderConfig = is_string($pagebuilderRaw) ? json_decode($pagebuilderRaw, true) : (is_array($pagebuilderRaw) ? $pagebuilderRaw : null);

        $isComponentMap = static function ($value): bool {
            if (!is_array($value)) {
                return false;
            }

            if ($value === []) {
                return true;
            }

            foreach ($value as $component) {
                if (!is_array($component)) {
                    return false;
                }

                if (!isset($component['type']) && !isset($component['tagName']) && !isset($component['components']) && !isset($component['content'])) {
                    return false;
                }
            }

            return true;
        };

        $normalizeGlobalTemplate = static function ($entry) use ($isComponentMap) {
            if ($isComponentMap($entry)) {
                return [
                    'components' => $entry,
                    'css' => '',
                ];
            }

            if (!is_array($entry)) {
                return null;
            }

            $components = $entry['components'] ?? null;
            if ($isComponentMap($components)) {
                return [
                    'components' => $components,
                    'css' => is_string($entry['css'] ?? null) ? $entry['css'] : '',
                ];
            }

            $snapshotComponents = $entry['last_snapshot']['components'] ?? null;
            if ($isComponentMap($snapshotComponents)) {
                return [
                    'components' => $snapshotComponents,
                    'css' => is_string($entry['last_snapshot']['css'] ?? null) ? $entry['last_snapshot']['css'] : '',
                ];
            }

            return null;
        };

        if (is_array($pagebuilderConfig)) {
            $globalSections = $pagebuilderConfig['global_sections'] ?? null;

            if (is_array($globalSections)) {
                $resolveGlobalTemplate = static function ($bucket) use ($normalizeGlobalTemplate) {
                    if (!is_array($bucket)) {
                        return null;
                    }

                    $templates = is_array($bucket['templates'] ?? null) ? $bucket['templates'] : [];
                    $activeId = is_string($bucket['active_id'] ?? null) ? $bucket['active_id'] : null;

                    if ($activeId && isset($templates[$activeId])) {
                        return $normalizeGlobalTemplate($templates[$activeId]);
                    }

                    foreach ($templates as $template) {
                        $normalized = $normalizeGlobalTemplate($template);
                        if ($normalized !== null) {
                            return $normalized;
                        }
                    }

                    return null;
                };

                $headerTemplate = $resolveGlobalTemplate($globalSections['headers'] ?? null);
                $footerTemplate = $resolveGlobalTemplate($globalSections['footers'] ?? null);

                if ($headerTemplate !== null) {
                    $globalHeaderComponents = $headerTemplate['components'];
                    $globalSectionsCss .= $headerTemplate['css'] ?? '';
                }

                if ($footerTemplate !== null) {
                    $globalFooterComponents = $footerTemplate['components'];
                    $footerCss = $footerTemplate['css'] ?? '';
                    if ($footerCss !== '') {
                        $globalSectionsCss .= ($globalSectionsCss !== '' ? "\n" : '') . $footerCss;
                    }
                }
            }
        }

        if (is_array($themeData)) {
            $themeMode = (($themeData['mode'] ?? 'light') === 'dark') ? 'dark' : 'light';
            $variantNames = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];
            $defaultColors = [
                'primary' => '#0d6efd',
                'secondary' => '#6c757d',
                'success' => '#198754',
                'info' => '#0dcaf0',
                'warning' => '#ffc107',
                'danger' => '#dc3545',
                'light' => '#f8f9fa',
                'dark' => '#212529',
                'body' => '#ffffff',
                'text' => '#212529',
            ];

            $legacyColors = is_array($themeData['colors'] ?? null) ? $themeData['colors'] : [];
            $colorsLight = array_merge(
                $defaultColors,
                is_array($themeData['colorsLight'] ?? null) ? $themeData['colorsLight'] : $legacyColors
            );
            $colorsDark = array_merge(
                $defaultColors,
                is_array($themeData['colorsDark'] ?? null) ? $themeData['colorsDark'] : $legacyColors
            );
            $themeBasics = is_array($themeData['basics'] ?? null) ? $themeData['basics'] : [];
            $clampNumber = static function ($value, float $default, float $min, float $max): float {
                if (!is_numeric($value)) {
                    return $default;
                }

                $numeric = (float) $value;

                if ($numeric < $min) {
                    return $min;
                }

                if ($numeric > $max) {
                    return $max;
                }

                return $numeric;
            };
            $buttonPaddingY = $clampNumber($themeBasics['buttonPaddingY'] ?? null, 6.0, 0.0, 32.0);
            $buttonPaddingX = $clampNumber($themeBasics['buttonPaddingX'] ?? null, 12.0, 0.0, 48.0);
            $buttonFontWeight = $clampNumber($themeBasics['buttonFontWeight'] ?? null, 400.0, 100.0, 900.0);
            $cardPaddingY = $clampNumber($themeBasics['cardPaddingY'] ?? null, 16.0, 0.0, 64.0);
            $cardPaddingX = $clampNumber($themeBasics['cardPaddingX'] ?? null, 16.0, 0.0, 64.0);
            $tablePaddingY = $clampNumber($themeBasics['tablePaddingY'] ?? null, 8.0, 0.0, 32.0);
            $tablePaddingX = $clampNumber($themeBasics['tablePaddingX'] ?? null, 8.0, 0.0, 32.0);
            $buttonRadius = $clampNumber($themeData['buttons']['radius'] ?? null, 6.0, 0.0, 64.0);
            $themeForms = is_array($themeData['forms'] ?? null) ? $themeData['forms'] : [];
            $themeNavigation = is_array($themeData['navigation'] ?? null) ? $themeData['navigation'] : [];
            $themeEffects = is_array($themeData['effects'] ?? null) ? $themeData['effects'] : [];
            $themeLinks = is_array($themeData['links'] ?? null) ? $themeData['links'] : [];
            $formControlRadius = $clampNumber($themeForms['controlRadius'] ?? null, 4.0, 0.0, 64.0);
            $formControlPaddingY = $clampNumber($themeForms['controlPaddingY'] ?? null, 0.5, 0.0, 2.0);
            $formControlPaddingX = $clampNumber($themeForms['controlPaddingX'] ?? null, 0.75, 0.0, 3.0);
            $focusRingOpacity = $clampNumber($themeForms['focusRingOpacity'] ?? null, 0.25, 0.0, 0.8);
            $navLinkPaddingY = $clampNumber($themeNavigation['navLinkPaddingY'] ?? null, 0.5, 0.0, 2.0);
            $navLinkPaddingX = $clampNumber($themeNavigation['navLinkPaddingX'] ?? null, 0.75, 0.0, 3.0);
            $alertRadius = $clampNumber($themeNavigation['alertRadius'] ?? null, 6.0, 0.0, 64.0);
            $badgeRadius = $clampNumber($themeNavigation['badgeRadius'] ?? null, 4.0, 0.0, 64.0);
            $listGroupRadius = $clampNumber($themeNavigation['listGroupRadius'] ?? null, 4.0, 0.0, 64.0);
            $cardShadowLevel = (int) $clampNumber($themeEffects['cardShadowLevel'] ?? null, 1.0, 0.0, 3.0);
            $buttonShadowLevel = (int) $clampNumber($themeEffects['buttonShadowLevel'] ?? null, 0.0, 0.0, 3.0);
            $cardShadows = [
                'none',
                '0 .125rem .25rem rgba(0, 0, 0, .075)',
                '0 .5rem 1rem rgba(0, 0, 0, .12)',
                '0 1rem 2.5rem rgba(0, 0, 0, .18)',
            ];
            $buttonShadows = [
                'none',
                '0 .125rem .25rem rgba(0, 0, 0, .10)',
                '0 .35rem .8rem rgba(0, 0, 0, .16)',
                '0 .75rem 1.4rem rgba(0, 0, 0, .2)',
            ];
            $sanitizeHexColor = static function ($value, string $fallback): string {
                if (!is_string($value)) {
                    return $fallback;
                }

                $color = trim($value);
                if (preg_match('/^#[0-9a-fA-F]{3}$/', $color) === 1 || preg_match('/^#[0-9a-fA-F]{6}$/', $color) === 1) {
                    return $color;
                }

                return $fallback;
            };
            $linkColor = $sanitizeHexColor($themeLinks['color'] ?? null, $defaultColors['primary']);
            $linkHoverColor = $sanitizeHexColor($themeLinks['hoverColor'] ?? null, $linkColor);

            $buttonTextColors = [
                'primary' => '#ffffff',
                'secondary' => '#ffffff',
                'success' => '#ffffff',
                'info' => '#000000',
                'warning' => '#000000',
                'danger' => '#ffffff',
                'light' => '#000000',
                'dark' => '#ffffff',
            ];

            $toRgb = static function (string $hex): string {
                $normalized = ltrim(trim($hex), '#');

                if (preg_match('/^[0-9a-fA-F]{3}$/', $normalized) === 1) {
                    return implode(', ', [
                        hexdec(str_repeat($normalized[0], 2)),
                        hexdec(str_repeat($normalized[1], 2)),
                        hexdec(str_repeat($normalized[2], 2)),
                    ]);
                }

                if (preg_match('/^[0-9a-fA-F]{6}$/', $normalized) === 1) {
                    return implode(', ', [
                        hexdec(substr($normalized, 0, 2)),
                        hexdec(substr($normalized, 2, 2)),
                        hexdec(substr($normalized, 4, 2)),
                    ]);
                }

                return '13, 110, 253';
            };

            $buildVars = static function (array $colors) use ($variantNames, $toRgb, $buttonPaddingY, $buttonPaddingX, $buttonFontWeight, $cardPaddingY, $cardPaddingX, $tablePaddingY, $tablePaddingX, $buttonRadius, $formControlRadius, $formControlPaddingY, $formControlPaddingX, $focusRingOpacity, $navLinkPaddingY, $navLinkPaddingX, $alertRadius, $badgeRadius, $listGroupRadius, $cardShadows, $buttonShadows, $cardShadowLevel, $buttonShadowLevel, $linkColor, $linkHoverColor): string {
                $vars = [];

                foreach ($variantNames as $name) {
                    $value = $colors[$name];
                    $vars[] = "--bs-{$name}: {$value}";
                    $vars[] = "--bs-{$name}-rgb: " . $toRgb($value);
                }

                $vars[] = '--bs-body-bg: ' . $colors['body'];
                $vars[] = '--bs-body-color: ' . $colors['text'];
                $vars[] = '--bs-link-color: ' . ($linkColor ?: $colors['primary']);
                $vars[] = '--bs-link-hover-color: ' . ($linkHoverColor ?: $colors['primary']);
                $vars[] = '--bs-btn-radius: ' . $buttonRadius . 'px';
                $vars[] = '--pb-btn-padding-y: ' . $buttonPaddingY . 'px';
                $vars[] = '--pb-btn-padding-x: ' . $buttonPaddingX . 'px';
                $vars[] = '--pb-btn-font-weight: ' . $buttonFontWeight;
                $vars[] = '--pb-card-padding-y: ' . $cardPaddingY . 'px';
                $vars[] = '--pb-card-padding-x: ' . $cardPaddingX . 'px';
                $vars[] = '--pb-table-padding-y: ' . $tablePaddingY . 'px';
                $vars[] = '--pb-table-padding-x: ' . $tablePaddingX . 'px';
                $vars[] = '--pb-form-control-radius: ' . $formControlRadius . 'px';
                $vars[] = '--pb-form-control-padding-y: ' . $formControlPaddingY . 'rem';
                $vars[] = '--pb-form-control-padding-x: ' . $formControlPaddingX . 'rem';
                $vars[] = '--pb-focus-ring-opacity: ' . $focusRingOpacity;
                $vars[] = '--pb-nav-link-padding-y: ' . $navLinkPaddingY . 'rem';
                $vars[] = '--pb-nav-link-padding-x: ' . $navLinkPaddingX . 'rem';
                $vars[] = '--pb-alert-radius: ' . $alertRadius . 'px';
                $vars[] = '--pb-badge-radius: ' . $badgeRadius . 'px';
                $vars[] = '--pb-list-group-radius: ' . $listGroupRadius . 'px';
                $vars[] = '--pb-card-shadow: ' . ($cardShadows[$cardShadowLevel] ?? 'none');
                $vars[] = '--pb-btn-shadow: ' . ($buttonShadows[$buttonShadowLevel] ?? 'none');

                return implode('; ', $vars);
            };

            $themeStyles = ':root,[data-bs-theme="light"]{' . $buildVars($colorsLight) . ';}';
            $themeStyles .= '[data-bs-theme="dark"]{' . $buildVars($colorsDark) . ';}';
            $themeStyles .= 'body{background-color:var(--bs-body-bg);color:var(--bs-body-color);}';
            $themeStyles .= 'a{color:var(--bs-link-color);}a:hover{color:var(--bs-link-hover-color);}';
            $themeStyles .= '.btn{border-radius:var(--bs-btn-radius)!important;--bs-btn-padding-y:var(--pb-btn-padding-y);--bs-btn-padding-x:var(--pb-btn-padding-x);--bs-btn-font-weight:var(--pb-btn-font-weight);padding:var(--pb-btn-padding-y) var(--pb-btn-padding-x)!important;font-weight:var(--pb-btn-font-weight)!important;box-shadow:var(--pb-btn-shadow);}';
            $themeStyles .= '.card{--bs-card-spacer-y:var(--pb-card-padding-y);--bs-card-spacer-x:var(--pb-card-padding-x);box-shadow:var(--pb-card-shadow);}';
            $themeStyles .= '.card-body{padding:var(--pb-card-padding-y) var(--pb-card-padding-x)!important;}';
            $themeStyles .= '.form-control,.form-select,.input-group-text{border-radius:var(--pb-form-control-radius)!important;}';
            $themeStyles .= '.form-control,.form-select{padding:var(--pb-form-control-padding-y) var(--pb-form-control-padding-x)!important;}';
            $themeStyles .= '.form-control:focus,.form-select:focus,.btn:focus,.btn:focus-visible{box-shadow:0 0 0 .25rem rgba(var(--bs-primary-rgb),var(--pb-focus-ring-opacity))!important;}';
            $themeStyles .= '.table{--bs-table-cell-padding-y:var(--pb-table-padding-y);--bs-table-cell-padding-x:var(--pb-table-padding-x);}';
            $themeStyles .= '.table>:not(caption)>*>*,.table th,.table td{padding:var(--pb-table-padding-y) var(--pb-table-padding-x)!important;}';
            $themeStyles .= '.nav-link,.navbar-nav .nav-link{padding:var(--pb-nav-link-padding-y) var(--pb-nav-link-padding-x)!important;}';
            $themeStyles .= '.alert{border-radius:var(--pb-alert-radius)!important;}';
            $themeStyles .= '.badge{border-radius:var(--pb-badge-radius)!important;}';
            $themeStyles .= '.list-group{--bs-list-group-active-bg:var(--bs-primary);--bs-list-group-active-border-color:var(--bs-primary);--bs-list-group-active-color:#fff;border-radius:var(--pb-list-group-radius);}';
            $themeStyles .= '.list-group>.list-group-item:first-child{border-top-left-radius:var(--pb-list-group-radius);border-top-right-radius:var(--pb-list-group-radius);}';
            $themeStyles .= '.list-group>.list-group-item:last-child{border-bottom-left-radius:var(--pb-list-group-radius);border-bottom-right-radius:var(--pb-list-group-radius);}';

            foreach ($variantNames as $variant) {
                $textColor = $buttonTextColors[$variant] ?? '#ffffff';
                $themeStyles .= ".btn-{$variant}{--bs-btn-color:{$textColor};--bs-btn-bg:var(--bs-{$variant});--bs-btn-border-color:var(--bs-{$variant});--bs-btn-hover-color:{$textColor};--bs-btn-hover-bg:color-mix(in srgb,var(--bs-{$variant}) 85%,#000);--bs-btn-hover-border-color:color-mix(in srgb,var(--bs-{$variant}) 80%,#000);--bs-btn-active-color:{$textColor};--bs-btn-active-bg:color-mix(in srgb,var(--bs-{$variant}) 78%,#000);--bs-btn-active-border-color:color-mix(in srgb,var(--bs-{$variant}) 72%,#000);}";
                $themeStyles .= ".btn-outline-{$variant}{--bs-btn-color:var(--bs-{$variant});--bs-btn-border-color:var(--bs-{$variant});--bs-btn-hover-color:{$textColor};--bs-btn-hover-bg:var(--bs-{$variant});--bs-btn-hover-border-color:var(--bs-{$variant});--bs-btn-active-color:{$textColor};--bs-btn-active-bg:var(--bs-{$variant});--bs-btn-active-border-color:var(--bs-{$variant});}";
                $themeStyles .= ".text-{$variant}{color:var(--bs-{$variant}) !important;}.bg-{$variant}{background-color:var(--bs-{$variant}) !important;}.border-{$variant}{border-color:var(--bs-{$variant}) !important;}.text-bg-{$variant}{background-color:var(--bs-{$variant}) !important;color:{$textColor} !important;}";
                $themeStyles .= ".alert-{$variant}{--bs-alert-color:color-mix(in srgb,var(--bs-{$variant}) 50%,#000);--bs-alert-bg:color-mix(in srgb,var(--bs-{$variant}) 14%,transparent);--bs-alert-border-color:color-mix(in srgb,var(--bs-{$variant}) 35%,transparent);}";
            }
        }
    @endphp

    @if($themeStyles)
        <style>
            {!! $themeStyles !!}
        </style>
    @endif

    @if(!empty($globalSectionsCss))
        <style>
            {!! $globalSectionsCss !!}
        </style>
    @endif

    <style>
        html,
        body {
            height: 100%;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body data-bs-theme="{{ $themeMode }}">
<div id="app">
    @if(!empty($globalHeaderComponents))
        <header data-pagebuilder-global="header">
            @foreach($globalHeaderComponents as $globalHeaderComponent)
                <x-render-component :component="$globalHeaderComponent" :context="[]" />
            @endforeach
        </header>
    @else
        <header>@include('elements.navbar')</header>
    @endif

    @yield('app')

    @auth
        @if(auth()->user()->isAdmin())
            @include('components.builder.builder')
        @endif
    @endauth
</div>

@if(!empty($globalFooterComponents))
    <footer data-pagebuilder-global="footer">
        @foreach($globalFooterComponents as $globalFooterComponent)
            <x-render-component :component="$globalFooterComponent" :context="[]" />
        @endforeach
    </footer>
@else
    <footer class="text-center text-bg-dark mt-auto py-4">
        <div class="copyright">
            <div class="container">
                <p>{{ setting('copyright') }} | @lang('messages.copyright')</p>

                @foreach(social_links() as $link)
                    <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                       data-bs-toggle="tooltip"
                       class="d-inline-block mx-1 p-2 rounded-circle" style="background: {{ $link->color }}">
                        <i class="{{ $link->icon }} text-white"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </footer>
@endif

@stack('footer-scripts')
</body>

</html>
