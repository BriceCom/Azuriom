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

        @if(!theme_config('style.index.theme.dark.off'))
            --bg-light: url("{{theme_config('style.index.background.light') ? image_url(theme_config('style.index.background.light')): (setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500')}}");
            --bg-dark: url("{{theme_config('style.index.background.dark') ? image_url(theme_config('style.index.background.dark')): (setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500')}}");
       @endif

        @if(theme_config('home.hero.bg'))
            --home-hero-bg-light: url("{{ image_url(theme_config('home.hero.bg')) }}");
            --home-hero-bg-dark: url("{{ image_url(theme_config('home.hero.bg')) }}");
        @endif

    }
:root {
    [data-bs-theme=light],[data-bs-theme=dark]{
    }

    [data-bs-theme=light]{

        /* Color */
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{color_rgb(theme_config('style.colors.light.primary')??'#00B7FF')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.primary')??'#00B7FF'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.light.primary')??'#00B7FF')}};
        --di-primary-text-emphasis: #000000;

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{color_rgb(theme_config('style.colors.light.secondary')??'#c8cccd')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.secondary')??'#c8cccd'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.light.secondary')??'#c8cccd')}};
        --di-secondary-text-emphasis: #000000;

        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{color_rgb(theme_config('style.colors.light.tertiary')??'#F8CA47')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.tertiary')??'#F8CA47'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.light.tertiary')??'#F8CA47')}};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{color_rgb(theme_config('style.colors.light.quaternary')??'#ECAF2D')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.quaternary')??'#ECAF2D'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.light.quaternary')??'#ECAF2D')}};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{color_rgb(theme_config('style.colors.light.light')??'#fafafa')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{color_rgb(theme_config('style.colors.light.dark')??'#e3e2e2')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.light.dark')??'#e3e2e2'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{color_rgb(theme_config('style.colors.light.black')??'#e2e2e2')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{color_rgb(theme_config('style.colors.light.body')??'#f2f2f2')}};

        /* Text */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{color_rgb(theme_config('style.colors.light.color') ?? '#111111')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.light.color-dark')??'#f2f2f2'}};

        /* Alert */
        --di-success: {{theme_config('style.colors.light.success') ?? '#BBF24B' }};
        --di-success-hex: {{theme_config('style.colors.light.success') ?? '#BBF24B' }};
        --di-success-rgb: {{color_rgb(theme_config('style.colors.light.success')??'#BBF24B')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.light.success')??'#BBF24B')}};

        --di-info: {{theme_config('style.colors.light.info') ?? '#0dcaf0' }};
        --di-info-hex: {{theme_config('style.colors.light.info') ?? '#0dcaf0' }};
        --di-info-rgb: {{color_rgb(theme_config('style.colors.light.info')??'#0dcaf0')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.light.info')??'#0dcaf0')}};

        --di-warning: {{theme_config('style.colors.light.warning') ?? '#F88934' }};
        --di-warning-hex: {{theme_config('style.colors.light.warning') ?? '#F88934' }};
        --di-warning-rgb: {{color_rgb(theme_config('style.colors.light.warning')??'#F88934')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.light.warning')??'#F88934')}};

        --di-danger: {{theme_config('style.colors.light.danger') ?? '#dc3545' }};
        --di-danger-hex: {{theme_config('style.colors.light.danger') ?? '#dc3545' }};
        --di-danger-rgb: {{color_rgb(theme_config('style.colors.light.danger')??'#dc3545')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.light.danger')??'#dc3545')}};
    }
    [data-bs-theme=dark]{
        /* Colors */
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{color_rgb(theme_config('style.colors.dark.primary')??'#F4C438')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.primary')??'#F4C438'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.dark.primary')??'#F4C438')}};
        --di-primary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.primary') ??'#F4C438') }};

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{color_rgb(theme_config('style.colors.dark.secondary')??'#3E404D')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.secondary')??'#3E404D'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.dark.secondary')??'#3E404D')}};
        --di-secondary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.secondary') ??'#3E404D') }};


        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{color_rgb(theme_config('style.colors.dark.tertiary')??'#F8CA47')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.tertiary')??'#F8CA47'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.dark.tertiary')??'#F8CA47')}};
        --di-tertiary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.tertiary') ??'#F8CA47') }};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{color_rgb(theme_config('style.colors.dark.quaternary')??'#FF6CBA')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.quaternary')??'#FF6CBA'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.dark.quaternary')??'#FF6CBA')}};
        --di-quaternary-text-emphasis: {{ color_contrast(theme_config('style.colors.dark.quaternary') ??'#FF6CBA') }};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{color_rgb(theme_config('style.colors.dark.light') ?? '#111111')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{color_rgb(theme_config('style.colors.dark.dark')??'#17191B')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.dark')??'#17191B'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{color_rgb(theme_config('style.colors.dark.black')??'#070606')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{color_rgb(theme_config('style.colors.dark.body')??'#111111')}};

        /* Text */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{color_rgb(theme_config('style.colors.dark.color') ?? '#ffffff')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.dark.color-dark')??'#6c757d'}};

        /* Alert */
        --di-success: {{theme_config('style.colors.dark.success') ?? '#BBF24B' }};
        --di-success-hex: {{theme_config('style.colors.dark.success') ?? '#BBF24B' }};
        --di-success-rgb: {{color_rgb(theme_config('style.colors.dark.success')??'#BBF24B')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.dark.success')??'#BBF24B')}};

        --di-info: {{theme_config('style.colors.dark.info') ?? '#3499F8' }};
        --di-info-hex: {{theme_config('style.colors.dark.info') ?? '#3499F8' }};
        --di-info-rgb: {{color_rgb(theme_config('style.colors.dark.info')??'#3499F8')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.dark.info')??'#3499F8')}};

        --di-warning: {{theme_config('style.colors.dark.warning') ?? '#ffc107' }};
        --di-warning-hex: {{theme_config('style.colors.dark.warning') ?? '#ffc107' }};
        --di-warning-rgb: {{color_rgb(theme_config('style.colors.dark.warning')??'#ffc107')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.dark.warning')??'#ffc107')}};

        --di-danger: {{theme_config('style.colors.dark.danger') ?? '#dc3545' }};
        --di-danger-hex: {{theme_config('style.colors.dark.danger') ?? '#dc3545' }};
        --di-danger-rgb: {{color_rgb(theme_config('style.colors.dark.danger')??'#dc3545')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.dark.danger')??'#dc3545')}};
    }
}
</style>
