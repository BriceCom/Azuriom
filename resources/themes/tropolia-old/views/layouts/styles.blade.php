@php
    function RGBnocommas($rgb){return str_replace(',', '', $rgb);}
    function hexToHSL($hex){
    $hex = str_replace('#', '', $hex);

    $red = hexdec(substr($hex, 0, 2)) / 255;
    $green = hexdec(substr($hex, 2, 2)) / 255;
    $blue = hexdec(substr($hex, 4, 2)) / 255;

    $cmin = min($red, $green, $blue);
    $cmax = max($red, $green, $blue);
    $delta = $cmax - $cmin;

    if ($delta == 0) {
        // Couleur neutre (gris, blanc, noir) => hue non défini
        return 0; // ou "undefined", ou "neutral"
    }

    if ($cmax === $red) {
        $hue = (($green - $blue) / $delta);
    } elseif ($cmax === $green) {
        $hue = ($blue - $red) / $delta + 2;
    } else {
        $hue = ($red - $green) / $delta + 4;
    }

    $hue = round($hue * 60);
    if ($hue < 0) {
        $hue += 360;
    }

    return $hue;
}

@endphp

<style>
    :root {
        --bg-base: url("{{(setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500' )}}");

        @if(!theme_config('style.index.theme.dark.off'))
            --bg-light: url("{{theme_config('style.index.background.light') ? image_url(theme_config('style.index.background.light')): (setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500')}}");
            --bg-dark: url("{{theme_config('style.index.background.dark') ? image_url(theme_config('style.index.background.dark')): (setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500')}}");
       @endif

    }
:root {
    [data-bs-theme=light],[data-bs-theme=dark]{

        /* UI */
        @if(theme_config('style.ui.card.borderRadius'))
            --di-border-radius: {{theme_config('style.ui.card.borderRadius') ?? '16'}}px !important;
            --di-border-radius-lg: {{theme_config('style.ui.card.borderRadius')*1.3}}px;
        @endif
    }

    [data-bs-theme=dark]{
        /* Colors */
        /* 202 170 109 */
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{color_rgb(theme_config('style.colors.dark.primary')??'#4CAF50')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.primary')??'#4CAF50'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.dark.primary')??'#4CAF50')}};
        --di-primary-text-emphasis: #342809;

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{color_rgb(theme_config('style.colors.dark.secondary')??'#757575')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.secondary')??'#757575'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.dark.secondary')??'#757575')}};
        --di-secondary-text-emphasis: #342809;

        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{color_rgb(theme_config('style.colors.dark.tertiary')??'#FCA500')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.tertiary')??'#FCA500'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.dark.tertiary')??'#FCA500')}};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{color_rgb(theme_config('style.colors.dark.quaternary')??'#D96D3C')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.quaternary')??'#D96D3C'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.dark.quaternary')??'#D96D3C')}};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{color_rgb(theme_config('style.colors.dark.light')??'#1E1E1E')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{color_rgb(theme_config('style.colors.dark.dark')??'#111111')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.dark')??'#111111'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{color_rgb(theme_config('style.colors.dark.black')??'#111111')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{color_rgb(theme_config('style.colors.dark.body')??'#0B0907')}};

        /* Text */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{color_rgb(theme_config('style.colors.dark.color') ?? '#ffffff')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.dark.color-dark')??'#6c757d'}};

        /* Alert */
        --di-success: {{theme_config('style.colors.dark.success') ?? '#198754' }};
        --di-success-hex: {{theme_config('style.colors.dark.success') ?? '#198754' }};
        --di-success-rgb: {{color_rgb(theme_config('style.colors.dark.success')??'#198754')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.dark.success')??'#198754')}};

        --di-info: {{theme_config('style.colors.dark.info') ?? '#0dcaf0' }};
        --di-info-hex: {{theme_config('style.colors.dark.info') ?? '#0dcaf0' }};
        --di-info-rgb: {{color_rgb(theme_config('style.colors.dark.info')??'#0dcaf0')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.dark.info')??'#0dcaf0')}};

        --di-warning: {{theme_config('style.colors.dark.warning') ?? '#47ff88' }};
        --di-warning-hex: {{theme_config('style.colors.dark.warning') ?? '#47ff88' }};
        --di-warning-rgb: {{color_rgb(theme_config('style.colors.dark.warning')??'#47ff88')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.dark.warning')??'#47ff88')}};

        --di-danger: {{theme_config('style.colors.dark.danger') ?? '#dc3545' }};
        --di-danger-hex: {{theme_config('style.colors.dark.danger') ?? '#dc3545' }};
        --di-danger-rgb: {{color_rgb(theme_config('style.colors.dark.danger')??'#dc3545')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.dark.danger')??'#dc3545')}};

        /* Top */
        --di-top-vote-one: {{theme_config('vote.rewards.topColor.1')}};
        --di-top-vote-one-rgb: {{color_rgb(theme_config('vote.rewards.topColor.1')??'#F8D32E')}};

        --di-top-vote-two: {{theme_config('vote.rewards.topColor.2')}};
        --di-top-vote-one-rgb: {{color_rgb(theme_config('vote.rewards.topColor.2')??'#D5D4D0')}};

        --di-top-vote-three: {{theme_config('vote.rewards.topColor.3')}};
        --di-top-vote-one-rgb: {{color_rgb(theme_config('vote.rewards.topColor.3')??'#B57B3E')}};

    }
}
</style>
