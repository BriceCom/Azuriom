@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
    <main>
        <div style="
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 0%, #121212 100%),
                    linear-gradient(0deg, rgba(18, 18, 18, 0.35) 0%, rgba(18, 18, 18, 0.35) 100%),
                    url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;
                    height: 350px;
        ">
        </div>
        <div id="{{$plugname}}" class="container content mb-8">
            <div class="alert-wrapper position-relative">
                @include('elements.session-alerts')
            </div>
            @yield('content')
        </div>
    </main>
@endsection
