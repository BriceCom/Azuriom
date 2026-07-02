<!DOCTYPE html>
@include('elements.base')
@php
    $version_theme = json_decode(file_get_contents(theme_path().'/theme.json'), true);

    function hexToRGB($theme_path){return implode(", ", sscanf($theme_path, "#%02x%02x%02x"));}
    function RGBnocommas($rgb){return str_replace(',', '', $rgb);}
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom, Dixept">
    <meta name="publisher" content="{{site_name()}}, Dixept">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:image:alt" content="Favicon {{site_name()}}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
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
    <script src="{{theme_asset('js/app.js')}}" defer></script>

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link rel="preload" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css').'?ver='.$version_theme['version'] }}"></noscript>
    <link href="{{ theme_asset('css/styles.css').'?ver='.$version_theme['version'] }}" rel="stylesheet">
    @stack('styles')
    <style>
        @if( theme_config('general.font.toggle'))
            @import url({{theme_config('general.font.url') ?? 'https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,700i,800,900&display=swap'}});
            body{
                font-family: "{{theme_config('general.font.text') ?? 'Poppins'}}", sans-serif;
            }
        @endif

        body:not([data-bs-theme=dark]){
            --bs-primary: rgba(var(--bs-primary-rgb), 1);
            --bs-primary-rgb: {{hexToRGB(theme_config('general.colorLight.primary')??'#661F10')}};
            --bs-primary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('general.colorLight.primary')??'#661F10'))}};

            --bs-secondary: rgba(var(--bs-secondary-rgb), 1);
            --bs-secondary-rgb: {{hexToRGB(theme_config('general.colorLight.secondary')??'#6C757D')}};
            --bs-secondary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('general.colorLight.secondary')??'#6C757D'))}};

            --bs-white: rgba(var(--bs-white-rgb), 1);
            --bs-white-rgb: {{hexToRGB(theme_config('general.colorLight.white')??'#212529')}};

            --bs-light: rgba(var(--bs-light-rgb), 1);
            --bs-light-rgb: {{hexToRGB(theme_config('general.colorLight.light')??'#dddddd')}};

            --bs-dark: rgba(var(--bs-dark-rgb), 1);
            --bs-dark-rgb: {{hexToRGB(theme_config('general.colorLight.dark')??'#F8F9FA')}};
            --bs-dark-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('general.colorLight.dark')??'#F8F9FA'))}};

            --bs-black: rgba(var(--bs-black-rgb), 1);
            --bs-black-rgb: {{hexToRGB(theme_config('general.colorLight.black')??'#dfdfdf')}};

            --bs-body-bg: rgba(var(--bs-body-bg-rgb), 1);
            --bs-body-bg-rgb: {{hexToRGB(theme_config('general.colorLight.body')??'#ededed')}};

            /* custom txt */
            --bs-body-colorLight: var(--bs-white);

            /*  custom btn  */
            --primary-btn: {{hexToRGB(theme_config('general.colorLight.textbtnprimary') ?? '#ffffff')}};
            --secondary-btn: {{hexToRGB(theme_config('general.colorLight.textbtnsecondary') ?? 'var(--bs-white)')}};

            /* btn important */
            --show-btn: {{theme_config('general.colorLight.show') ?? '#ECAF2D'}};

        }
        body[data-bs-theme=dark]{
            --bs-primary: rgba(var(--bs-primary-rgb), 1);
            --bs-primary-rgb: {{hexToRGB(theme_config('general.colorDark.primary')??'#ECAF2D')}};
            --bs-primary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('general.colorDark.primary')??'#ECAF2D'))}};

            --bs-secondary: rgba(var(--bs-secondary-rgb), 1);
            --bs-secondary-rgb: {{hexToRGB(theme_config('general.colorDark.secondary')??'#6C757D')}};
            --bs-secondary-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('general.colorDark.secondary')??'#6C757D'))}};

            --bs-white: rgba(var(--bs-white-rgb), 1);
            --bs-white-rgb: {{hexToRGB(theme_config('general.colorDark.white')??'#E5E5E5')}};

            --bs-light: rgba(var(--bs-light-rgb), 1);
            --bs-light-rgb: {{hexToRGB(theme_config('general.colorDark.light')??'#1B2B35')}};

            --bs-dark: rgba(var(--bs-dark-rgb), 1);
            --bs-dark-rgb: {{hexToRGB(theme_config('general.colorDark.dark')??'#14222b')}};
            --bs-dark-rgb-no_commas: {{RGBnocommas(hexToRGB(theme_config('general.colorDark.dark')??'#14222b'))}};

            --bs-black: rgba(var(--bs-black-rgb), 1);
            --bs-black-rgb: {{hexToRGB(theme_config('general.colorDark.black')??'#030f16')}};

            --bs-body-bg: rgba(var(--bs-body-bg-rgb), 1);
            --bs-body-bg-rgb: {{hexToRGB(theme_config('general.colorDark.body')??'#05151F')}};

            /* custom txt */
            --bs-body-colorDark: var(--bs-white);

            /*  custom btn  */
            --primary-btn: {{hexToRGB(theme_config('general.colorDark.textbtnprimary') ?? '#000000')}};
            --secondary-btn: {{hexToRGB(theme_config('general.colorDark.textbtnsecondary') ?? 'var(--bs-white)')}};

            /* btn important */
            --show-btn: {{theme_config('general.colorDark.show') ?? '#DD1919'}};
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
<body
    @if(!theme_config('general.darktheme.disable'))
        @if(dark_theme( !(theme_config('general.darktheme.preferlight') == 'on' ?? true) )) data-bs-theme="dark" @endif
    @else
        data-bs-theme="{{ theme_config('general.darktheme.preferlight') == 'on' ? 'light':'dark' }}"
    @endif
>

<div id="app">
    <div style="
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 0%, var(--bs-body-bg) 100%),
                    linear-gradient(0deg, rgba(18, 18, 18, 0.35) 0%, rgba(18, 18, 18, 0.35) 100%),
                    url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;
                    height: 400px;
        "
        class="postion-relative d-flex justify-content-center">
        @if(!theme_config('general.darktheme.disable'))
            <ul id="sunlight" class="position-absolute list-unstyled">
                @include('elements.theme-selector')
            </ul>
        @endif
        <div class="d-flex justify-content-center container">
            <div class="row justify-content-center align-items-center gx-3 flex-grow-1 py-4 md:py-0">
                @if(!theme_config('hero.server.toggle'))
                    <div class="col-md-4 d-flex justify-content-{{theme_config('hero.discord.justify') ?? 'center'}}">
                        <a id="copyButton" href="#" class="d-flex flex-column text-decoration-none">
                            <div class="d-flex">
                                <p class="bg-primary fw-semibold text-dark px-2 py-1 rounded-pill mb-1">
                                    @php
                                        $totalPlayers = $servers->where('home_display', true)->sum(function($server) {
                                            return $server->isOnline() ? $server->getOnlinePlayers() : 0;
                                            });
                                    @endphp

                                    {{$totalPlayers}}
                                </p>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <div>
                                    @if(!theme_config('hero.server.icon'))
                                        <svg role="presentation" viewBox="0 0 24 24" height="50" width="50">
                                            <path d="M4,2H20A2,2 0 0,1 22,4V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V4A2,2 0 0,1 4,2M6,6V10H10V12H8V18H10V16H14V18H16V12H14V10H18V6H14V10H10V6H6Z" style="fill: currentcolor;">
                                            </path>
                                        </svg>
                                    @else
                                        <i class="{{theme_config('hero.server.icon') ?? 'bi bi-controller'}} h1"></i>
                                    @endif
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-uppercase fw-semibold">{{theme_config('hero.server.text') ?? 'play.servername.fr'}}</span>
                                    <small id="copyButton_text" class="text-white text-uppercase fw-semibold">{{theme_config('hero.server.subtext') ?? trans('theme::theme.general.server-button.subtext')}}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <div class="col-md-4 text-center">
                    <a href="/">
                        <img class="hero-logo w-100 img-fluid" src="{{site_logo()}}" alt="{{trans('theme::theme.home.logo_of', ['site_name' => site_name()])}}">
                    </a>
                </div>
                @if(!theme_config('hero.discord.toggle'))
                    <div class="col-md-4 d-flex justify-content-{{theme_config('hero.discord.justify') ?? 'center'}}">
                        <a href="{{theme_config('hero.discord.url') ?? 'https://discord.gg/Gh2yBxUWvV'}}" target="_blank" class="d-flex flex-column text-decoration-none">
                            <div class="d-flex justify-content-end">
                                <p id="discordCount" class="bg-primary fw-semibold text-dark px-3 py-1 rounded-pill mb-1">0</p>
                                @include('components.general.discordAPI')
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex flex-column text-end">
                                    <span class="text-uppercase fw-semibold">{{theme_config('hero.discord.text') ?? trans('theme::theme.general.discord-button.text')}}</span>
                                    <small class="text-white text-uppercase fw-semibold">{{theme_config('hero.discord.subtext') ?? trans('theme::theme.general.discord-button.subtext')}}</small>
                                </div>
                                <div>
                                    <i class="{{ theme_config('hero.discord.icon') ?? 'bi bi-discord' }} h1"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @push('footer-scripts')
            <script type="text/javascript">
                var copyButton = document.getElementById("copyButton");
                var copyButton_text = document.getElementById("copyButton_text");

                copyButton.addEventListener("click", function() {
                    var textToCopy = '{!! theme_config('hero.server.ip') ? theme_config('hero.server.ip'):'play.servername.fr'!!}';

                    // Création d'un élément temporaire pour la copie du texte
                    var tempInput = document.createElement("input");
                    tempInput.setAttribute("value", textToCopy);
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);

                    let tempText = copyButton_text.innerText;
                    let widthOfText = copyButton_text.offsetWidth
                    copyButton_text.style.width = widthOfText+'px';
                    copyButton_text.innerText = "{{theme_config('hero.server.textcopied') ?? trans('theme::theme.general.server-button.ipCopied')}}"

                    setTimeout(function() {
                        copyButton_text.innerText = tempText;
                        copyButton_text.style.width = 'auto';
                    }, 2000);
                });
            </script>
        @endpush
    </div>
    <header class="container">
        @include('elements.navbar')
    </header>

    @yield('app')
</div>

<footer>
    @include('elements.footer')
</footer>

@include('components.oauth.oauth-script')
@stack('footer-scripts')

</body>
</html>
