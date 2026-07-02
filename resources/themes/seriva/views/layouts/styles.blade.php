<style>
    :root {
        --seriva-bg: {{ theme_config('style.colors.dark.body') ?? '#070d18' }};
        --seriva-bg-2: {{ theme_config('style.colors.dark.dark') ?? '#0d1627' }};
        --seriva-surface: {{ theme_config('style.colors.dark.light') ?? '#152039' }};
        --seriva-surface-alt: #1a2744;
        --seriva-text: {{ theme_config('style.colors.dark.color') ?? '#ebf3ff' }};
        --seriva-muted: #9eb0ce;
        --seriva-soft-line: #2c3c5f;
        --seriva-accent: {{ theme_config('style.colors.dark.primary') ?? '#00b7ff' }};
        --seriva-accent-2: {{ theme_config('style.colors.dark.tertiary') ?? '#f6c547' }};
        --seriva-radius-xl: 1.5rem;
        --seriva-radius-lg: 1rem;
        --seriva-shadow: 0 20px 45px rgba(3, 8, 16, 0.42);
    }

    [data-bs-theme="light"] {
        --seriva-bg: {{ theme_config('style.colors.light.body') ?? '#10192b' }};
        --seriva-bg-2: {{ theme_config('style.colors.light.dark') ?? '#15233a' }};
        --seriva-surface: {{ theme_config('style.colors.light.light') ?? '#1c2f4e' }};
        --seriva-surface-alt: #22375a;
        --seriva-text: {{ theme_config('style.colors.light.color') ?? '#ecf3ff' }};
        --seriva-muted: #a8bbda;
        --seriva-soft-line: #344b74;
        --seriva-accent: {{ theme_config('style.colors.light.primary') ?? '#00b7ff' }};
        --seriva-accent-2: {{ theme_config('style.colors.light.tertiary') ?? '#f6c547' }};
    }

    [data-bs-theme="dark"] {
        --seriva-bg: {{ theme_config('style.colors.dark.body') ?? '#070d18' }};
        --seriva-bg-2: {{ theme_config('style.colors.dark.dark') ?? '#0d1627' }};
        --seriva-surface: {{ theme_config('style.colors.dark.light') ?? '#152039' }};
        --seriva-surface-alt: #1a2744;
        --seriva-text: {{ theme_config('style.colors.dark.color') ?? '#ebf3ff' }};
        --seriva-muted: #9eb0ce;
        --seriva-soft-line: #2c3c5f;
        --seriva-accent: {{ theme_config('style.colors.dark.primary') ?? '#00b7ff' }};
        --seriva-accent-2: {{ theme_config('style.colors.dark.tertiary') ?? '#f6c547' }};
        --seriva-shadow: 0 20px 45px rgba(3, 8, 16, 0.42);
    }
</style>
