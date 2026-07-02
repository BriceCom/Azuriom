@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
    <div class="pageTitle">
        <h1>{{ $page->title }}</h1>
        @if($page->description)
            <p class="fw-normal text-light">{{$page->description}}</p>
        @endif
    </div>
    <div class="card">
        <div class="card-body rounded-3 border border-primary border-2 pageContent">
            {!! $page->content !!}
        </div>
    </div>
@endsection
