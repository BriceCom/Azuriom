@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <section class="hero position-relative d-flex align-items-center justify-content-center flex-column text-white">
        <div class="hero__bg" style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;"></div>

        <div class="hero__img mb-4">
            <img height="200" src="{{ setting('logo') ? image_url(setting('logo')) : 'https://via.placeholder.com/300x300' }}" alt="{{ setting('title') }}">
        </div>
        <div class="d-flex flex-column align-items-end gap-1">
            @include('components.ip-and-connected')
            <small>
                <b>Cliquez pour copier l'ip !</b>
            </small>
        </div>

        <div class="hero-clip"></div>
    </section>


    <section class="container mt-15">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        <div class="d-flex flex-column gap-15">
            @include('components.join', ["title" =>  theme_config('home.join.title') ?? null, "content" =>  theme_config('home.join.content') ?? null])


            @if(! $posts->isEmpty())
                <div class="row justify-content-center gy-3">
                    @foreach($posts->take(3) as $post)
                        <div class="col-lg-4">
                            <div class="h-100 card">
                                <div class="card-body d-flex flex-column p-3 gap-3">
                                    @if($post->hasImage())
                                        <div class="position-relative">
                                            <div class="position-absolute top-0 start-0 d-flex align-items-center gap-2 ms-3 mt-3">
                                                <img class="d-flex rounded-pill" src="{{ $post->author->getAvatar(32) }}" alt="{{  $post->author->name }}" height="32">
                                                <span class="badge rounded-sm text-bg-light">{{$post->author->name}}</span>
                                            </div>

                                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-100 object-fit-cover rounded-2" height="300">
                                        </div>
                                    @endif
                                    <div class="flex-grow-1 d-flex flex-column gap-3">
                                        <h3 class="card-title">
                                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                                        <div class="text-start">
                                            <a class="btn btn-primary" href="{{ route('posts.show', $post) }}">
                                                {{ trans('messages.posts.read') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-9 text-end mt-4">
                        <a href="{{route('posts.index')}}" rel="noopener" class="text-decoration-none text-black">Voir tous les articles <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            @endif

            @include('components.stats')

        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>
@endpush
