@extends('layouts.base')

@section('app')
    <header class="position-relative" style="height: 320px;">
        @include('elements.navbar')
        <div class="background">
            <div class="background-wrapper overflow-hidden">
                <img class="object-fit-cover" tabindex="-1" src="{{ setting('background') ? image_url(setting('background')) : 'https://cdn.rinaorc.com/banner_blur.png' }}" alt="Illustration du jeu Minecraft">
            </div>
        </div>
    </header>
    <main class="container my-10">
        <div class="content">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
