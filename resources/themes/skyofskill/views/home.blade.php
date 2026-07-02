@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main id="content" class="container mx-auto d-flex flex-column gap-lg-30 gap-7 my-7 my-lg-30">
        @include('components.welcome')

        @include('components.carousel')

        @include('components.hym')

        @include('components.howToJoin')
    </main>
@endsection
