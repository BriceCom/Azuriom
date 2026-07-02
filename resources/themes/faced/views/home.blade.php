@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
        <div class="container px-lg-10">
            @include('components.carousel')
        </div>

        <div class="container px-lg-10">
            @include('components.infos-bento')
        </div>

        <div class="container px-lg-10">
            @include('components.trailer')
        </div>

        <div class="container px-lg-10">
            @include('components.discord')
        </div>
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>
@endpush
