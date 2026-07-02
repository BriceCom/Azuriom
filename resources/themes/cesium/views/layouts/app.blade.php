@extends('layouts.base')

@section('app')
    <main class="h-full px-8 pt-10 overflow-hidden" id="app">
        @include('elements.session-alerts')

        @yield('content')
    </main>
@endsection
