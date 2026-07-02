@extends('layouts.base')

@section('app')
    <main class="container my-10">
        <div class="content">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
