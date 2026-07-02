@extends('layouts.base')

@section('app')
    <main class="py-5 mt-5"
          id="content_{{explode('/', url()->current())[3] ?? ''}}">
        <div class="bg-background__global">
                    <img class="position-absolute w-100 h-100 top-0 start-0 object-cover object-position-center z-n1"
                         src="{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500'}}"
                         alt="{{site_name()}}">
        </div>
        <div class="pt-5">
            <div class="container position-relative container__height-page">
                @include('elements.session-alerts')
                @yield('content')
            </div>
        </div>
    </main>
@endsection
