@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main id="content" class="d-flex flex-column">
        @include('components.news')

        @include('components.join-with-faq')

        @include('components.discord-section')

        @include('components.stats')

        @include('components.events')
    </main>
@endsection
