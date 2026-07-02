@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
    <main id="app" class="container bg-body">
        <div class="py-10">
            @include('elements.session-alerts')
        </div>

        <div id="{{$plugname}}" class="d-flex flex-column gap-18 gap-xxl-26">

            @yield('content')
        </div>
    </main>
@endsection
