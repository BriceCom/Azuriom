<section class="py-5" id="blog">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">{{ $blogTitle }}</h2>
                    <p class="lead fw-normal text-body-secondary mb-0">{{ $blogSubtitle }}</p>
                </div>
            </div>
        </div>

        <div class="row gx-5">
            @foreach($latestPosts as $post)
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top pomodoro-news-image"
                             src="{{ $post->hasImage() ? $post->imageUrl() : 'https://dummyimage.com/600x350/ced4da/6c757d' }}"
                             alt="{{ $post->title }}">
                        <div class="card-body p-4">
                            <a class="text-decoration-none stretched-link text-reset" href="{{ route('posts.show', $post) }}">
                                <h3 class="h5 card-title mb-3 text-body">{{ $post->title }}</h3>
                            </a>
                            <p class="card-text mb-0 text-body-secondary">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 140) }}</p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                            <div class="small text-body-secondary">
                                {{ format_date($post->published_at) }} - {{ optional($post->author)->name }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
