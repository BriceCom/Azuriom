@if(theme_config('home.news.off') !== 'on')
    @if(! $posts->isEmpty())
        <section class="container py-11">

            <div class="d-flex flex-column flex-md-row justify-content-between mb-7">
                <hgroup>
                    <h2 class="mb-2">
                        {{theme_config('home.news.title') ?? "Toute l’actualité " . site_name()}}
                    </h2>

                    @if(theme_config('home.news.text')) <p class="mb-0">{{ theme_config('home.news.text') }}</p> @endif
                </hgroup>


                <div>
                    <a href="{{route('posts.index')}}" class="btn btn-primary text-uppercase mt-2 md:mt-0">Toutes les actualités</a>
                </div>
            </div>


            <div class="splide" id="news-slider">

                <div class="splide__arrows">
                    <button class="splide__arrow splide__arrow--prev btn btn-secondary btn-icon opacity-100 post-splide__arrow">
                        <i class="bi bi-arrow-left-short text-xl"></i>
                    </button>
                    <button class="splide__arrow splide__arrow--next btn btn-secondary btn-icon opacity-100 post-splide__arrow">
                        <i class="bi bi-arrow-right-short text-xl"></i>
                    </button>
                </div>

                <div class="splide__track px-4">
                    <div class="splide__list">
                        @foreach($posts as $post)
                            <li class="post-wrapper splide__slide d-flex justify-content-center">
                            <a class="post position-relative overflow-hidden d-flex flex-column justify-content-between rounded-4 p-3 text-white" href="{{ route('posts.show', $post) }}">
                                <div class="post-img -z-1 position-absolute top-0 start-0 bottom-0">
                                    <img class="h-100 object-fit-cover img-fluid" src="{{$post->hasImage() ? $post->imageUrl():"https://placehold.co/400x300"}}" alt="">
                                </div>

                                <div class="w-fit ms-auto bg-white bg-opacity-25 px-2 rounded-1 ff-main">
                                    <span class="text-lg">{{$post->published_at->format('d')}}</span>
                                    <span class="d-block text-lg text-uppercase">{{ mb_substr($post->published_at->translatedFormat('F'), 0 ,3)}}</span>
                                </div>

                                <div class="post-content">
                                    <h3 class="text-uppercase text-lg ff-main">{{ $post->title }}</h3>
                                    <p class="text-xs m-0 ff-tertiary text-uppercase">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                </div>
                            </a>
                            </li>

                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
@endpush

@push('footer-scripts')
    <script>
        var splide = new Splide('.splide', {
            type: 'loop',
            perPage: 3,
            rewind: true,
            perMove: 1,
            pagination: false,
            breakpoints: {
                1200: {
                    perPage: 2
                },
                767: {
                    perPage: 1
                }
            }
        });

        splide.mount();
    </script>
@endpush
