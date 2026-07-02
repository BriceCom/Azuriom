@if(theme_config('home.index.news.off') !== 'on')
    @if(! $posts->isEmpty())
                @php($newsBadgeColor = theme_config('style.colors.light.dark') ?? '#f5f5f5')
                @php($newsBadgeTextColor = preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $newsBadgeColor) ? color_contrast($newsBadgeColor) : 'var(--di-dark)')
                <section class="container">
                    <h2 class="fw-bold mb-4">{{ trans('messages.news') }}</h2>
                    <div class="row align-items-center g-5">
                        @foreach($posts->take(1) as $post)
                                <div class="col-lg-5">
                                    <a class="post post-main d-block overflow-hidden position-relative rounded-4 h-100 text-decoration-none" href="{{ route('posts.show', $post) }}">
                                        <div class="post-img post-gradient">
                                            <img src="{{$post->hasImage() ? $post->imageUrl():"https://placehold.co/800x500"}}" class="w-100" alt="" height="348" width="400">
                                        </div>
                                        <div class="post-content position-absolute bottom-0 start-0 p-4 text-white">
                                            <div class="d-flex align-items-center gap-2 mb-2.5">
                                                <span class="badge bg-light" style="color: {{ $newsBadgeTextColor }}">{{$post->author->name}}</span>
                                                <small>{{format_date($post->published_at)}}</small>
                                            </div>
                                            <h3 class="fw-bold mb-2 text-lg">{{ $post->title }}</h3>
                                            <p class="mb-0 text-muted">{{ Str::limit(strip_tags($post->content), 190) }}</p>
                                        </div>
                                        <div class="position-absolute top-0 end-0 p-3">
                                            <button type="button" class="position-relative border-0 bg-transparent @if($post->isLiked()) active @endif" data-bs-toggle="tooltip" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}">
                                                <i class="bi bi-heart fs-4 @if($post->isLiked()) d-none @endif" data-liked="true"></i>
                                                <i class="bi bi-heart-fill fs-4 text-danger @if(! $post->isLiked()) d-none @endif" data-liked="false"></i>
                                                <span class="position-absolute d-none spinner-border spinner-border-sm load-spinner opacity-0" role="status"></span>
                                            </button>
                                        </div>
                                    </a>
                                </div>
                        @endforeach
                        <div class="col-lg-7">
                            <div class="row g-6 g-md-4">
                                @foreach($posts->slice(1, 2) as $post)
                                    <div class="col-md-12">
                                        <a class="post rounded-4 overflow-hidden text-body-emphasis text-decoration-none" href="{{ route('posts.show', $post) }}">
                                            <div class="row gap-4">
                                                <div class="post-img__wrapper position-relative col-md-4 px-0" style="width: 200px;">
                                                    <div class="post-img">
                                                        <img src="{{$post->hasImage() ? $post->imageUrl():"https://placehold.co/400x300"}}" height="150" width="200" class="object-fit-cover rounded-4" alt="">
                                                    </div>

                                                    <div class="position-absolute top-0 end-0 p-2 pe-3">
                                                        <button type="button" class="position-relative border-0 bg-transparent p-0 @if($post->isLiked()) active @endif" data-bs-toggle="tooltip" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}">
                                                            <i class="bi bi-heart fs-4 @if($post->isLiked()) d-none @endif" data-liked="true"></i>
                                                            <i class="bi bi-heart-fill fs-4 text-danger @if(! $post->isLiked()) d-none @endif" data-liked="false"></i>
                                                            <span class="position-absolute d-none spinner-border spinner-border-sm load-spinner opacity-0" role="status"></span>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="col-md-7">
                                                    <div class="post-content card-body">
                                                        <div class="d-flex align-items-center gap-2 mb-2.5">
                                                            <span class="badge bg-light" style="color: {{ $newsBadgeTextColor }}">{{$post->author->name}}</span>
                                                            <small>{{format_date($post->published_at)}}</small>
                                                        </div>
                                                        <h3 class="fw-bold mb-2 text-lg">{{ $post->title }}</h3>
                                                        <p class="mb-0 text-muted">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{route('posts.index')}}" class="btn btn-secondary">{{ trans('theme::theme.all_news') }} <i class="bi bi-arrow-right"></i></a>
                    </div>
                </section>
            @endif
@endif
