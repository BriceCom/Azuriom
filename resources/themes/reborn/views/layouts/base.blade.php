<!DOCTYPE html>
@include('elements.base')
@php
    $rebornRawComposer = setting('themes.config.reborn')['composer'] ?? null;
    $rebornComposer = [];

    if (is_string($rebornRawComposer)) {
        $rebornComposer = json_decode($rebornRawComposer, true) ?: [];
    } elseif (is_array($rebornRawComposer)) {
        $rebornComposer = $rebornRawComposer;
    }

    $rebornDefaultColorsLight = [
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

    $rebornDefaultColorsDark = [
        'primary' => '#6ea8fe',
        'secondary' => '#adb5bd',
        'success' => '#75b798',
        'info' => '#6edff6',
        'warning' => '#ffda6a',
        'danger' => '#ea868f',
        'light' => '#f8f9fa',
        'dark' => '#dee2e6',
        'body' => '#111827',
        'text' => '#f1f5f9',
    ];

    $rebornTheme = is_array($rebornComposer['theme'] ?? null) ? $rebornComposer['theme'] : [];
    $rebornHeader = is_array($rebornTheme['header'] ?? null) ? $rebornTheme['header'] : [];
    $rebornFooter = is_array($rebornTheme['footer'] ?? null) ? $rebornTheme['footer'] : [];
    $rebornBootstrap = is_array($rebornTheme['bootstrap'] ?? null) ? $rebornTheme['bootstrap'] : [];

    $rebornClamp = static function ($value, float $default, float $min, float $max): float {
        if (!is_numeric($value)) {
            return $default;
        }

        $value = (float) $value;
        if ($value < $min) {
            return $min;
        }
        if ($value > $max) {
            return $max;
        }

        return $value;
    };

    $rebornSanitizeHex = static function ($value, string $fallback): string {
        if (!is_string($value)) {
            return $fallback;
        }

        $value = trim($value);
        if (preg_match('/^#[0-9a-fA-F]{3}$/', $value) === 1 || preg_match('/^#[0-9a-fA-F]{6}$/', $value) === 1) {
            return $value;
        }

        return $fallback;
    };

    $rebornToRgb = static function (string $hex): string {
        $hex = ltrim(trim($hex), '#');
        if (preg_match('/^[0-9a-fA-F]{3}$/', $hex) === 1) {
            return implode(', ', [
                hexdec(str_repeat($hex[0], 2)),
                hexdec(str_repeat($hex[1], 2)),
                hexdec(str_repeat($hex[2], 2)),
            ]);
        }

        if (preg_match('/^[0-9a-fA-F]{6}$/', $hex) === 1) {
            return implode(', ', [
                hexdec(substr($hex, 0, 2)),
                hexdec(substr($hex, 2, 2)),
                hexdec(substr($hex, 4, 2)),
            ]);
        }

        return '13, 110, 253';
    };

    $rebornMode = (($rebornTheme['mode'] ?? 'light') === 'dark') ? 'dark' : 'light';
    $rebornHeaderPositionValue = $rebornHeader['position'] ?? 'top';
    $rebornHeaderPosition = in_array($rebornHeaderPositionValue, ['top', 'left'], true) ? $rebornHeaderPositionValue : 'top';
    $rebornHeaderWidth = (int) $rebornClamp($rebornHeader['width'] ?? 280, 280, 220, 420);
    $rebornFooterPositionValue = $rebornFooter['position'] ?? 'default';
    $rebornFooterPosition = in_array($rebornFooterPositionValue, ['default', 'fixed'], true)
        ? $rebornFooterPositionValue
        : 'default';

    $rebornColorsLight = array_merge($rebornDefaultColorsLight, is_array($rebornTheme['colorsLight'] ?? null) ? $rebornTheme['colorsLight'] : []);
    $rebornColorsDark = array_merge($rebornDefaultColorsDark, is_array($rebornTheme['colorsDark'] ?? null) ? $rebornTheme['colorsDark'] : []);

    foreach ($rebornColorsLight as $rebornColorKey => $rebornColorValue) {
        $rebornColorsLight[$rebornColorKey] = $rebornSanitizeHex($rebornColorValue, $rebornDefaultColorsLight[$rebornColorKey] ?? '#000000');
    }

    foreach ($rebornColorsDark as $rebornColorKey => $rebornColorValue) {
        $rebornColorsDark[$rebornColorKey] = $rebornSanitizeHex($rebornColorValue, $rebornDefaultColorsDark[$rebornColorKey] ?? '#000000');
    }

    $rebornButtonRadius = $rebornClamp($rebornBootstrap['buttonRadius'] ?? 6, 6, 0, 64);
    $rebornCardPaddingY = $rebornClamp($rebornBootstrap['cardPaddingY'] ?? 16, 16, 0, 64);
    $rebornCardPaddingX = $rebornClamp($rebornBootstrap['cardPaddingX'] ?? 16, 16, 0, 64);
    $rebornButtonPaddingY = $rebornClamp($rebornBootstrap['buttonPaddingY'] ?? 6, 6, 0, 32);
    $rebornButtonPaddingX = $rebornClamp($rebornBootstrap['buttonPaddingX'] ?? 12, 12, 0, 48);
    $rebornButtonWeight = $rebornClamp($rebornBootstrap['buttonWeight'] ?? 500, 500, 100, 900);
    $rebornFormRadius = $rebornClamp($rebornBootstrap['formRadius'] ?? 6, 6, 0, 64);
    $rebornNavPaddingY = $rebornClamp($rebornBootstrap['navPaddingY'] ?? 0.5, 0.5, 0, 2);
    $rebornNavPaddingX = $rebornClamp($rebornBootstrap['navPaddingX'] ?? 0.85, 0.85, 0, 3);
    $rebornCardShadowLevel = (int) $rebornClamp($rebornBootstrap['cardShadowLevel'] ?? 1, 1, 0, 3);
    $rebornButtonShadowLevel = (int) $rebornClamp($rebornBootstrap['buttonShadowLevel'] ?? 0, 0, 0, 3);
    $rebornLinkColor = $rebornSanitizeHex($rebornBootstrap['linkColor'] ?? $rebornColorsLight['primary'], $rebornColorsLight['primary']);
    $rebornLinkHoverColor = $rebornSanitizeHex($rebornBootstrap['linkHoverColor'] ?? $rebornLinkColor, $rebornLinkColor);

    $rebornCardShadows = [
        'none',
        'var(--rb-card-shadow-1)',
        'var(--rb-card-shadow-2)',
        'var(--rb-card-shadow-3)',
    ];
    $rebornButtonShadows = [
        'none',
        'var(--rb-btn-shadow-1)',
        'var(--rb-btn-shadow-2)',
        'var(--rb-btn-shadow-3)',
    ];

    $rebornBuildThemeVars = static function (array $palette) use (
        $rebornToRgb,
        $rebornButtonRadius,
        $rebornCardPaddingY,
        $rebornCardPaddingX,
        $rebornButtonPaddingY,
        $rebornButtonPaddingX,
        $rebornButtonWeight,
        $rebornFormRadius,
        $rebornNavPaddingY,
        $rebornNavPaddingX,
        $rebornCardShadowLevel,
        $rebornButtonShadowLevel,
        $rebornCardShadows,
        $rebornButtonShadows,
        $rebornLinkColor,
        $rebornLinkHoverColor
    ): string {
        $variants = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];
        $vars = [];

        foreach ($variants as $variant) {
            $value = $palette[$variant] ?? '#000000';
            $vars[] = "--bs-{$variant}: {$value}";
            $vars[] = "--bs-{$variant}-rgb: ".$rebornToRgb($value);
        }

        $vars[] = '--bs-body-bg: '.($palette['body'] ?? '#ffffff');
        $vars[] = '--bs-body-color: '.($palette['text'] ?? '#212529');
        $vars[] = '--bs-btn-radius: '.$rebornButtonRadius.'px';
        $vars[] = '--rb-card-padding-y: '.$rebornCardPaddingY.'px';
        $vars[] = '--rb-card-padding-x: '.$rebornCardPaddingX.'px';
        $vars[] = '--rb-btn-padding-y: '.$rebornButtonPaddingY.'px';
        $vars[] = '--rb-btn-padding-x: '.$rebornButtonPaddingX.'px';
        $vars[] = '--rb-btn-weight: '.$rebornButtonWeight;
        $vars[] = '--rb-form-radius: '.$rebornFormRadius.'px';
        $vars[] = '--rb-nav-padding-y: '.$rebornNavPaddingY.'rem';
        $vars[] = '--rb-nav-padding-x: '.$rebornNavPaddingX.'rem';
        $vars[] = '--rb-card-shadow: '.($rebornCardShadows[$rebornCardShadowLevel] ?? 'none');
        $vars[] = '--rb-btn-shadow: '.($rebornButtonShadows[$rebornButtonShadowLevel] ?? 'none');
        $vars[] = '--bs-link-color: '.$rebornLinkColor;
        $vars[] = '--bs-link-hover-color: '.$rebornLinkHoverColor;

        return implode('; ', $vars);
    };

    $rebornThemeStyles = ':root,[data-bs-theme="light"]{'.$rebornBuildThemeVars($rebornColorsLight).';}';
    $rebornThemeStyles .= '[data-bs-theme="dark"]{'.$rebornBuildThemeVars($rebornColorsDark).';}';
    $rebornThemeStyles .= 'body{background:var(--bs-body-bg);color:var(--bs-body-color);}';
    $rebornThemeStyles .= '.btn{padding:var(--rb-btn-padding-y) var(--rb-btn-padding-x)!important;font-weight:var(--rb-btn-weight)!important;}';

    $rebornNormalizeBlocks = static function ($blocks): array {
        if (!is_array($blocks)) {
            return [];
        }

        return array_values(array_filter($blocks, static function ($block) {
            return is_array($block) && is_string($block['type'] ?? null) && trim($block['type']) !== '';
        }));
    };

    $rebornGlobal = is_array($rebornComposer['global'] ?? null) ? $rebornComposer['global'] : [];
    $rebornGlobalBlocks = $rebornNormalizeBlocks($rebornGlobal['blocks'] ?? []);
    $rebornSidebarBlocks = $rebornNormalizeBlocks($rebornGlobal['sidebar_blocks'] ?? []);

    $rebornStaticHeaderBlocks = [
        ['id' => 'reborn-static-header-brand', 'type' => 'site-header-brand', 'enabled' => true, 'settings' => ['show_logo' => true, 'show_name' => true, 'tagline' => '']],
        ['id' => 'reborn-static-header-menu', 'type' => 'site-header-menu', 'enabled' => true, 'settings' => ['style' => 'pills', 'uppercase' => false]],
        ['id' => 'reborn-static-header-user', 'type' => 'site-header-user', 'enabled' => true, 'settings' => ['show_avatar' => true, 'show_role' => true]],
    ];

    $rebornSanitizeCss = static function ($css): string {
        if (!is_string($css)) {
            return '';
        }

        $css = trim($css);
        if ($css === '') {
            return '';
        }

        return str_replace(['</style>', '<style', '<script', '</script>'], '', $css);
    };

    $rebornExtractCssBlocks = static function (array $blocks) use ($rebornSanitizeCss): string {
        $cssParts = [];
        foreach ($blocks as $block) {
            $isEnabled = array_key_exists('enabled', $block) ? (bool) $block['enabled'] : true;
            if (!$isEnabled || ($block['type'] ?? '') !== 'custom-css') {
                continue;
            }

            $settings = is_array($block['settings'] ?? null) ? $block['settings'] : [];
            $css = $rebornSanitizeCss($settings['css'] ?? '');
            if ($css !== '') {
                $cssParts[] = $css;
            }
        }

        return implode("\n", $cssParts);
    };

    $rebornGlobalCss = trim($rebornExtractCssBlocks($rebornGlobalBlocks)."\n".$rebornExtractCssBlocks($rebornSidebarBlocks));
@endphp
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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ site_name() }}</title>
    <link rel="shortcut icon" href="{{ favicon() }}">

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    @stack('scripts')

    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/override-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/reborn.css') }}" rel="stylesheet">
    @stack('styles')

    <style>{!! $rebornThemeStyles !!}</style>
    @if($rebornGlobalCss !== '')
        <style>{!! $rebornGlobalCss !!}</style>
    @endif
</head>

<body data-bs-theme="{{ $rebornMode }}"
      class="reborn-header-{{ $rebornHeaderPosition }} reborn-footer-position-{{ $rebornFooterPosition }}"
      style="--reborn-header-width: {{ $rebornHeaderWidth }}px;">
<div id="app">
    <div id="reborn-app-shell">
        <header class="reborn-site-header">
            <div class="reborn-header-inner">
                <div class="reborn-header-blocks">
                    @foreach($rebornStaticHeaderBlocks as $rebornHeaderBlock)
                        <x-reborn.render-block :block="$rebornHeaderBlock" :context="[]" />
                    @endforeach
                </div>
            </div>
        </header>

        <div class="reborn-main">
            @yield('app')

            <footer id="rebornBaseFooter" class="text-center text-bg-dark mt-auto py-4">
                <div class="container">
                    <p class="mb-2">{{ setting('copyright') }} | @lang('messages.copyright')</p>
                    @foreach(social_links() as $link)
                        <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                           class="d-inline-block mx-1 p-2 rounded-circle" style="background: {{ $link->color }}">
                            <i class="{{ $link->icon }} text-white"></i>
                        </a>
                    @endforeach
                </div>
            </footer>
        </div>
    </div>

    @auth
        @if(auth()->user()->isAdmin())
            @include('components.builder.builder')
        @endif
    @endauth
</div>

@stack('footer-scripts')
</body>
</html>
