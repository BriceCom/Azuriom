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
    :root,

    [data-bs-theme=dark] {
        --bs-primary: rgba(var(--bs-primary-rgb), 1);
        --bs-primary-rgb: {{color_rgb(theme_config('style.colors.dark.primary')??'#E2A218')}};
        --bs-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.primary')??'#E2A218'))}};
        --bs-primary-hsl: {{hexToHSL(theme_config('style.colors.dark.primary')??'#E2A218')}};

        --bs-secondary: rgba(var(--bs-secondary-rgb), 1);
        --bs-secondary-rgb: {{color_rgb(theme_config('style.colors.dark.secondary')??'#FFF883')}};
        --bs-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.secondary')??'#FFF883'))}};

        --bs-tertiary: rgba(var(--bs-tertiary-rgb), 1);
        --bs-tertiary-rgb: {{color_rgb(theme_config('style.colors.dark.tertiary')??'#3fb247')}};
        --bs-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('style.colors.dark.tertiary')??'#3fb247'))}};

        --bs-white: rgba(var(--bs-white-rgb), 1);
        --bs-white-rgb: {{color_rgb(theme_config('style.colors.dark.color')??'#E5E5E5')}};

        --bs-body-bg: rgba(var(--bs-body-bg-rgb), 1);
        --bs-body-rgb: {{color_rgb(theme_config('style.colors.dark.body')??'#212529')}};

        /* text */
        --bs-body-color: var(--bs-white);
    }
</style>
