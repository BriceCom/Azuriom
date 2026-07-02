@if(! $posts->isEmpty())
    <section class="blog-section">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4 mb-5">
                <div class="section-copy mb-0">
                    <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">
                        {{ theme_config('home.news.badge.name') ?? trans('messages.news') }}
                    </span>
                    <h2>{{ theme_config('home.news.title') ?? trans('messages.news') }}</h2>
                    @if(theme_config('home.news.text'))
                        <p class="mb-0">{{ theme_config('home.news.text') }}</p>
                    @endif
                </div>

                <a href="{{ route('posts.index') }}" class="btn btn-primary">
                    {{ theme_config('home.news.link.name') ?? trans('theme::theme.consult_all_news') }}
                </a>
            </div>

            <div class="row g-4">
                @foreach($posts->take(3) as $post)
                    <div class="col-lg-4">
                        <div class="blog-card">
                            <a href="{{ route('posts.show', $post) }}">
                                <img src="{{ $post->hasImage() ? $post->imageUrl() : 'https://placehold.co/370x331' }}" alt="{{ $post->title }}" class="blog-image" />
                            </a>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $post->author->getAvatar() }}" alt="{{ $post->author->name }}" class="avatar" />
                                        <span class="author-name">{{ $post->author->name }}</span>
                                    </div>
                                    <span class="blog-date">{{ format_date($post->published_at) }}</span>
                                </div>
                                <h3><a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-body">{{ $post->title }}</a></h3>
                                <p>
                                    {{ Str::limit(strip_tags($post->content), 150) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
