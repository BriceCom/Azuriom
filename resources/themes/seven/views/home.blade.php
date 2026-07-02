@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="d-flex flex-column gap-10 my-10">
        @if(theme_config('home.index.carousel.off') !== 'on')
            <div class="container px-lg-4">
                @include('components.carousel')
            </div>
        @endif

        @if(theme_config('home.bentobox.off') !== 'on')
            <div class="container px-lg-4">
                @include('components.infos-bento')
            </div>
        @endif


        <div class="container px-lg-4">
            @include('components.trailer')
        </div>

        @if(theme_config('home.discord.off') !== 'on')
            <div class="container px-lg-4">
                @include('components.discord')
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>
@endpush
