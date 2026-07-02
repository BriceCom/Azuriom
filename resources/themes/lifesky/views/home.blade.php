@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div id="home" class="container content">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

       <div class="row align-items-start py-8 pt-15">
           <div class="col-lg-9 pe-md-5">
               @if(!theme_config('home.trailer.show'))
                   <div class="mb-10">
                       <h2 class="fw-semibold">{{theme_config('home.trailer.title') ?? "Plongez dans notre trailer"}}</h2>
                       <p class="mb-5">{{theme_config('home.trailer.subtitle') ?? "Sous titre"}}</p>

                       <div class="trailer-wrapper text-start">
                           <iframe
                               loading="lazy"
                               src="{{theme_config('home.traile.url') ? theme_config('home.trailer.url'):'https://www.youtube.com/embed/m_yqOoUMHPg'}}"
                               title="Trailer du serveur {{site_name()}}"
                               allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                               frameborder="0"
                               allowfullscreen>
                           </iframe>
                       </div>
                   </div>
               @endif
               <div>
                   <h2 class="fw-semibold">{{ theme_config('home.article.title') ?? "Nos derniers articles"}}</h2>
                   <p class="mb-5">{{theme_config('home.article.subtitle') ?? "Sous-titre"}}</p>

                   @if(! $posts->isEmpty())
                       <div class="row gy-3">
                           @foreach($posts->take(3) as $post)
                               <div>
                                   <div class="card news d-flex flex-column flex-md-row gap-3 rounded-4 p-3 ">
                                       @if($post->hasImage())
                                           <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="news-image object-fit-cover rounded-3">
                                       @endif
                                       <div class="card-body position-relative p-0">
                                           <div class="position-absolute top-0 end-0 d-flex gap-2 align-items-center">
                                               @php
                                                   $pattern = '/\[(.*?)\]/';
                                                    preg_match($pattern, $post->title, $matches);
                                                    $tag = $matches[1] ?? null;
                                               @endphp
                                               @if($tag)
                                                   <span class="d-inline-flex px-1 text-xs fw-semibold bg-tertiary bg-opacity-50 border border-1 border-tertiary border-tertiary rounded-pill px-2">{{$tag}}</span>
                                               @endif

                                               <div class="d-flex gap-2 align-items-center border rounded-pill px-2">
                                                   <span class="text-sm">{{$post->likes->count()}} <i class="bi bi-heart-fill" style="color: #cd4c4c;"></i></span>
                                               </div>
                                           </div>
                                           <h3 class="card-title fw-semibold mb-3 h4">
                                               {{ $post->title }}
                                           </h3>
                                           <p class="card-text mb-0">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                                           <div class="text-end">
                                               <a href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           @endforeach
                       </div>
                   @endif
               </div>
                   <a class="btn btn-primary mt-4" href="/news">Consulter tout nos articles <i class="bi bi-arrow-right"></i></a>
           </div>
           <div class="col-lg-3 row gx-3 gy-5 mt-8 mt-lg-0">
               @guest
               <div class=" mt-md-0">
                   <div class="card">
                       <div class="card-header">
                           <h3 class="underline_custom center">Espace membre</h3>
                       </div>
                       <div class="card-body">

                           <form method="POST" action="{{ route('login') }}">
                               @csrf

                               <div class="mb-3">
                                   <label class="form-label mb-1 fw-semibold" for="email">Email</label>
                                   <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                   @error('email')
                                   <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                   @enderror
                               </div>

                               <div class="mb-3">
                                   <label class="form-label mb-1 fw-semibold" for="password">
                                       {{ trans('auth.password') }}
                                       @if(Route::has('password.request'))
                                           <a class="fw-semibold text-decoration-none" href="{{ route('password.request') }}">
                                               oublié ?
                                           </a>
                                       @endif
                                   </label>
                                   <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                   @error('password')
                                   <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                   @enderror
                               </div>

                               <div class="row gy-3 mb-1">
                                   <div class="col-12 mt-2">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>

                                           <label class="form-check-label text-sm" for="remember">
                                               Rester connecté ?
                                           </label>
                                       </div>
                                   </div>
                               </div>

                               <div class="d-grid">
                                   <button type="submit" class="btn btn-primary d-block">
                                       {{ trans('auth.login') }}
                                   </button>
                                   <a class="text-xs" href="{{ route('register') }}">
                                       Vous n'avez pas de compte?
                                   </a>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               @endguest
               <div class="col-6 col-md-12">
                   <div class="card">
                       <div class="card-header">
                           <h3 class="underline_custom center">Discord</h3>
                       </div>
                       <div class="card-body">
                           <div class="flex-grow-1 h-100">
                               @includeIf('components.general.discord')
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-6 col-md-12">
                   <ul class="list-unstyled d-flex flex-column gap-3">
                       @foreach(social_links() as $link)
                           <li style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') left / cover no-repeat;"
                               class="rounded-3 overflow-hidden">
                               <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                                  data-bs-toggle="tooltip"
                                  class="d-flex align-items-end py-2 px-3 text-white text-decoration-none"
                                  style="background-image: linear-gradient(to right, {{ $link->color }}, {{ $link->color.'8c' }});">
                                   <i class="{{ $link->icon }} text-white fs-3"></i>
                                   <span class="text-uppercase fw-semibold ms-2">{{ $link->title }}</span>
                                   <i class="bi bi-box-arrow-up-right ms-auto my-auto"></i>
                               </a>
                           </li>
                       @endforeach
                   </ul>
               </div>
           </div>
       </div>
    </div>
@endsection
