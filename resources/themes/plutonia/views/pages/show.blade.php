@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
  <section class="page-top">
    <h2>{{ $page->title }}</h2>
    <div class="block"></div>
  </section>

    <div class="card">
        <div class="card-body">
            {!! $page->content !!}
        </div>
    </div>
@endsection
