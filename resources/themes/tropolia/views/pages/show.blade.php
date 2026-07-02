@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
    <hgroup>
        <h1 class="mb-2 text-uppercase">{{ $page->title }}</h1>
        <p>{{$page->description}}</p>
    </hgroup>

    <div class="card">
        <div class="card-body">
            {!! $page->content !!}
        </div>
    </div>
@endsection
