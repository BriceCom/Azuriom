<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="{{ config('theme.color') }}">
    <meta name="author" content="Azuriom, Antoine Coll#1253">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
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
    <script src="{{ theme_asset('js/jquery-1.11.0.js') }}"></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style type="text/css">
        :root{
            --main-color:  {{ config('theme.color') }};
            --main-color-95:  {{ config('theme.color') }}95;
        }
        i{
            vertical-align: text-bottom;
        }
    </style>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <div id="app">
        <header>
            @include('elements.navbar')
        </header>

        <div class="app" >@yield('app')</div>

        <div class="banner" style="background-image: url({{ setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500' }})">
            <div class="filter" align="center">
                <span>Rejoins les <span class="playercount">0</span> joueurs connectés sur <span class='ip' onclick="copyToClipboard('.ip')"> play.herodia.fr</span> !</span>
            </div>
        </div>
    </div>

<footer class="text-white py-4 text-center">
    <div class="copyright">
        {{ setting('copyright') }} | <a href="/cgu">CGU</a> | <a href="/cgv">CGV</a> | @lang('messages.copyright')
    </div>
</footer>

<script type="text/javascript">

window.onscroll = function() {brightness()};

function brightness() {
  const scrollRate = (window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0)/(window.innerHeight*1.25);
  document.getElementById("background").style.backgroundColor = "rgba(0,0,0," + scrollRate + ")";
}

function isOnScreen(elem) {
    if( elem.length == 0 ) return;

    var $window = jQuery(window)
    var viewport_top = $window.scrollTop()
    var viewport_height = $window.height()
    var viewport_bottom = viewport_top + viewport_height
    var $elem = jQuery(elem)
    var top = $elem.offset().top
    var height = $elem.height()
    var bottom = top + height

    return (top >= viewport_top && top < viewport_bottom) ||
    (bottom > viewport_top && bottom <= viewport_bottom) ||
    (height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
}

$(window).scroll(function () {
    $('.toAnimate').each(function () {
        if (isOnScreen($(this))) $(this).addClass("animate");
    });
});

function showMenu() {
  document.getElementById("menuPhone").classList.toggle("phone-hide");
}

</script>

@if (!request()->is('/'))
<script type="text/javascript">
    $(document).ready(function () {
    $('html, body').animate({
        scrollTop: ($('#content').offset().top - 100)
    }, 'slow');
});
</script>
@endif

<script src="{{ theme_asset('js/jquery-1.11.0.js') }}"></script>
<script type="text/javascript" defer>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $(element).text("Adresse copiée");
        setTimeout(function(){
            $(element).text("play.herodia.fr");
        }, 2500);
    }

    $.get('https://eu.mc-api.net/v3/server/ping/play.herodia.fr', function(a){
      $('.playercount').html(a.players.online);
    });

    $.get('https://canary.discord.com/api/guilds/616215642114228225/widget.json', function(b){
      $('.discordcount').html(b.presence_count);
    });
</script>

@stack('footer-scripts')
</body>
</html>
