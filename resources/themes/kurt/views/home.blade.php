@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main class="d-flex flex-column gap-15 gap-md-30 my-15 my-md-30">

        @include('components.trailer')

        @include('components.news')

        @include('components.cta')

        @include('components.trusts')

        @include('components.stats')
    </main>
@endsection
