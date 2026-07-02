@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <header class="position-relative">
        @include('elements.navbar')

        <div class="background">
            <div class="background-wrapper overflow-hidden">
                <img class="object-fit-cover background-img" tabindex="-1" src="{{ setting('background') ? image_url(setting('background')) : 'https://cdn.rinaorc.com/banner_blur.png' }}" alt="Illustration du jeu Minecraft">
                <div class="background-content">
                    <div class="d-flex flex-column gap-4">
                        <img class="object-fit-contain" src="{{site_logo()}}" alt="Logo de {{site_name()}}" height="170">
                        <div class="container mx-auto d-flex justify-content-center align-items-center py-4">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <h1 class="w-75 text-center mb-5">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, inventore! Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                </h1>
                                <button
                                    class="copyButton d-flex flex-column align-items-center bg-transparent cursor-pointer border-0 mb-0"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual">
                                    <a href="/launcher" class="d-block text-uppercase fs-6 fw-bold text-white mb-0 btn btn-warning p-3 px-4">
                                        Jouer
                                    </a>
                                    <span class="fw-semibold text-uppercase text-white-50 text-xs mt-2">
                                        @if($servers)
                                            @php
                                                $connected = 0
                                            @endphp
                                            @foreach($servers as $server)
                                                @if($server->isOnline())
                                                    @php
                                                        $connected += $server->getOnlinePlayers()
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <span class="d-flex align-items-center"><span class="d-block bg-success rounded-pill me-2" style="width: 8px; height: 8px;"></span> Serveur en ligne - {{$connected}} joueurs</span>
                                        @else
                                            <span class="d-flex align-items-center"> <span class="d-block bg-danger rounded-pill me-2" style="width: 8px; height: 8px;"></span> Serveur hors-ligne</span>
                                        @endif
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </header>
        <main id="home" class="container">
            @include('elements.session-alerts')

            @if($message)
                <div class="card">
                    <div class="card-body">
                        {{ $message }}
                    </div>
                </div>
            @endif
            <div class="row mt-8 g-8 g-md-15">
                <div class="col-12">
                    <div class="px-1 youtube-player">
                        <iframe class="w-100" height="455" src="https://www.youtube.com/embed/jNQXAC9IVRw?si=eGvVmF9Y6HqpmNTE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row g-3">
                        @foreach($posts->take(5) as $post)
                            @if($loop->iteration === 2)
                                <div class="col-md-6 d-flex flex-wrap gap-3">
                            @endif
                                    <div class="@if($loop->iteration === 1) col-md-6 @endif article-card-wrapper">
                                        <div class="h-100 card d-flex flex-column">
                                            <div class="card-header pb-0 text-white-25 text-sm">
                                                <div class="d-flex @if($loop->iteration === 1) justify-content-end @else justify-content-between @endif">
                                                    @php
                                                        $carbonDate = \Carbon\Carbon::createFromTimestamp($post->published_at);
                                                        $day = $carbonDate->day;
                                                        $month = $carbonDate->monthName;
                                                @endphp
                                                @if($loop->iteration === 1)
                                                    <div class="text-end">
                                                        <span class="fs-2">{{$post->published_at->day}}</span>
                                                        <span class="fs-2">{{$post->published_at->monthName}} <small class="text-white-25">{{$post->published_at->year}}</small></span>
                                                    </div>
                                                @else
                                                    <span>le {{format_date($post->published_at)}}</span>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span>{{$post->likes->count()}} <i class="d-inline bi bi-hand-thumbs-up-fill me-1"></i></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column @if($loop->iteration === 1) h-100 @endif">
                                            <div class="@if($loop->iteration != 1) flex-grow-1 @endif" style="height: {{$loop->iteration === 1 ? 280:90}}px">
                                                @if($post->hasImage())
                                                    <img src="{{ $post->imageUrl() }}"
                                                         alt="{{ $post->title }}"
                                                         height="@if($loop->iteration === 1) 280 @else 90 @endif"
                                                         class="card-img-top rounded-3 object-fit-cover">
                                                @endif
                                            </div>
                                            <h3 class="card-title mt-3">
                                                <a href="{{ route('posts.show', $post) }}"
                                                   class="text-decoration-none fw-semibold @if($loop->iteration == 1) h5 @else h6 @endif">{{ $post->title }}</a>
                                            </h3>
                                            <p class="flex-grow-1 card-text @if($loop->iteration == 1) text-sm @else text-xs @endif text-white-50">{{ Str::limit(strip_tags($post->content), ($loop->iteration === 1) ? 400: 150) }}</p>
                                        </div>
                                        <div class="card-footer py-3">
                                            <div class="text-end">
                                                <a class="btn btn-primary text-uppercase @if($loop->iteration != 1) text-sm @endif" href="{{ route('posts.show', $post) }}">
                                                    <i class="bi bi-plus-lg"></i > Voir plus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @if($loop->last)
                                </div>
                            @endif
                    @endforeach
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mb-md-0">
                    <a href="/news" class="w-100 d-flex align-items-center justify-content-between text-decoration-none fw-semibold gap-2 p-3 text-uppercase mt-4">
                        Voir tous les articles
                        <i class="d-inline bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>
@endsection
