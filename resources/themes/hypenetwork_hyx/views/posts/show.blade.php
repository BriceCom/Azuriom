@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->description)
@section('type', 'article')

@push('meta')
<meta property="og:article:author:username" content="{{ $post->author->name }}">
<meta property="og:article:published_time" content="{{ $post->published_at->toIso8601String() }}">
<meta property="og:article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@section('content')
    @php($reading = floor(Str::wordCount($post->content) / 200))

    @if(!$post->isPublished())
        <div class="alert alert-info mb-5" role="alert">
            <i class="bi bi-info-circle"></i> {{ trans('messages.posts.unpublished') }}
        </div>
    @endif


    <section class="article__header container-fluid d-flex flex-column flex-xl-row align-items-md-center justify-content-between gap-6">
           <div class="article__title text-xl">
               <span class="d-block mb-5"><span class="article__date">Le {{format_date($post->published_at)}}</span>  {{$reading >= 1 ? $reading:"Moins d'une"}} minute{{$reading > 1 ? 's' : ''}}</span>
               <h1>{{ $post->title }}</h1>
           </div>

           @if($post->hasImage())
               <div class="article__img">
                   <img class="mb-3" height="540" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
               </div>
           @endif
   </section>

    <div class="article__text mx-auto">
        {!! $post->content !!}
    </div>

    <section>
        @include('components.join')
    </section>
@endsection
