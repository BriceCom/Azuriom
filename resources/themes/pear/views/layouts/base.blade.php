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
    <meta property="og:site_name" content="Serveur {{ site_name() }}">
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
    <script type="text/javascript">
        const defaultTheme = "{{theme_config('general.theme') ?? 'dark'}}";
    </script>

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link rel="preload" href="{{ theme_asset('css/override_bootstrap.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css') }}"></noscript>
    <link href="{{ theme_asset('css/styles.css') }}" rel="stylesheet">
    @stack('styles')
    @php
        function RGBnocommas($rgb){return str_replace(',', '', $rgb);}
    @endphp
    <style>
        @if( theme_config('general.font.toggle'))
            @import url({{theme_config('general.font.url') ?? 'https://fonts.bunny.net/css?family=abeezee:400,400i&display=swap'}});
        body{
            font-family: "{{theme_config('general.font.text') ?? 'abeezee'}}", sans-serif;
        }
        @endif

        body:not([data-bs-theme=dark]){
            --bs-primary: rgba(var(--bs-primary-rgb), 1);
            --bs-primary-rgb: {{color_rgb(theme_config('general.colorLight.primary')??'#000000')}};
            --bs-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorLight.primary')??'#000000'))}};

            --bs-secondary: rgba(var(--bs-secondary-rgb), 1);
            --bs-secondary-rgb: {{color_rgb(theme_config('general.colorLight.secondary')??'#DDFDE8')}};
            --bs-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorLight.secondary')??'#DDFDE8'))}};

            --bs-tertiary: rgba(var(--bs-secondary-rgb), 1);
            --bs-tertiary-rgb: {{color_rgb(theme_config('general.colorLight.tertiary')??'#ffda79')}};
            --bs-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorLight.tertiary')??'#ffda79'))}};

            --bs-white: rgba(var(--bs-white-rgb), 1);
            --bs-white-rgb: {{color_rgb(theme_config('general.colorLight.white')??'#212529')}};

            --bs-light: rgba(var(--bs-light-rgb), 1);
            --bs-light-rgb: {{color_rgb(theme_config('general.colorLight.light')??'#f8f7f4')}};

            --bs-dark: rgba(var(--bs-dark-rgb), 1);
            --bs-dark-rgb: {{color_rgb(theme_config('general.colorLight.dark')??'#F8F9FA')}};
            --bs-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorLight.dark')??'#F8F9FA'))}};

            --bs-black: rgba(var(--bs-black-rgb), 1);
            --bs-black-rgb: {{color_rgb(theme_config('general.colorLight.black')??'#acf5ef')}};

            --bs-body-bg: rgba(var(--bs-body-bg-rgb), 1);
            --bs-body-bg-rgb: {{color_rgb(theme_config('general.colorLight.body')??'#FFFFFF')}};

            /* custom txt */
            --bs-body-color: var(--bs-white);

            /*  custom btn  */
            --primary-btn: {{color_rgb(theme_config('general.colorLight.textbtnprimary') ?? '#ffffff')}};
            --secondary-btn: {{color_rgb(theme_config('general.colorLight.textbtnsecondary') ?? '#212529')}};
            --tertiary-text: {{color_rgb(theme_config('general.colorLight.texttertiary') ?? '#000000')}};

        }
        body[data-bs-theme=dark]{
            --bs-primary: rgba(var(--bs-primary-rgb), 1);
            --bs-primary-rgb: {{color_rgb(theme_config('general.colorDark.primary')??'#ECAF2D')}};
            --bs-primary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorDark.primary')??'#ECAF2D'))}};

            --bs-secondary: rgba(var(--bs-secondary-rgb), 1);
            --bs-secondary-rgb: {{color_rgb(theme_config('general.colorDark.secondary')??'#114f16')}};
            --bs-secondary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorDark.secondary')??'#114f16'))}};

            --bs-tertiary: rgba(var(--bs-secondary-rgb), 1);
            --bs-tertiary-rgb: {{color_rgb(theme_config('general.colorDark.tertiary')??'#f7e2a3')}};
            --bs-tertiary-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorDark.tertiary')??'#f7e2a3'))}};

            --bs-white: rgba(var(--bs-white-rgb), 1);
            --bs-white-rgb: {{color_rgb(theme_config('general.colorDark.white')??'#FFFFFF')}};

            --bs-light: rgba(var(--bs-light-rgb), 1);
            --bs-light-rgb: {{color_rgb(theme_config('general.colorDark.light')??'#1B2B35')}};

            --bs-dark: rgba(var(--bs-dark-rgb), 1);
            --bs-dark-rgb: {{color_rgb(theme_config('general.colorDark.dark')??'#14222b')}};
            --bs-dark-rgb-no_commas: {{RGBnocommas(color_rgb(theme_config('general.colorDark.dark')??'#14222b'))}};

            --bs-black: rgba(var(--bs-black-rgb), 1);
            --bs-black-rgb: {{color_rgb(theme_config('general.colorDark.black')??'#2b6063')}};

            --bs-body-bg: rgba(var(--bs-body-bg-rgb), 1);
            --bs-body-bg-rgb: {{color_rgb(theme_config('general.colorDark.body')??'#05151F')}};

            /* custom txt */
            --bs-body-color: var(--bs-white);

            /*  custom btn  */
            --primary-btn: {{color_rgb(theme_config('general.colorDark.textbtnprimary') ?? '#000000')}};
            --secondary-btn: {{color_rgb(theme_config('general.colorDark.textbtnsecondary') ?? '#FFFFFF')}};
            --tertiary-text: {{color_rgb(theme_config('general.colorDark.texttertiary') ?? '#5d4d1d')}};
        }
        .custom-link{
            background-color:  var(--show-btn);
        }
        .btn-primary, .btn-primary:is(:hover,:active,:focus), .btn-primary i,.btn-primary i:is(:hover,:active,:focus){
            color: rgba(var(--primary-btn), 1);
        }
        .btn-secondary, .btn-secondary:is(:hover,:active,:focus), .btn-secondary i,.btn-secondary i:is(:hover,:active,:focus){
            color: rgba(var(--secondary-btn), 1);
        }
    </style>
</head>

<body class="position-relative"
      @if(!theme_config('general.darktheme.disable'))
          @if(dark_theme( !(theme_config('general.darktheme.preferlight') == 'on' ?? true) )) data-bs-theme="dark" @endif
      @else
          data-bs-theme="{{ theme_config('general.darktheme.preferlight') == 'on' ? 'light':'dark' }}"
      @endif
>

<header>
    @include('elements.navbar')
</header>

<main id="app" class="px-lg-10 d-flex flex-column gap-lg-26 gap-8 mb-md-20 mb-10">
    @yield('app')
</main>

<footer>
    @include('elements.footer')
</footer>

@stack('footer-scripts')

</body>
</html>
