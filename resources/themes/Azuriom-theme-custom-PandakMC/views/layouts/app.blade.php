@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
    <main class="container content my-10">
        <section class="hero d-flex align-items-center justify-content-center flex-column text-white">
            <div class="hero__bg" style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;"></div>
        </section>

        <div id="{{$plugname}}">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
