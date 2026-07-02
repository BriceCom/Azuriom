@extends('forum::layouts.forum')

@section('title', trans('forum::messages.title'))

@section('forum')
    <div class="row" id="forum">
        <div class="col-md-9">
            @foreach($categories as $category)
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="h3 text-white">{{ $category->name }}</h2>
                        <small>{{ $category->description }}</small>
                    </div>

                    <div class="card-body">
                        <div class="list-group list-group-flush gap-3">
                            @foreach($category->forums as $forum)
                                @can('view', $forum)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-xl-1 col-md-2 col-2 text-center">
                                                <i class="{{ $forum->icon ?? 'bi bi-chat' }} fs-2 text-primary"></i>
                                            </div>

                                            <div class="col-xl-8 col-md-7 col-10 ps-md-0">
                                                <h3 class="h5">
                                                    <a class="text-primary" href="{{ route('forum.show', $forum->slug) }}">{{ $forum->name }}</a>
                                                </h3>

                                                <p class="text-white-50 text-xs">
                                                    {{ $forum->description ?? '' }}
                                                </p>
                                            </div>

                                            <div class="col-xl-3 col-md-3 d-flex gap-4 justify-content-end justify-content-md-start text-white-50">
                                                    <span><i class="d-inline bi bi-folder-fill me-1"></i>{{$forum->posts_count}}</span>
                                                    <span><i class="d-inline bi bi-chat-left-text-fill me-1"></i>{{$forum->discussions_count}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-3">
            @auth
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 text-center">
                                <a href="{{ route('forum.users.show', $user) }}">
                                    <img src="{{ $user->getAvatar() }}" class="rounded img-fluid" alt="{{ $user->name }}">
                                </a>
                            </div>

                            <div class="col-md-7 ps-md-0">
                                <h5 class="mb-1">
                                    <a href="{{ route('forum.users.show', $user) }}">{{ $user->name }}</a>
                                </h5>

                                <span class="badge" style="{{ $user->role->getBadgeStyle() }}; vertical-align: middle">
                                    {{ $user->role->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            @if(! $latestPosts->isEmpty())
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="bi bi-chat-dots"></i> {{ trans('forum::messages.latest.title') }}
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($latestPosts as $post)
                            <div class="list-group-item">
                                <a href="{{ route('forum.discussions.show', $post->discussion) }}">
                                    {{ $post->discussion->title }}
                                </a>

                                <br>

                                <small class="text-white-50">
                                    <a class="text-white-50" href="{{ route('forum.users.show', $post->author) }}">{{ $post->author->name }}</a>,
                                    {{ format_date($post->created_at) }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer d-flex justify-content-between text-white-25">
                        <h3 class="text-xs m-0">Statistiques</h3>
                        <ul class="list-unstyled mb-0 d-flex gap-3 align-items-center">
                            <li class="text-xs"><i class="d-inline bi bi-chat-left-text-fill me-1"></i> {{ $discussionsCount }}</li>
                            <li class="text-xs"><i class="d-inline bi bi-folder-fill me-1"></i> {{ $postsCount }}</li>
                            <li class="text-xs"><i class="d-inline bi bi-people-fill me-1"></i> {{ $usersCount }}</li>
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-people"></i> Membres En Ligne
                </div>
                <div class="card-body">
                    @forelse($onlineUsers as $id => $user)
                        @if($id !== 0)
                            ,
                        @endif
                        <a data-bs-toggle="tooltip"data-bs-placement="bottom" data-bs-title="{{ $user->name }}" href="{{ route('forum.users.show', $user) }}">
                            <img src="{{ $user->getAvatar(24) }}" alt="Avatar de {{ $user->name }}">
                        </a>
                    @empty
                        {{ trans('forum::messages.online.none') }}
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
