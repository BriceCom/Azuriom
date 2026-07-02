@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main class="container content">
        <div id="{{$plugname}}">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
