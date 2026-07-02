@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
    <hgroup>
        <h1 class="mb-2 text-uppercase">{{ $page->title }}</h1>
            <p>{{$page->description}}</p>
    </hgroup>

    @if($page->slug === "nous-rejoindre")
        <div>
            @include('components.join', ['content' => $page->content, "reverse" => true ])
        </div>


        <div class="card">
            <div class="card-body">
                <div class="col-lg-6">
                    @include('components.faq')
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                {!! $page->content !!}
            </div>
        </div>
    @endif
@endsection
