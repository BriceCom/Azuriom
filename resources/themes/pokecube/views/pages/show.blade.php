@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)
@include('elements.section')

@section('content')
<div class="page-content">
    <h1>{{ $page->title }}</h1>
    <div class="page-line"></div>
    <div class="card">
        <div class="card-body">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection