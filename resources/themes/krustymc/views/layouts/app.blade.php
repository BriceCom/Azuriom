@extends('layouts.base')

@php
    $plugname = request()->route()->uri;
    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);
@endphp

@section('app')
    <section class="hero position-relative d-flex align-items-center justify-content-center flex-column text-white">
        <div class="hero__bg" style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;"></div>

        <div class="hero__img mb-4">
            <img height="200" src="{{ setting('logo') ? image_url(setting('logo')) : 'https://via.placeholder.com/300x300' }}" alt="{{ setting('title') }}">
        </div>

        <div class="d-flex flex-column align-items-end gap-1">
            @include('components.ip-and-connected')
            <small>
                <b>Cliquez pour copier l'ip !</b>
            </small>
        </div>

        <div class="hero-clip"></div>
    </section>
    <main class="container content mt-10 pt-md-15">
        <div id="{{$plugname}}"  class="d-flex flex-column gap-4">
            @include('elements.session-alerts')

            @yield('content')
        </div>
    </main>
@endsection
