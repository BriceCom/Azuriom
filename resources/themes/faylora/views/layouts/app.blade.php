@extends('layouts.base')

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    @include('elements.session-alerts')

    @yield('content')
</main>
@endsection