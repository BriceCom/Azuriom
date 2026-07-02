@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <main class="container content">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        <div class="row mb-md-16 mb-15">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @php(preg_match('/[\\?\\&]v=([^\\?\\&]+)/', (theme_config('home.youtube.url') ?? "https://www.youtube.com/watch?v=ZSTE-SJjhnMQ") , $matches))
                        <iframe class="w-100" height="380" src="https://www.youtube.com/embed/{{ $matches[1] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="card mt-md-4 mt-3">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-8 text-sm">
                            <div>
                                <h2 class="h6 fw-semibold">{{ theme_config('home.partner.title') ?? "Partenaire ". site_name() }}</h2>
                                <p>{{ theme_config('home.partner.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, doloremque! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis consectetur dolore doloribus exercitationem facilis in molestiae, mollitia rem repudiandae sunt!" }}</p>
                                <div class="text-end">
                                    <a href="{{ theme_config('home.partner.url') ?? "#"}}">{{ theme_config('home.partner.urlText') ?? "Plus d'informations"}}</a>
                                </div>
                            </div>
                            <div class="d-none d-md-flex justify-content-end align-items-center flex-column w-25">
                                <span class="h6 fw-semibold">{{ theme_config('home.partner.pseudo') ?? "Bricec6" }}</span>
                                <small class="d-block mb-3">{{ theme_config('home.partner.pseudoDesc') ?? "2.5k abonnés" }}</small>
                                <div>
                                    <img height="60" src='https://mc-heads.net/head/{{ theme_config('home.partner.pseudo') ?? "Bricec6" }}/64.png' alt="Avatar de {{ theme_config('home.partner.pseudo') ?? "Bricec6" }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card">
                    <div class="card-body p-4">
                        @guest
                        <p class="fw-semibold text-sm text-center">Envie de commencer l'aventure ? Rejoint-nous au plus vite.</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="btn bg-dark">
                                @includeIf('components.login-modal')
                            </span>
                            @if(Route::has('register'))
                                <span class="btn bg-dark">
                                    @includeIf('components.register-modal')
                                </span>
                            @endif
                        </div>
                        @endguest
                        @auth
                            <div>
                                <span class="d-block text-uppercase fw-semibold">{{ Auth::user()->name }}</span>
                                <small class="badge" style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->role->name}}</small>
                            </div>
                            <hr class="border-black opacity-100"/>
                            <div>
                                <div class="d-flex">
                                   @if(plugins()->isEnabled('shop'))
                                       <div>
                                           <span class="d-block text-uppercase fw-semibold">{{Auth::user()->money}}</span>
                                           <small class="d-block">{{money_name()}}</small>
                                       </div>
                                    @endif
                                   <div class="d-contents ms-auto">
                                       <a class="d-block text-xs text-decoration-none" href="{{ route('profile.index') }}">Gérer mon profil</a>
                                       <a class="text-xs text-decoration-none" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter</a>
                                   </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        @if(! $posts->isEmpty())
            <div class="mb-md-16 mb-15">
                <div class="row gy-4">
                    @foreach($posts->take(4) as $post)
                        <div class="@if($loop->first) col-md-12 @else col-md-4 @endif">
                            <div class="h-100 post-preview card @if($loop->first) d-flex flex-md-row  @endif">
                                @if($post->hasImage())
                                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" height="{{ $loop->first ? 260 : 165 }}" class="card-img-top object-fit-cover">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5"><a href="{{ route('posts.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a></h3>
                                    <p class="card-text text-sm h-100" style="word-break: break-all;">{{ Str::limit(strip_tags($post->content),  ($loop->first) ? 400 : 200) }}</p>
                                    <div class="text-end">
                                        <a class="btn btn-primary" href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center text-md-start">
                    <a href="/news" class="w-50 btn btn-primary text-uppercase fw-semibold">Voir plus de mise à jour</a>
                </div>
            </div>
        @endif
    </main>
@endsection
