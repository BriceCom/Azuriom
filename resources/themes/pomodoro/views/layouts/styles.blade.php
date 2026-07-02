@php
    $lightPrimary = theme_config('style.colors.light.primary') ?? '#0d6efd';
    $lightBodyColor = theme_config('style.colors.light.body_color') ?? '#212529';
    $lightDark = theme_config('style.colors.light.dark') ?? '#212529';

    $lightPrimaryHover = color_shade($lightPrimary, 0.15);
    $lightPrimaryActive = color_shade($lightPrimary, 0.25);

    $darkPrimary = theme_config('style.colors.dark.primary') ?? '#4dabf7';
    $darkBodyColor = theme_config('style.colors.dark.body_color') ?? '#f8f9fa';
    $darkDark = theme_config('style.colors.dark.dark') ?? '#0f1115';

    $darkPrimaryHover = color_shade($darkPrimary, 0.15);
    $darkPrimaryActive = color_shade($darkPrimary, 0.25);
@endphp

<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<style>
    :root,
    [data-bs-theme="light"] {
        --pom-primary: {{ $lightPrimary }};
        --pom-primary-rgb: {{ color_rgb($lightPrimary) }};
        --pom-primary-hover: {{ $lightPrimaryHover }};
        --pom-primary-active: {{ $lightPrimaryActive }};
        --pom-primary-contrast: {{ color_contrast($lightPrimary) }};
        --pom-primary-hover-contrast: {{ color_contrast($lightPrimaryHover) }};
        --pom-primary-active-contrast: {{ color_contrast($lightPrimaryActive) }};

        --bs-primary: {{ $lightPrimary }};
        --bs-primary-rgb: {{ color_rgb($lightPrimary) }};

        --bs-body-color: {{ $lightBodyColor }};
        --bs-body-color-rgb: {{ color_rgb($lightBodyColor) }};

        --bs-dark: {{ $lightDark }};
        --bs-dark-rgb: {{ color_rgb($lightDark) }};

        --bs-link-color: {{ $lightPrimary }};
        --bs-link-color-rgb: {{ color_rgb($lightPrimary) }};
        --bs-link-hover-color: {{ $lightPrimaryHover }};
        --bs-link-hover-color-rgb: {{ color_rgb($lightPrimaryHover) }};
    }

    [data-bs-theme="dark"] {
        --pom-primary: {{ $darkPrimary }};
        --pom-primary-rgb: {{ color_rgb($darkPrimary) }};
        --pom-primary-hover: {{ $darkPrimaryHover }};
        --pom-primary-active: {{ $darkPrimaryActive }};
        --pom-primary-contrast: {{ color_contrast($darkPrimary) }};
        --pom-primary-hover-contrast: {{ color_contrast($darkPrimaryHover) }};
        --pom-primary-active-contrast: {{ color_contrast($darkPrimaryActive) }};

        --bs-primary: {{ $darkPrimary }};
        --bs-primary-rgb: {{ color_rgb($darkPrimary) }};

        --bs-body-color: {{ $darkBodyColor }};
        --bs-body-color-rgb: {{ color_rgb($darkBodyColor) }};

        --bs-dark: {{ $darkDark }};
        --bs-dark-rgb: {{ color_rgb($darkDark) }};

        --bs-link-color: {{ $darkPrimary }};
        --bs-link-color-rgb: {{ color_rgb($darkPrimary) }};
        --bs-link-hover-color: {{ $darkPrimaryHover }};
        --bs-link-hover-color-rgb: {{ color_rgb($darkPrimaryHover) }};
    }

    .btn-primary {
        --bs-btn-color: var(--pom-primary-contrast);
        --bs-btn-bg: var(--pom-primary);
        --bs-btn-border-color: var(--pom-primary);
        --bs-btn-hover-color: var(--pom-primary-hover-contrast);
        --bs-btn-hover-bg: var(--pom-primary-hover);
        --bs-btn-hover-border-color: var(--pom-primary-hover);
        --bs-btn-focus-shadow-rgb: var(--pom-primary-rgb);
        --bs-btn-active-color: var(--pom-primary-active-contrast);
        --bs-btn-active-bg: var(--pom-primary-active);
        --bs-btn-active-border-color: var(--pom-primary-active);
        --bs-btn-disabled-color: var(--pom-primary-contrast);
        --bs-btn-disabled-bg: var(--pom-primary);
        --bs-btn-disabled-border-color: var(--pom-primary);
    }

    .btn-outline-primary {
        --bs-btn-color: var(--pom-primary);
        --bs-btn-border-color: var(--pom-primary);
        --bs-btn-hover-color: var(--pom-primary-contrast);
        --bs-btn-hover-bg: var(--pom-primary);
        --bs-btn-hover-border-color: var(--pom-primary);
        --bs-btn-focus-shadow-rgb: var(--pom-primary-rgb);
        --bs-btn-active-color: var(--pom-primary-active-contrast);
        --bs-btn-active-bg: var(--pom-primary-active);
        --bs-btn-active-border-color: var(--pom-primary-active);
        --bs-btn-disabled-color: var(--pom-primary);
        --bs-btn-disabled-bg: transparent;
        --bs-btn-disabled-border-color: var(--pom-primary);
        --bs-gradient: none;
    }

    .list-group {
        --bs-list-group-active-color: var(--pom-primary-contrast);
        --bs-list-group-active-bg: var(--pom-primary);
        --bs-list-group-active-border-color: var(--pom-primary);
    }

    .list-group-item.active {
        color: var(--pom-primary-contrast);
        background-color: var(--pom-primary);
        border-color: var(--pom-primary);
    }

    .dropdown-menu {
        --bs-dropdown-link-active-color: var(--pom-primary-contrast);
        --bs-dropdown-link-active-bg: var(--pom-primary);
    }

    .dropdown-item.active,
    .dropdown-item:active {
        color: var(--pom-primary-contrast);
        background-color: var(--pom-primary);
    }
</style>
