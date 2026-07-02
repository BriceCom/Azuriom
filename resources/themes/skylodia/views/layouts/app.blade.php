@extends('layouts.base')

@php
    $plugname = request()->route()->uri;

    $plugname = str_replace(['/','{','}'],['_', '', ''],$plugname);

@endphp

@section('app')
        <main class="position-relative py-md-10">

            <div class="app-background position-absolute top-0 right-0 left-0 w-100"  style="background: url('{{ setting('background') ? theme_asset('images/bgskylodia_2.jpg') : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;
            height:800px">

            </div>
            <div id="{{$plugname}}" class="container py-5 py-md-10 pt-md-15">
                @include('elements.session-alerts')

                @yield('content')
            </div>

        </main>

@endsection
