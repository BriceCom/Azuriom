@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
    <h1>{{ $page->title }}</h1>

    <div class="card">
        <div class="card-body">
            {!! $page->content !!}
        </div>
    </div>

    @if (request()->route()->parameter('path') === "search")
        @include('custom-page.search')
    @endif
@endsection
