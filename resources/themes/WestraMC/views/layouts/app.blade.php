@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
    <main class="container content my-10">
        <div id="{{$plugname}}">
            @if($plugname != "vote")
                @include('elements.session-alerts')
            @endif

            @yield('content')
        </div>
    </main>
@endsection
