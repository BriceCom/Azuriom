@extends('layouts.base')

@section('app')
    <main class="container content my-10">
        @include('elements.session-alerts')

        @yield('content')
    </main>
@endsection
