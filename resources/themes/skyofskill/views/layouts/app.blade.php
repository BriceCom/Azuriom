@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main id="plug" class="container content my-7 my-md-11">
        @include('elements.session-alerts')

        <div id="{{$plugname}}" class="d-flex flex-column gap-7">
            @yield('content')
        </div>
    </main>
@endsection
