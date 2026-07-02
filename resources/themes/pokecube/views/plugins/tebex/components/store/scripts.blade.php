<script src="{{ plugin_asset('tebex', 'js/script.js') }}"></script>
@guest
    <script>
        var pseudo = "";
    </script>
@else
    <script>
        var pseudo = "{{ Auth::user()->name }}";
    </script>
@endguest
