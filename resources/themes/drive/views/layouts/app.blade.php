@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main id="plug" class="drive-page">
        @include('elements.session-alerts')

        <div id="{{$plugname}}" class="drive-page__inner">
            @yield('content')
        </div>
    </main>
@endsection
