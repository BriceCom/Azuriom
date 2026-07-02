@extends('layouts.app')

@section('title', trans('messages.posts.posts'))

@section('content')
        <h1 class="px-md-7 px-xl-11">{{ trans('messages.posts.posts') }}</h1>

        <div class="post-preview__listing row g-3 px-md-7 px-xl-11">
            @foreach($posts as $post)
                <div class="@if($loop->first) col-lg-12 col-xl-8 @endif col-lg-6 col-xl-4 h-100">
                    <div class="post-preview card position-relative overflow-hidden rounded-4"
                    >
                    <span
                        class="position-absolute top-0 start-0 h-100 w-100 object-fit-cover"
                        style="
                            z-index: 0;
                            background: linear-gradient(to bottom, rgba(20, 22, 15, 0), rgba(20, 22, 15, 1))
                        "
                    >

                    </span>
                        @if($post->hasImage())
                            <img src="{{ $post->imageUrl() }}"
                                 class="position-absolute top-0 start-0 h-100 w-100 object-fit-cover"
                                 style="
                                z-index: -2;
                             "
                                 alt="{{ $post->title }}">
                        @endif

                        <div class="position-relative d-flex flex-column justify-content-end card-body text-white mt-auto"
                             style="
                            z-index: 1;
                        "
                        >
                            <div class="mb-2">
                                {{ $post->published_at->format('d/m/Y') }}
                                -
                                {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min
                            </div>
                            <h3 class="card-title text-uppercase mb-1">
                                <a href="{{ route('posts.show', $post) }}" class="text-white text-decoration-none">{{ $post->title }}</a>
                            </h3>
                            <p class="card-text mb-1 text-white">{{ Str::limit(strip_tags($post->content), $loop->first ? 200:100) }}</p>
                            <a class="text-white" href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}...</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection
