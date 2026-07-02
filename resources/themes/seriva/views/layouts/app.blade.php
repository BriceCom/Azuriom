@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <main id="plug" class="container-xl py-4 py-lg-5">
        @include('elements.session-alerts')

        <div id="{{ $plugname }}" class="seriva-content d-flex flex-column gap-4">
            @yield('content')
        </div>
    </main>
@endsection
