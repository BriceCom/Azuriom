@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main id="content" class="d-flex flex-column gap-10 my-15">
        <h1 class="d-none">{{ site_name() }}</h1>

        @include('components.news')

        @include('components.cta-separator')

        @include('components.cta')
    </main>
@endsection
