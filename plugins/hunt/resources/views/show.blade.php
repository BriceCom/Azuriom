@extends('layouts.app')

@section('title', trans('hunt::messages.hunt_details', ['hunt' => $hunt->name]))

@push('footer-scripts')
    <script src="{{ plugin_asset('hunt', 'js/hunt.js') }}"></script>
@endpush

@section('content')
    <h1>{{ $hunt->name }}</h1>

    <div>
        <a href="{{ route('hunt.home') }}" class="btn btn-outline-secondary btn-sm mb-4">
            <i class="bi bi-arrow-left"></i> {{ trans('hunt::messages.back_to_hunts') }}
        </a>

        @include('hunt::components.hunt-infos')
    </div>
    @include('hunt::components.leaderboard')
    @include('hunt::components.rewards')
@endsection
