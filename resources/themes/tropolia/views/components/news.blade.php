@if(theme_config('home.news.off') !== 'on')
    @if(! $posts->isEmpty())
        <section class="container py-11">

            <div class="d-flex flex-column flex-md-row justify-content-between mb-4.5" data-aos="fade-up" data-aos-delay="0">
                <hgroup>
                    <h2 class="mb-2">
                        {{theme_config('home.news.title') ?? "Actualités du serveur ! "}}
                    </h2>

                    @if(theme_config('home.news.text'))
                        <p class="mb-0 col-md-8">{{ theme_config('home.news.text') }}</p>
                    @endif
                </hgroup>

                <div>
                    <a href="{{route('posts.index')}}" class="btn btn-outline-primary text-uppercase mt-2 md:mt-0">Toute
                        l’actualité</a>
                </div>
            </div>

            <div class="row gy-3">
                @foreach($posts->take(1) as $post)
                    <div class="col-md-12">
                        <article itemScope itemType="https://schema.org/Review"
                                 class="card overflow-hidden d-flex flex-md-row justify-content-between border-0">
                            @if($post->hasImage())
                                <div class="col-md-4" >
                                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" height="374"
                                         class="w-100 object-fit-cover" loading="lazy" draggable="false">
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="postition-relative col-md-9">
                                    <div class="z-1 position-absolute top-0 end-0 p-4">
                                        @guest
                                            <a href="{{ route('login') }}">
                                                <i class="bi bi-heart fs-2" data-liked="false"></i>
                                            </a>
                                        @else
                                            <button type="button" class="position-relative border-0 bg-transparent p-0 @if($post->isLiked()) active @endif" data-bs-toggle="tooltip" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}">
                                                <i class="bi bi-heart fs-2 @if($post->isLiked()) d-none @endif" data-liked="true"></i>
                                                <i class="bi bi-heart-fill fs-2 text-danger @if(! $post->isLiked()) d-none @endif" data-liked="false"></i>
                                                <span class="position-absolute d-none spinner-border spinner-border-sm load-spinner opacity-0" role="status"></span>
                                            </button>
                                        @endguest
                                    </div>
                                    <div class="d-flex items-center gap-1 opacity-75 mb-4">
                                        <i class="bi bi-calendar-fill"></i>
                                        <span class="ms-1">
                                            {{$post->published_at->format('d')}}
                                            {{$post->published_at->translatedFormat('M')}}
                                            {{$post->published_at->format('Y')}}
                                        </span>
                                    </div>
                                    <h3 class="card-title text-2xl mb-4">{{ $post->title }}</h3>
                                    <p itemProp="reviewBody"
                                       class="card-text opacity-75 mb-4">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                                    <a class="btn btn-text-primary" href="{{ route('posts.show', $post) }}">
                                        Lire l’article
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endif
