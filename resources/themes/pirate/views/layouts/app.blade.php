@extends('layouts.base')

@section('app')
    <header class="header overflow-hidden">
        @include('elements.navbar')

        <div class="d-flex justify-content-center pt-3 pb-5">
            <div class="position-relative header-logo">
                <img src="{{ site_logo() }}" class="img-fluid d-block mx-auto logo" alt="{{ site_name() }}">
            </div>
        </div>

        @include('elements.waves')
    </header>

    <main class="content">
        <div class="container">
            @include('elements.session-alerts')

            @yield('content')
        </div>

        <div id="particles-js"></div>
    </main>
@endsection
