@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main id="plug" class="container content mb-10 mt-2">
        <div id="{{$plugname}}"  class="d-flex flex-column gap-7">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
