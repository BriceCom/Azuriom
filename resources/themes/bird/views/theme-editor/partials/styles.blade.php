@php
    $fallbackBackground = setting('background') ? image_url(setting('background')) : null;
    $bgLight = theme_config('styles.bg_light') ? image_url(theme_config('styles.bg_light')) : $fallbackBackground;
    $bgDark = theme_config('styles.bg_dark') ? image_url(theme_config('styles.bg_dark')) : $fallbackBackground;
    $advancedModeEnabled = (bool) theme_config('advanced.advanced_mode', false);
    $fontCustomEnabled = $advancedModeEnabled && (bool) theme_config('styles.font_custom_enabled', false);
    $fontBodyUrl = $fontCustomEnabled ? (string) theme_config('styles.font_body_url', '') : '';
    $fontBodyName = $fontCustomEnabled ? (string) theme_config('styles.font_body_name', '') : '';
    $fontHeadingUrl = $fontCustomEnabled ? (string) theme_config('styles.font_heading_url', '') : '';
    $fontHeadingName = $fontCustomEnabled ? (string) theme_config('styles.font_heading_name', '') : '';
    $fontImports = array_values(array_unique(array_filter([
        trim($fontBodyName) !== '' ? $fontBodyUrl : '',
        trim($fontHeadingName) !== '' ? $fontHeadingUrl : '',
    ], static fn ($url) => is_string($url) && trim($url) !== '')));

    $light = [
        'primary' => theme_config('styles.colors.light.primary', '#00b7ff'),
        'secondary' => theme_config('styles.colors.light.secondary', '#c8cccd'),
        'tertiary' => theme_config('styles.colors.light.tertiary', '#f8ca47'),
        'quaternary' => theme_config('styles.colors.light.quaternary', '#ecaf2d'),
        'background' => theme_config('styles.colors.light.background', '#f2f2f2'),
        'dark_tone_1' => theme_config('styles.colors.light.dark_tone_1', '#e3e2e2'),
        'dark_tone_2' => theme_config('styles.colors.light.dark_tone_2', '#d7d7d7'),
        'light_tone_1' => theme_config('styles.colors.light.light_tone_1', '#fafafa'),
        'light_tone_2' => theme_config('styles.colors.light.light_tone_2', '#ffffff'),
        'text' => theme_config('styles.colors.light.text', '#111111'),
        'text_background' => theme_config('styles.colors.light.text_background', '#ffffff'),
        'alert_success' => theme_config('styles.colors.light.alert_success', '#bbf24b'),
    ];

    $dark = [
        'primary' => theme_config('styles.colors.dark.primary', '#00b7ff'),
        'secondary' => theme_config('styles.colors.dark.secondary', '#3e404d'),
        'tertiary' => theme_config('styles.colors.dark.tertiary', '#f8ca47'),
        'quaternary' => theme_config('styles.colors.dark.quaternary', '#ff6cba'),
        'background' => theme_config('styles.colors.dark.background', '#111111'),
        'dark_tone_1' => theme_config('styles.colors.dark.dark_tone_1', '#070606'),
        'dark_tone_2' => theme_config('styles.colors.dark.dark_tone_2', '#17191b'),
        'light_tone_1' => theme_config('styles.colors.dark.light_tone_1', '#21262c'),
        'light_tone_2' => theme_config('styles.colors.dark.light_tone_2', '#2b3036'),
        'text' => theme_config('styles.colors.dark.text', '#ffffff'),
        'text_background' => theme_config('styles.colors.dark.text_background', '#21262c'),
        'alert_success' => theme_config('styles.colors.dark.alert_success', '#bbf24b'),
    ];
@endphp

@foreach($fontImports as $fontImportUrl)
    <link rel="stylesheet" href="{{ $fontImportUrl }}">
@endforeach

<style>
    :root {
        --te-font-body: {{ $fontCustomEnabled && trim($fontBodyName) !== '' ? '"'.str_replace('"', '\"', $fontBodyName).'", sans-serif' : 'var(--bs-font-sans-serif)' }};
        --te-font-heading: {{ $fontCustomEnabled && trim($fontHeadingName) !== '' ? '"'.str_replace('"', '\"', $fontHeadingName).'", sans-serif' : 'var(--bs-font-sans-serif)' }};
        --bs-main-font: var(--te-font-body);
        --bs-body-font-family: var(--te-font-body);
        --bs-btn-font-family: var(--te-font-body);
        --te-bg-light: {{ $bgLight ? 'url("'.$bgLight.'")' : 'none' }};
        --te-bg-dark: {{ $bgDark ? 'url("'.$bgDark.'")' : 'none' }};
    }

    [data-bs-theme="light"] {
        --bs-primary: {{ $light['primary'] }};
        --bs-primary-rgb: {{ color_rgb($light['primary']) }};
        --bs-primary-text-emphasis: {{ color_contrast($light['primary']) }};
        --bs-secondary: {{ $light['secondary'] }};
        --bs-secondary-rgb: {{ color_rgb($light['secondary']) }};
        --bs-secondary-text-emphasis: {{ color_contrast($light['secondary']) }};
        --bs-tertiary: {{ $light['tertiary'] }};
        --bs-tertiary-rgb: {{ color_rgb($light['tertiary']) }};
        --bs-tertiary-text-emphasis: {{ color_contrast($light['tertiary']) }};
        --bs-quaternary: {{ $light['quaternary'] }};
        --bs-quaternary-rgb: {{ color_rgb($light['quaternary']) }};
        --bs-quaternary-text-emphasis: {{ color_contrast($light['quaternary']) }};
        --bs-light: {{ $light['light_tone_1'] }};
        --bs-light-rgb: {{ color_rgb($light['light_tone_1']) }};
        --bs-dark: {{ $light['dark_tone_1'] }};
        --bs-dark-rgb: {{ color_rgb($light['dark_tone_1']) }};
        --bs-body-bg: {{ $light['background'] }};
        --bs-body-bg-rgb: {{ color_rgb($light['background']) }};
        --bs-body-color: {{ $light['text'] }};
        --bs-body-color-rgb: {{ color_rgb($light['text']) }};
        --bs-white: {{ $light['text'] }};
        --bs-white-rgb: {{ color_rgb($light['text']) }};
        --bs-emphasis-color: {{ $light['text'] }};
        --bs-emphasis-color-rgb: {{ color_rgb($light['text']) }};
        --bs-heading-color: {{ $light['text'] }};
        --bs-secondary-color: rgba({{ color_rgb($light['text']) }}, 0.78);
        --bs-secondary-color-rgb: {{ color_rgb($light['text']) }};
        --bs-tertiary-color: rgba({{ color_rgb($light['text']) }}, 0.62);
        --bs-tertiary-color-rgb: {{ color_rgb($light['text']) }};
        --bs-secondary-bg: {{ $light['light_tone_1'] }};
        --bs-secondary-bg-rgb: {{ color_rgb($light['light_tone_1']) }};
        --bs-tertiary-bg: {{ $light['text_background'] }};
        --bs-tertiary-bg-rgb: {{ color_rgb($light['text_background']) }};
        --bs-border-color: {{ $light['dark_tone_1'] }};
        --te-dark-tone-1: {{ $light['dark_tone_1'] }};
        --te-dark-tone-2: {{ $light['dark_tone_2'] }};
        --bs-link-color: {{ $light['primary'] }};
        --bs-link-color-rgb: {{ color_rgb($light['primary']) }};
        --bs-link-hover-color: {{ $light['quaternary'] }};
        --bs-link-hover-color-rgb: {{ color_rgb($light['quaternary']) }};
        --te-bg-image: var(--te-bg-light);
    }

    [data-bs-theme="dark"] {
        --bs-primary: {{ $dark['primary'] }};
        --bs-primary-rgb: {{ color_rgb($dark['primary']) }};
        --bs-primary-text-emphasis: {{ color_contrast($dark['primary']) }};
        --bs-secondary: {{ $dark['secondary'] }};
        --bs-secondary-rgb: {{ color_rgb($dark['secondary']) }};
        --bs-secondary-text-emphasis: {{ color_contrast($dark['secondary']) }};
        --bs-tertiary: {{ $dark['tertiary'] }};
        --bs-tertiary-rgb: {{ color_rgb($dark['tertiary']) }};
        --bs-tertiary-text-emphasis: {{ color_contrast($dark['tertiary']) }};
        --bs-quaternary: {{ $dark['quaternary'] }};
        --bs-quaternary-rgb: {{ color_rgb($dark['quaternary']) }};
        --bs-quaternary-text-emphasis: {{ color_contrast($dark['quaternary']) }};
        --bs-light: {{ $dark['light_tone_1'] }};
        --bs-light-rgb: {{ color_rgb($dark['light_tone_1']) }};
        --bs-dark: {{ $dark['dark_tone_1'] }};
        --bs-dark-rgb: {{ color_rgb($dark['dark_tone_1']) }};
        --bs-body-bg: {{ $dark['background'] }};
        --bs-body-bg-rgb: {{ color_rgb($dark['background']) }};
        --bs-body-color: {{ $dark['text'] }};
        --bs-body-color-rgb: {{ color_rgb($dark['text']) }};
        --bs-white: {{ $dark['text'] }};
        --bs-white-rgb: {{ color_rgb($dark['text']) }};
        --bs-emphasis-color: {{ $dark['text'] }};
        --bs-emphasis-color-rgb: {{ color_rgb($dark['text']) }};
        --bs-heading-color: {{ $dark['text'] }};
        --bs-secondary-color: rgba({{ color_rgb($dark['text']) }}, 0.78);
        --bs-secondary-color-rgb: {{ color_rgb($dark['text']) }};
        --bs-tertiary-color: rgba({{ color_rgb($dark['text']) }}, 0.62);
        --bs-tertiary-color-rgb: {{ color_rgb($dark['text']) }};
        --bs-secondary-bg: {{ $dark['light_tone_1'] }};
        --bs-secondary-bg-rgb: {{ color_rgb($dark['light_tone_1']) }};
        --bs-tertiary-bg: {{ $dark['text_background'] }};
        --bs-tertiary-bg-rgb: {{ color_rgb($dark['text_background']) }};
        --bs-border-color: {{ $dark['dark_tone_2'] }};
        --te-dark-tone-1: {{ $dark['dark_tone_1'] }};
        --te-dark-tone-2: {{ $dark['dark_tone_2'] }};
        --bs-link-color: {{ $dark['primary'] }};
        --bs-link-color-rgb: {{ color_rgb($dark['primary']) }};
        --bs-link-hover-color: {{ $dark['quaternary'] }};
        --bs-link-hover-color-rgb: {{ color_rgb($dark['quaternary']) }};
        --te-bg-image: var(--te-bg-dark);
    }

    [data-bs-theme="light"] .alert-success {
        --bs-alert-color: {{ color_contrast($light['alert_success']) }};
    }

    [data-bs-theme="dark"] .alert-success {
        --bs-alert-color: {{ color_contrast($dark['alert_success']) }};
    }
</style>
