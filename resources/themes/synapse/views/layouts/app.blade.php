@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
    <main class="container-fuid px-4 px-md-8">
        <div id="{{$plugname}}">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
