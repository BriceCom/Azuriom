@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <section class="hero" style="
    background: radial-gradient(52.54% 29.2% at 50% 51.54%, rgba(0, 0, 0, 0.40) 0%, rgba(0, 0, 0, 0.00) 100%),
    linear-gradient(0deg, rgb(17 24 39) 10%, rgba(255,255,255,0) 100%),
    url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x1000' }}') center / cover no-repeat;">
        <div class="hero-wrapper container d-flex flex-column align-items-center justify-content-center">

                <ul class="tag-wrapper">
                    @if(theme_config('header.index.hero.tags'))
                        @foreach(theme_config('header.index.hero.tags') as $tag)
                            @if(!empty($tag['text']))
                                <li class="tag">{{$tag['text']}}</li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            <h1 class="text-uppercase">{{theme_config('header.index.hero.title') ?? "Vivez l'Aventure Minecraft Ultime"}}</h1>
            <div class="d-flex align-items-center gap-5">
                @include('components.join-button', ['joinText'=> 'Jouer'])
                <a href="{{theme_config('header.index.hero.button.url') ?? '#nos-serveurs'}}" class="btn btn-tertiary text-uppercase">{{theme_config('header.index.hero.button.text') ?? "Nos serveurs"}}</a>
            </div>
        </div>
        <div class="transition"></div>
    </section>

    <div class="my-18 my-xxl-18">
        @include('elements.session-alerts')

        <div class="container mb-10">
            @if($message)
                <div class="card mb-4">
                    <div class="card-body">
                        {{ $message }}
                    </div>
                </div>
            @endif
        </div>

        <div class="d-flex flex-column gap-18 gap-xxl-23">

                @includeIf('components.text-image', [
                    'show' => !theme_config("home.index.textimage-1.show"),
                    'imgUrl' => theme_config("home.index.textimage-1.imgUrl") ? image_url(theme_config("home.index.textimage-1.imgUrl")):theme_asset('/images/textimage.webp'),
                    'content' => theme_config("home.index.textimage-1.content") ?? "
                                    <h2>Skyblock sur Hypenetwork</h2>
                                    <p>Transformez une petite île flottante en un empire prospère avec des ressources limitées. Participez à des défis uniques, échangez avec d'autres joueurs et grimpez dans les classements pour recevoir des récompenses spéciales.</p>
                    ",
                    'button' => [
                        'url' => theme_config("home.index.textimage-1.button.url"),
                        'text' => theme_config("home.index.textimage-1.button.text")
                    ],
                    'joinButton' => theme_config("home.index.textimage-1.joinButton")
                ])

            <section class="container">
                @includeIf('components.servers')
            </section>

            @if(!theme_config('home.stats.show'))
                <div class="container">
                    @includeIf('components.stats')
                </div>
            @endif

            @if(! $posts->isEmpty())
           <section class="posts bg-body-tertiary py-18 py-xxl-17">
               <div class="container pe-0">
                   <hgroup>
                       <h2 class="mb-4">
                           Articles récents
                       </h2>

                       <p class="mb-6">Retrouvez tout l’actualité de HypeNetwork à un seul endroit !</p>
                   </hgroup>

                  <div class="posts__slider-wrapper">
                      <div class="posts__slider">
                          <div class="post-wrapper">
                              @foreach($posts as $post)
                                  <a href="{{ route('posts.show', $post) }}" class="post text-decoration-none" draggable="false">
                                      @if($post->hasImage())
                                          <div class="post__img">
                                              <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
                                          </div>
                                      @endif
                                      <div class="post__content">
                                          <svg class="post__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7197 7.71967C17.0126 7.42678 17.4874 7.42678 17.7803 7.71967L21.5303 11.4697C21.8232 11.7626 21.8232 12.2374 21.5303 12.5303L17.7803 16.2803C17.4874 16.5732 17.0126 16.5732 16.7197 16.2803C16.4268 15.9874 16.4268 15.5126 16.7197 15.2197L19.1893 12.75H3C2.58579 12.75 2.25 12.4142 2.25 12C2.25 11.5858 2.58579 11.25 3 11.25H19.1893L16.7197 8.78033C16.4268 8.48744 16.4268 8.01256 16.7197 7.71967Z" fill="white"/>
                                          </svg>
                                          <h3>{{ $post->title }}</h3>
                                      </div>
                                  </a>
                              @endforeach
                          </div>
                      </div>
                  </div>
               </div>
           </section>
            @endif

            <div class="container">
                @includeIf('components.join')
            </div>


            @includeIf('components.text-image', [
                'show' => theme_config("home.index.textimage-2.show"),
                'imgUrl' => theme_config("home.index.textimage-2.imgUrl") ? image_url(theme_config("home.index.textimage-2.imgUrl")):theme_asset('/images/textimage.webp'),
                'content' => theme_config("home.index.textimage-2.content") ?? "
                                <h2>Skyblock sur HypeNetwork</h2>

                                <p>Plongez dans un univers où chaque joueur trouve son bonheur grâce à une variété de modes de jeux passionnants :</p>

                                <ul>
                                    <li><b>Survival</b> : Explorez, construisez et survivez dans un monde riche en aventures.</li>
                                    <li><b>Prison</b> : Gravissez les échelons en minant, complétant des quêtes et négociant votre liberté.</li>
                                    <li><b>Skyblock</b> : Transformez une île flottante en un empire prospère grâce à vos talents de constructeur.</li>
                                </ul>
                ",
                'button' => [
                    'url' => theme_config("home.index.textimage-2.button.url"),
                    'text' => theme_config("home.index.textimage-2.button.text")
                ],
                'joinButton' => theme_config("home.index.textimage-2.joinButton")
            ])

        </div>
    </div>
@endsection
