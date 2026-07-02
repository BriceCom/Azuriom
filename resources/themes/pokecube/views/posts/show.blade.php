@extends('layouts.app')
@section('title', $post->title)

@section('content')

@include('elements.section')

<div class="profile-spacer"></div>

<div class="news-show-wrapper">

    {{-- CADRE PRINCIPAL (infos de la news) --}}
    <div class="news-header-card">

        <h1 class="news-header-title">{{ $post->title }}</h1>

        <p class="news-header-desc">
            {{ $post->description ?? 'Aucune description disponible.' }}
        </p>

        <div class="news-header-meta">

            {{-- Date + heure --}}
            <span class="news-header-date">
                {{ format_date($post->created_at) }} — {{ $post->created_at->format('H:i') }}
            </span>

            {{-- Skin + pseudo auteur --}}
            <div class="news-header-author">
                <img class="news-header-skin"
                     src="https://mc-heads.net/avatar/{{ $post->author->name }}/40">
                <span class="news-header-name">{{ $post->author->name }}</span>
            </div>

        </div>

    </div>

    {{-- CADRE CONTENU DE LA NEWS --}}
    <div class="news-body-card">
        <div class="news-body-content">
            {!! $post->content !!}
        </div>
    </div>

    {{-- SECTION AUTRES ARTICLES --}}
    @if(isset($posts) && $posts->count() > 0)
        <h2 class="news-related-title">Autres articles</h2>

        <div class="news-grid">
            @foreach ($posts as $p)
                <a href="{{ route('posts.show', $p->slug) }}" class="news-card-link">
                    <div class="news-card">

                        @if ($p->hasImage())
                            <img src="{{ $p->imageUrl() }}" class="news-image">
                        @endif

                        <div class="news-content">
                            <h3 class="news-card-title">{{ $p->title }}</h3>
                            <span class="news-date">{{ format_date($p->created_at) }}</span>
                        </div>

                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>

<div class="profile-bottom-spacer"></div>

@endsection
