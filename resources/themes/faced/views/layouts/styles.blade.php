@php
    function hexToRGB($theme_path){return implode(", ", sscanf($theme_path, "#%02x%02x%02x"));}
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
            $hue = 0;
        } elseif ($cmax === $red) {
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
    [data-bs-theme=light],[data-bs-theme=dark]{

        /* UI */
        @if(theme_config('style.ui.card.borderRadius'))
            --di-border-radius: {{theme_config('style.ui.card.borderRadius') ?? '16'}}px !important;
            --di-border-radius-lg: {{theme_config('style.ui.card.borderRadius')*1.3}}px;
        @endif

        /* Custom scrollbar */
            /* --di-scrollbar-width: 12px;
             --di-scrollbar-track-bg: transparent;
             --di-scrollbar-thumb-bg: red;
             --di-scrollbar-thumb-bg-hover: rgba(235, 235, 235, 0.9);
             --di-scrollbar-border-radius: 5px;
       */
    }

    [data-bs-theme=light]{

        /* COLORS*/
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{hexToRGB(theme_config('style.colors.light.primary')??'#e22828')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.light.primary')??'#e22828'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.light.primary')??'#e22828')}};

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{hexToRGB(theme_config('style.colors.light.secondary')??'#e2b029')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.light.secondary')??'#e2b029'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.light.secondary')??'#e2b029')}};

        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{hexToRGB(theme_config('style.colors.light.tertiary')??'#f8f8f8')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.light.tertiary')??'#f8f8f8'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.light.tertiary')??'#f8f8f8')}};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{hexToRGB(theme_config('style.colors.light.quaternary')??'#a779d7')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.light.quaternary')??'#a779d7'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.light.quaternary')??'#a779d7')}};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{hexToRGB(theme_config('style.colors.light.light')??'#fafafa')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{hexToRGB(theme_config('style.colors.light.dark')??'#f2f2f2')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.light.dark')??'#f2f2f2'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{hexToRGB(theme_config('style.colors.light.black')??'#e2e2e2')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{hexToRGB(theme_config('style.colors.light.body')??'#f2f2f2')}};

        /* TEXT */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{hexToRGB(theme_config('style.colors.light.color') ?? '#111111')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.light.color-dark')??'#f2f2f2'}};

        /* ALERT */
        --di-success: {{theme_config('style.colors.light.success') ?? '#198754' }};
        --di-success-hex: {{theme_config('style.colors.light.success') ?? '#198754' }};
        --di-success-rgb: {{hexToRGB(theme_config('style.colors.light.success')??'#198754')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.light.success')??'#198754')}};

        --di-info: {{theme_config('style.colors.light.info') ?? '#0dcaf0' }};
        --di-info-hex: {{theme_config('style.colors.light.info') ?? '#0dcaf0' }};
        --di-info-rgb: {{hexToRGB(theme_config('style.colors.light.info')??'#0dcaf0')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.light.info')??'#0dcaf0')}};

        --di-warning: {{theme_config('style.colors.light.warning') ?? '#47ff88' }};
        --di-warning-hex: {{theme_config('style.colors.light.warning') ?? '#47ff88' }};
        --di-warning-rgb: {{hexToRGB(theme_config('style.colors.light.warning')??'#47ff88')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.light.warning')??'#47ff88')}};

        --di-danger: {{theme_config('style.colors.light.danger') ?? '#dc3545' }};
        --di-danger-hex: {{theme_config('style.colors.light.danger') ?? '#dc3545' }};
        --di-danger-rgb: {{hexToRGB(theme_config('style.colors.light.danger')??'#dc3545')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.light.danger')??'#dc3545')}};
    }
    [data-bs-theme=dark]{

        /* COLORS*/
        --di-primary: rgba(var(--di-primary-rgb), 1);
        --di-primary-rgb: {{hexToRGB(theme_config('style.colors.dark.primary')??'#e22828')}};
        --di-primary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.dark.primary')??'#e22828'))}};
        --di-primary-hsl: {{hexToHSL(theme_config('style.colors.dark.primary')??'#e22828')}};

        --di-secondary: rgba(var(--di-secondary-rgb), 1);
        --di-secondary-rgb: {{hexToRGB(theme_config('style.colors.dark.secondary')??'#e2b029')}};
        --di-secondary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.dark.secondary')??'#e2b029'))}};
        --di-secondary-hsl: {{hexToHSL(theme_config('style.colors.dark.secondary')??'#e2b029')}};

        --di-tertiary: rgba(var(--di-tertiary-rgb), 1);
        --di-tertiary-rgb: {{hexToRGB(theme_config('style.colors.dark.tertiary')??'#54cbaa')}};
        --di-tertiary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.dark.tertiary')??'#54cbaa'))}};
        --di-tertiary-hsl: {{hexToHSL(theme_config('style.colors.dark.tertiary')??'#54cbaa')}};

        --di-quaternary: rgba(var(--di-quaternary-rgb), 1);
        --di-quaternary-rgb: {{hexToRGB(theme_config('style.colors.dark.quaternary')??'#9344e7')}};
        --di-quaternary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.dark.quaternary')??'#9344e7'))}};
        --di-quaternary-hsl: {{hexToHSL(theme_config('style.colors.dark.quaternary')??'#9344e7')}};

        /* Bg color */
        --di-light: rgba(var(--di-light-rgb), 1);
        --di-light-rgb: {{hexToRGB(theme_config('style.colors.dark.light')??'#191c1f')}};

        --di-dark: rgba(var(--di-dark-rgb), 1);
        --di-dark-rgb: {{hexToRGB(theme_config('style.colors.dark.dark')??'#191c1f')}};
        --di-dark-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('style.colors.dark.dark')??'#191c1f'))}};

        --di-black: rgba(var(--di-black-rgb), 1);
        --di-black-rgb: {{hexToRGB(theme_config('style.colors.dark.black')??'#1a1e21')}};

        --di-tertiary-bg: rgba(var(--di-black-rgb), 1);
        --di-secondary-bg-rgb: var(--di-light-rgb);

        --di-body-bg: rgba(var(--di-body-rgb), 1);
        --di-body-rgb: {{hexToRGB(theme_config('style.colors.dark.body')??'#212529')}};

        /* TEXT */
        --di-white: rgba(var(--di-white-rgb), 1);
        --di-white-rgb: {{hexToRGB(theme_config('style.colors.dark.color') ?? '#ffffff')}};

        --di-body-color: var(--di-white);
        --di-nav-link-color: var(--di-body-color);
        --di-btn-bg: {{theme_config('style.colors.dark.color-dark')??'#6c757d'}};

        /* ALERT */
        --di-success: {{theme_config('style.colors.dark.success') ?? '#198754' }};
        --di-success-hex: {{theme_config('style.colors.dark.success') ?? '#198754' }};
        --di-success-rgb: {{hexToRGB(theme_config('style.colors.dark.success')??'#198754')}};
        --di-success-hsl: {{hexToHSL(theme_config('style.colors.dark.success')??'#198754')}};

        --di-info: {{theme_config('style.colors.dark.info') ?? '#0dcaf0' }};
        --di-info-hex: {{theme_config('style.colors.dark.info') ?? '#0dcaf0' }};
        --di-info-rgb: {{hexToRGB(theme_config('style.colors.dark.info')??'#0dcaf0')}};
        --di-info-hsl: {{hexToHSL(theme_config('style.colors.dark.info')??'#0dcaf0')}};

        --di-warning: {{theme_config('style.colors.dark.warning') ?? '#47ff88' }};
        --di-warning-hex: {{theme_config('style.colors.dark.warning') ?? '#47ff88' }};
        --di-warning-rgb: {{hexToRGB(theme_config('style.colors.dark.warning')??'#47ff88')}};
        --di-warning-hsl: {{hexToHSL(theme_config('style.colors.dark.warning')??'#47ff88')}};

        --di-danger: {{theme_config('style.colors.dark.danger') ?? '#dc3545' }};
        --di-danger-hex: {{theme_config('style.colors.dark.danger') ?? '#dc3545' }};
        --di-danger-rgb: {{hexToRGB(theme_config('style.colors.dark.danger')??'#dc3545')}};
        --di-danger-hsl: {{hexToHSL(theme_config('style.colors.dark.danger')??'#dc3545')}};
    }
}
</style>
