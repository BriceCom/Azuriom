@extends('layouts.app')

@section('title', trans('messages.posts.posts'))

@section('content')

@include('elements.section')

<h1 class="news-list-title">{{ trans('messages.posts.posts') }}</h1>

<div class="news-list-wrapper">

    @foreach($posts as $post)

        <div class="news-list-card">

            {{-- Image --}}
            @if($post->hasImage())
                <img src="{{ $post->imageUrl() }}" class="news-list-image" alt="{{ $post->title }}">
            @endif

            {{-- Contenu principal --}}
            <div class="news-list-content">

                <h2 class="news-list-title-item">
                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>

                <p class="news-list-desc">
                    {{ Str::limit(strip_tags($post->content), 180) }}
                </p>

                <div class="news-list-meta">

                    {{-- Date + heure --}}
                    <span class="news-list-date">
                        {{ format_date($post->created_at) }} — {{ $post->created_at->format('H:i') }}
                    </span>

                    {{-- Auteur --}}
                    <div class="news-list-author">
                        <img class="news-list-skin"
                             src="https://mc-heads.net/avatar/{{ $post->author->name }}/40">
                        <span class="news-list-name">{{ $post->author->name }}</span>
                    </div>

                </div>

                <a href="{{ route('posts.show', $post->slug) }}" class="news-list-button">
                    Lire l’article
                </a>

            </div>

        </div>

    @endforeach

</div>

@endsection
