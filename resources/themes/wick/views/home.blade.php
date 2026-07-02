@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')

<h1>hello world</h1>
    <canvas class="webgl"></canvas>
    <canvas class="webgl2"></canvas>
@endsection

@push('scripts')
    <script type="module" src="{{theme_asset('js/webgl.js')}}"></script>
@endpush

