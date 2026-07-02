@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main id="home" class="container">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mb-md-0">
                        <h1 title="Bienvenue sur le site de {{site_name()}}">Bienvenue</h1>
                        <a href="/news" class="w-fit d-flex align-items-center gap-2 btn btn-primary text-xs text-uppercase"><i class="bi bi-megaphone-fill"></i>Tous les articles</a>
                </div>
                <div class="row gap-5">
                    @foreach($posts->take(3) as $post)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0 text-white-25 text-sm d-flex justify-content-between">
                                    <div>
                                        <span>{{$post->author->name}}, le {{format_date($post->published_at)}}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                    <span><i
                                            class="d-inline bi bi-chat-fill me-1"></i>{{$post->comments->count()}}</span>
                                        <span><i class="d-inline bi bi-heart-fill me-1"></i>{{$post->likes->count()}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($post->hasImage())
                                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                             class="card-img-top rounded-3">
                                    @endif
                                    <h3 class="card-title mt-3">
                                        <a href="{{ route('posts.show', $post) }}"
                                           class="text-decoration-none fw-semibold text-white-50 h5">{{ $post->title }}</a>
                                    </h3>
                                    <p class="card-text text-white-50 text-xs">{{ Str::limit(strip_tags($post->content), 300) }}</p>
                                    <div class="text-start">
                                        <a class="btn btn-primary text-sm text-uppercase" href="{{ route('posts.show', $post) }}">
                                            {{ trans('messages.posts.read') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-5 mt-md-8">
                    <div class="card-body">
                        <div class="flex-grow-1 h-100">
                            @includeIf('components.general.discord')
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <a class="twitter-timeline" data-chrome="nofooter noborders" data-dnt="true"   data-lang="fr" data-tweet-limit="3" data-theme="dark" href="https://twitter.com/PandoniaMC"></a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>

        </div>
    </main>
@endsection
