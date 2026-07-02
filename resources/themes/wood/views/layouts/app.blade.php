@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main class="container content my-10">
        <div id="{{$plugname}}"  class="d-flex flex-column gap-4">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
