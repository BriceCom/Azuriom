@extends('layouts.base')

@section('app')
    <main class="container content my-10">
        <div id="{{request()->route()->uri}}">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
