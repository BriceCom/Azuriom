<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- SEO MAX -->
    <meta name="robots" content="follow, index, all"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ favicon() }}">
    <meta name="msapplication-TileImage" content="{{ favicon() }}">
    <meta name="msapplication-TileColor" content="#3490DC">
    <link rel="canonical" href="{{url()->current()}}">

    <!-- SEO BON -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{'@'.site_name()}}">
    <meta name="twitter:creator" content="{{'@'.site_name()}}">
    <meta name="twitter:creator:id" content="{{'@'.site_name()}}">
    <meta name="twitter:title" content="{{site_name()}} | @yield('title')">
    <meta name="twitter:description" content="@yield('description', setting('description', ''))">
    <meta name="twitter:image" content="{{ favicon() }}">

    <!-- SEO MIN -->
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
    <script type="text/javascript">
        window.N2PRO = 1;
        window.N2GSAP = 1;
        window.N2PLATFORM = "wordpress";
        (function () {
            var N = this;
            N.N2_ = N.N2_ || {
                r: [],
                d: []
            }, N.N2R = N.N2R || function () {
                N.N2_.r.push(arguments)
            }, N.N2D = N.N2D || function () {
                N.N2_.d.push(arguments)
            }
        }).call(window);
        if (!window.n2jQuery) {
            window.n2jQuery = {
                ready: function (cb) {
                    console.error('n2jQuery will be deprecated!');
                    N2R(['$'], cb);
                }
            }
        }
        window.nextend = {
            localization: {},
            ready: function (cb) {
                console.error('nextend.ready will be deprecated!');
                N2R('documentReady', function ($) {
                    cb.call(window, $)
                })
            }
        };
        window.N2SSPRO = 1;
        window.N2SS3C = "smartslider3";
        nextend.fontsLoaded = false;
        nextend.fontsLoadedActive = function () {
            nextend.fontsLoaded = true;
        };
        var fontData = {
            google: {
                families: ["Roboto:300,400:latin"]
            },
            active: function () {
                nextend.fontsLoadedActive()
            },
            inactive: function () {
                nextend.fontsLoadedActive()
            }
        };
        if (typeof WebFontConfig !== 'undefined') {
            var _WebFontConfig = WebFontConfig;
            for (var k in WebFontConfig) {
                if (k == 'active') {
                    fontData.active = function () {
                        nextend.fontsLoadedActive();
                        _WebFontConfig.active();
                    }
                } else if (k == 'inactive') {
                    fontData.inactive = function () {
                        nextend.fontsLoadedActive();
                        _WebFontConfig.inactive();
                    }
                } else if (k == 'google') {
                    if (typeof WebFontConfig.google.families !== 'undefined') {
                        for (var i = 0; i < WebFontConfig.google.families.length; i++) {
                            fontData.google.families.push(WebFontConfig.google.families[i]);
                        }
                    }
                } else {
                    fontData[k] = WebFontConfig[k];
                }
            }
        }
        if (typeof WebFont === 'undefined') {
            window.WebFontConfig = fontData;
        } else {
            WebFont.load(fontData);
        }
    </script>
    <script type="text/javascript" src="{{theme_asset("/plugins/slider/js/n2-j.min.js")}}"></script>
    <script type="text/javascript" src="{{theme_asset("/plugins/slider/js/nextend-gsap.min.js")}}"></script>
    <script type="text/javascript" src="{{theme_asset("/plugins/slider/js/nextend-frontend.min.js")}}"></script>
    <script type="text/javascript" src="{{theme_asset("/plugins/slider/js/smartslider-frontend.min.js")}}"></script>
    <script type="text/javascript" src="{{theme_asset("/plugins/slider/js/smartslider-simple-type-frontend.min.js")}}"></script>
    <script type="text/javascript" src="{{theme_asset("/plugins/slider/js/nextend-webfontloader.min.js")}}"></script>
    <script type="text/javascript">
        N2R('documentReady', function ($) {

            nextend.fontsDeferred = $.Deferred();
            if (nextend.fontsLoaded) {
                nextend.fontsDeferred.resolve();
            } else {
                nextend.fontsLoadedActive = function () {
                    nextend.fontsLoaded = true;
                    nextend.fontsDeferred.resolve();
                };
                var intercalCounter = 0;
                nextend.fontInterval = setInterval(function () {
                    if (intercalCounter > 3 || document.documentElement.className.indexOf('wf-active') !==
                        -1) {
                        nextend.fontsLoadedActive();
                        clearInterval(nextend.fontInterval);
                    }
                    intercalCounter++;
                }, 1000);
            }
        });
    </script>
    <script>
        @php
            $pages = Azuriom\Models\Page::all();
            $wikis = \Azuriom\Plugin\Wiki\Models\Page::with('category')->get();

//            dd($wikis)
        @endphp

        let pages = {!! json_encode($pages) !!};
        let wikis = {!! json_encode($wikis) !!};
    </script>
    <script src="{{ theme_asset('js/search.js') }}" defer></script>
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Styles -->
    <!-- Icons -->
    <link rel="stylesheet" href="{{theme_asset("fonts/css/font-awesome.min.css")}}" />

    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{theme_asset("/plugins/animate.css-master/animate.min.css")}}">

    <!-- Light Box -->
    <link href="{{theme_asset("/plugins/lightbox2-master/dist/css/lightbox.css")}}" rel="stylesheet">

    <!-- Sliders -->
    <link rel="stylesheet" type="text/css" href="{{theme_asset("/plugins/slick-1.8.0/slick/slick.css")}}" />
    <link rel="stylesheet" type="text/css" href="{{theme_asset("/plugins/slick-1.8.0/slick/slick-theme.css")}}" />
    <link rel="stylesheet" type="text/css" href="{{theme_asset("/plugins/slider/css/normalize.min.css") }}" media="screen, print" />
    <link rel="stylesheet" type="text/css" href="{{theme_asset("/plugins/slider/css/smartslider.min.css")}}" media="screen, print" />

    <style type="text/css">
        .n2-ss-spinner-simple-white-container {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -20px;
            background: #fff;
            width: 20px;
            height: 20px;
            padding: 10px;
            border-radius: 50%;
            z-index: 1000;
        }

        .n2-ss-spinner-simple-white {
            outline: 1px solid RGBA(0, 0, 0, 0);
            width: 100%;
            height: 100%;
        }

        .n2-ss-spinner-simple-white:before {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-top: -11px;
            margin-left: -11px;
        }

        .n2-ss-spinner-simple-white:not(:required):before {
            content: '';
            border-radius: 50%;
            border-top: 2px solid #333;
            border-right: 2px solid transparent;
            animation: n2SimpleWhite .6s linear infinite;
            -webkit-animation: n2SimpleWhite .6s linear infinite;
        }

        @keyframes n2SimpleWhite {
            to {
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes n2SimpleWhite {
            to {
                -webkit-transform: rotate(360deg);
            }
        }
    </style>

    <link rel="preload" href="{{ theme_asset('css/override_bootstrap.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ theme_asset('css/override_bootstrap.css') }}"></noscript>
    <link href="{{ theme_asset('css/styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body data-bs-theme="dark">

<div id="app">
    @include('elements.navbar')

    @yield('app')
</div>

@include('elements.footer')

<script src="{{theme_asset("/js/tf/jquery-3.3.1.min.js")}}"></script>
<script src="{{theme_asset("/plugins/slick-1.8.0/slick/slick.min.js")}}"></script>
{{--<script src="{{theme_asset("/plugins/flex-menu/flexmenu.min.js")}}"></script>--}}
<script src="{{theme_asset("/plugins/jquery-match-height-master/dist/jquery.matchHeight.js")}}"></script>
<script src="{{theme_asset("/plugins/paroller.js-master/dist/jquery.paroller.min.js")}}"></script>
<script src="{{theme_asset("/plugins/lightbox2-master/dist/js/lightbox.js")}}"></script>
<script src="{{theme_asset("/plugins/wow-master/dist/wow.min.js")}}"></script>
<script src="{{theme_asset("/js/tf/script.js")}}"></script>
@stack('footer-scripts')

</body>
</html>
