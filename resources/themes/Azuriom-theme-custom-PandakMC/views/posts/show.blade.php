@extends('layouts.app')
@php
    $insideBrackets='';
    $hex='';
    $tag='';
            if (preg_match('/\[(.*?)\]/', $post->title, $matches)) {
                $insideBrackets = $matches[1];

                // Isoler le code HEX avec le format #rrggbb
                if (preg_match('/#([0-9a-fA-F]{6})/', $insideBrackets, $hexMatches)) {
                    $hex = $hexMatches[1];
                }

                // Isoler le reste du mot après le code HEX
                $tag = preg_replace('/#([0-9a-fA-F]{6})_/', '', $insideBrackets);
            }

        $text = preg_replace('/\[.*?\]/', '',  $post->title);
@endphp
@section('title', $text)
@section('description', $post->description)
@section('type', 'article')

@push('meta')
<meta property="og:article:author:username" content="{{ $post->author->name }}">
<meta property="og:article:published_time" content="{{ $post->published_at->toIso8601String() }}">
<meta property="og:article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@section('content')

    @if(!$post->isPublished())
        <div class="alert alert-info mb-5" role="alert">
            <i class="bi bi-info-circle"></i> {{ trans('messages.posts.unpublished') }}
        </div>
    @endif

    <div>
            <h1>{{ $text }}</h1>

            <span class="article__tag">@if($tag)<span class="tag" style="background-color: {{'#' . $hex}}">{{$tag}}</span> - @endif{{$post->published_at->format('d/m/Y')}}</span>

        @if($post->hasImage())
            <div class="article__img">
                <img class="mb-3" width="540" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
            </div>
        @endif
            {!! $post->content !!}
    </div>
@endsection
