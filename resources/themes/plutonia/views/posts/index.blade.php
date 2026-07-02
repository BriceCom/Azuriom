@extends('layouts.app')

@section('title', trans('messages.posts.posts'))

@section('content')
    <section class="page-top">
        <h2>{{ trans('messages.posts.posts') }}</h2>
        <div class="block"></div>
    </section>

    <div class="row gy-3">
        @foreach($posts as $post)
            <div class="col-md-6">
                <div class="post-preview card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="card-text">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                        <a class="btn btn-primary" href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}</a>
                    </div>
                    <div class="card-footer text-muted">
                        {{ trans('messages.posts.posted', ['date' => format_date($post->published_at), 'user' => $post->author->name]) }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
