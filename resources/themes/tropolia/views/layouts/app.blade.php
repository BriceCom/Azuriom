@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main id="plug" class="container content my-15">
        <div id="{{$plugname}}" class="d-flex flex-column gap-7">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
