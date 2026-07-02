@extends('layouts.base')

@section('app')
    <main class="container my-10">
        <div class="background">
            <div class="background-wrapper overflow-hidden">
                <img class="object-fit-cover" tabindex="-1" src="{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}" alt="Illustration du jeu Minecraft">
                <div class="background-gradient"></div>
            </div>
        </div>
        <div class="content">
            @include('elements.session-alerts')

            @yield('content')
        </div>
        <div class="footer-gradient-circle gradient-circle"></div>
    </main>
    @include('elements.footer')
@endsection
