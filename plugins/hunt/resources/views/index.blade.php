@extends('layouts.app')

@section('title', trans('hunt::messages.title'))

@push('footer-scripts')
    <script src="{{ plugin_asset('hunt', 'js/hunt.js') }}"></script>
@endpush

@section('content')
    <h1>{{trans('hunt::messages.title')}}</h1>

    <div class="row" id="hunt">
        @foreach($allHunts as $hunt)
            @include('hunt::components.hunt-card', ['hunt' => $hunt])
        @endforeach
    </div>
@endsection
