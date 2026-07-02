@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div id="home" class="container content mb-10">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-0 mt-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        @if(theme_config('servers.toggle'))

        <div class="mt-5">
            @include('components.servers')
        </div>
        @endif

        <h1 class="opacity-0 h6 m-0">{{ site_name() }}</h1>


    @if(! $posts->isEmpty())
            <section class="container">
                <div class="row gy-3 py-4">
                    @foreach($posts->take(4) as $post)
                        <article class="@if($loop->first) col-12 @else col-12 col-md-6 col-lg-4 @if($loop->iteration === 3) px-md-3 @endif px-0 @endif">
                            <div class="@if($loop->first) row flex-row @endif post-preview card h-100">
                                @if($post->hasImage())
                                    <a href="{{ route('posts.show', $post) }}" class="@if($loop->first) col-lg-6 px-0 @endif position-relative overflow-hidden">
                                        @if($loop->first) <h2 class="post-main-title position-absolute bg-dark p-4 py-1">{{ trans('messages.news') }}</h2> @endif
                                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="card-img-top post-image" @if(!$loop->first) height="215" @else height="400" @endif>
                                    </a>
                                @endif
                                <div class="@if($loop->first) col-lg-6 @endif card-body rounded-bottom-1 d-flex flex-column @if($loop->first) rounded-end-1 @endif">
                                    <h3 class="card-title text-center">
                                        <a class="text-decoration-none" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                                    <p class="card-text flex-grow-1 text-center">{{ Str::limit(strip_tags($post->content), ($loop->first ? 620 : 200)) }}</p>
                                    <div class="text-end">
                                        <a class="" href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}</a>
                                    </div>
                                    <div class="bg-light py-2 px-4 rounded-3 mt-3">
                                        {{ trans('messages.posts.posted', ['date' => format_date($post->published_at), 'user' => $post->author->name]) }}
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
        @if(theme_config('stats.toggle'))
            <section class="container text-center my-3">
                <div class="row gy-3 justify-content-center align-items-center">
                    <div class="col-12 col-md-6 col-lg-4 p-0">
                        <div class="d-flex flex-column bg-dark border rounded-1 py-2">
                            <span class="h1 text-primary">{{theme_config('stats.left.number') ?? '♡'}}</span>
                            <span class="h5 fw-semibold">{{theme_config('stats.left.text') ?? 'THANKS'}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 p-0 px-md-3">
                        <div class="d-flex flex-column bg-dark border rounded-1 py-2">
                            <span class="h1 text-primary">{{theme_config('stats.middle.number') ?? 'DIXEPT'}}</span>
                            <span class="h5 fw-semibold">{{theme_config('stats.middle.text') ?? 'FOR'}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 p-0">
                        <div class="d-flex flex-column bg-dark border rounded-1 py-2">
                            <span class="h1 text-primary">{{theme_config('stats.right.number') ?? '♡'}}</span>
                            <span class="h5 fw-semibold">{{theme_config('stats.right.text') ?? 'PURSHASES'}}</span>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
