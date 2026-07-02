@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
    <main class="container content mt-5 my-10">
        <div id="{{$plugname}}" class="bg-dark p-4 rounded-3">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
