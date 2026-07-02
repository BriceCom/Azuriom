@if(! $posts->isEmpty())
    <div class="home-news">
        <div class="home-section-head d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
            <hgroup>
                <h2 class="fw-bold mb-0">{{ theme_config('home.news.title') ?? trans('messages.news') }}</h2>
                @if(theme_config('home.news.text'))
                    <p class="mb-0 opacity-75">{{ theme_config('home.news.text') }}</p>
                @endif
            </hgroup>
            <a href="{{route('posts.index')}}" class="btn btn-primary">{{ theme_config('home.news.link.name') ?? trans('theme::theme.consult_all_news') }}</a>
        </div>

        <div class="row g-3 g-lg-4 align-items-stretch">
            @foreach($posts->take(1) as $post)
                <div class="col-lg-7">
                    <a class="home-news-featured post d-block overflow-hidden position-relative h-100 text-decoration-none" href="{{ route('posts.show', $post) }}">
                        <div class="position-relative post-img rounded-4 h-100">
                            <img src="{{$post->hasImage() ? $post->imageUrl():"https://placehold.co/800x500"}}" class="w-100 h-100 object-fit-cover" alt="" height="360" width="700">
                            <div class="position-absolute top-0 end-0 p-2">
                                <button type="button" class="position-relative border-0 bg-transparent @if($post->isLiked()) active @endif" data-bs-toggle="tooltip" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}">
                                    <i class="bi bi-heart fs-4 @if($post->isLiked()) d-none @endif" data-liked="true"></i>
                                    <i class="bi bi-heart-fill fs-4 text-danger @if(! $post->isLiked()) d-none @endif" data-liked="false"></i>
                                    <span class="position-absolute d-none spinner-border spinner-border-sm load-spinner opacity-0" role="status"></span>
                                </button>
                            </div>
                            <div class="home-news-featured-overlay d-flex flex-column justify-content-end">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <span class="badge text-bg-quaternary text-quaternary border" style="--di-badge-color: var(--di-quaternary)">
                                        <i class="bi bi-megaphone me-1"></i>
                                        {{theme_config('home.news.badge.name') ?? 'Nouveau'}}
                                    </span>
                                    <small class="opacity-75">{{format_date($post->published_at)}}</small>
                                </div>
                                <h3 class="fw-bold text-2xl mb-2">{{ $post->title }}</h3>
                                <p class="mb-0 text-white-50">{{ Str::limit(strip_tags($post->content), 170) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            <div class="col-lg-5">
                <div class="home-news-list d-flex flex-column gap-3">
                    @foreach($posts->slice(1, 2) as $post)
                        <a class="home-news-item post d-flex gap-3 overflow-hidden text-decoration-none" href="{{ route('posts.show', $post) }}">
                            <div class="position-relative post-img rounded-3 home-news-item-media">
                                <img src="{{$post->hasImage() ? $post->imageUrl():"https://placehold.co/800x500"}}" class="w-100 h-100 object-fit-cover" alt="" height="150" width="220">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <button type="button" class="position-relative border-0 bg-transparent @if($post->isLiked()) active @endif" data-bs-toggle="tooltip" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}">
                                        <i class="bi bi-heart fs-5 @if($post->isLiked()) d-none @endif" data-liked="true"></i>
                                        <i class="bi bi-heart-fill fs-5 text-danger @if(! $post->isLiked()) d-none @endif" data-liked="false"></i>
                                        <span class="position-absolute d-none spinner-border spinner-border-sm load-spinner opacity-0" role="status"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col post-content text-white">
                                <small class="opacity-50 d-block mb-1">{{format_date($post->published_at)}}</small>
                                <h3 class="fw-bold text-lg mb-2">{{ $post->title }}</h3>
                                <p class="mb-0 text-muted text-sm">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
