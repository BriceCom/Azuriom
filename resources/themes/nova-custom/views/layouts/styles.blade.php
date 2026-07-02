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
        --bg-max-height: {{  theme_config('header.index.hero.bg.max-height') ?? 1024 }}px;
        --di-container-footer-max-width-xxl: {{ theme_config('footer.index.container.max-width') ?? 1320 }}px;
        --di-container-header-max-width-xxl: {{ theme_config('header.index.container.max-width') ?? 1320 }}px;

        @if(!theme_config('style.index.theme.dark.off'))
            --bg-light: url("{{theme_config('style.index.background.light') ? image_url(theme_config('style.index.background.light')): (setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500')}}");
            --bg-dark: url("{{theme_config('style.index.background.dark') ? image_url(theme_config('style.index.background.dark')): (setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500')}}");
       @endif

    }
:root {
    [data-bs-theme=light],[data-bs-theme=dark]{
    }

    [data-bs-theme=light]{

        /* Color */
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{color_rgb(theme_config('style.colors.light.primary')??'#FF6B35')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.primary')??'#FF6B35'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.light.primary')??'#FF6B35')}};
        --di-primary-text-emphasis: #000000;

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{color_rgb(theme_config('style.colors.light.secondary')??'#CFD8E6')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.secondary')??'#CFD8E6'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.light.secondary')??'#CFD8E6')}};
        --di-secondary-text-emphasis: #000000;

        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{color_rgb(theme_config('style.colors.light.tertiary')??'#00BFA5')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.tertiary')??'#00BFA5'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.light.tertiary')??'#00BFA5')}};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{color_rgb(theme_config('style.colors.light.quaternary')??'#FFC857')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.quaternary')??'#FFC857'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.light.quaternary')??'#FFC857')}};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{color_rgb(theme_config('style.colors.light.light')??'#F8FAFC')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{color_rgb(theme_config('style.colors.light.dark')??'#DDE4EE')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.dark')??'#DDE4EE'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{color_rgb(theme_config('style.colors.light.black')??'#D7DEE9')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{color_rgb(theme_config('style.colors.light.body')??'#F1F5FB')}};

        /* Text */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{color_rgb(theme_config('style.colors.light.color') ?? '#0F172A')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.light.color-dark')??'#E2E8F0'}};

        /* Alert */
        --di-success: {{theme_config('style.colors.light.success') ?? '#23C552' }};
        --di-success-hex: {{theme_config('style.colors.light.success') ?? '#23C552' }};
        --di-success-rgb: {{color_rgb(theme_config('style.colors.light.success')??'#23C552')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.light.success')??'#23C552')}};

        --di-info: {{theme_config('style.colors.light.info') ?? '#1EA7FD' }};
        --di-info-hex: {{theme_config('style.colors.light.info') ?? '#1EA7FD' }};
        --di-info-rgb: {{color_rgb(theme_config('style.colors.light.info')??'#1EA7FD')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.light.info')??'#1EA7FD')}};

        --di-warning: {{theme_config('style.colors.light.warning') ?? '#FF9F1C' }};
        --di-warning-hex: {{theme_config('style.colors.light.warning') ?? '#FF9F1C' }};
        --di-warning-rgb: {{color_rgb(theme_config('style.colors.light.warning')??'#FF9F1C')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.light.warning')??'#FF9F1C')}};

        --di-danger: {{theme_config('style.colors.light.danger') ?? '#E63946' }};
        --di-danger-hex: {{theme_config('style.colors.light.danger') ?? '#E63946' }};
        --di-danger-rgb: {{color_rgb(theme_config('style.colors.light.danger')??'#E63946')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.light.danger')??'#E63946')}};
    }
    [data-bs-theme=dark]{
        /* Colors */
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{color_rgb(theme_config('style.colors.dark.primary')??'#FF7A45')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.primary')??'#FF7A45'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.dark.primary')??'#FF7A45')}};
        --di-primary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.primary') ??'#FF7A45') }};

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{color_rgb(theme_config('style.colors.dark.secondary')??'#293445')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.secondary')??'#293445'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.dark.secondary')??'#293445')}};
        --di-secondary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.secondary') ??'#293445') }};


        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{color_rgb(theme_config('style.colors.dark.tertiary')??'#19C6B3')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.tertiary')??'#19C6B3'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.dark.tertiary')??'#19C6B3')}};
        --di-tertiary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.tertiary') ??'#19C6B3') }};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{color_rgb(theme_config('style.colors.dark.quaternary')??'#FFD166')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.quaternary')??'#FFD166'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.dark.quaternary')??'#FFD166')}};
        --di-quaternary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.quaternary') ??'#FFD166') }};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{color_rgb(theme_config('style.colors.dark.light') ?? '#101924')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{color_rgb(theme_config('style.colors.dark.dark')??'#0B111A')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.dark')??'#0B111A'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{color_rgb(theme_config('style.colors.dark.black')??'#060A11')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{color_rgb(theme_config('style.colors.dark.body')??'#0D141D')}};

        /* Text */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{color_rgb(theme_config('style.colors.dark.color') ?? '#ECF3FB')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.dark.color-dark')??'#94A3B8'}};

        /* Alert */
        --di-success: {{theme_config('style.colors.dark.success') ?? '#3AD17F' }};
        --di-success-hex: {{theme_config('style.colors.dark.success') ?? '#3AD17F' }};
        --di-success-rgb: {{color_rgb(theme_config('style.colors.dark.success')??'#3AD17F')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.dark.success')??'#3AD17F')}};

        --di-info: {{theme_config('style.colors.dark.info') ?? '#4EA8FF' }};
        --di-info-hex: {{theme_config('style.colors.dark.info') ?? '#4EA8FF' }};
        --di-info-rgb: {{color_rgb(theme_config('style.colors.dark.info')??'#4EA8FF')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.dark.info')??'#4EA8FF')}};

        --di-warning: {{theme_config('style.colors.dark.warning') ?? '#FFB144' }};
        --di-warning-hex: {{theme_config('style.colors.dark.warning') ?? '#FFB144' }};
        --di-warning-rgb: {{color_rgb(theme_config('style.colors.dark.warning')??'#FFB144')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.dark.warning')??'#FFB144')}};

        --di-danger: {{theme_config('style.colors.dark.danger') ?? '#FF5D73' }};
        --di-danger-hex: {{theme_config('style.colors.dark.danger') ?? '#FF5D73' }};
        --di-danger-rgb: {{color_rgb(theme_config('style.colors.dark.danger')??'#FF5D73')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.dark.danger')??'#FF5D73')}};
    }
}
</style>
