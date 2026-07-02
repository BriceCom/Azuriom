@php
    $newsPosts = isset($posts) && $posts instanceof \Illuminate\Support\Collection
        ? $posts->take(3)
        : collect();
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'news',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    @if(! $newsPosts->isEmpty())
        <div id="news" class="te-landing-section">
            <h2 class="text-center mb-0">{{ trans('messages.news') }}</h2>

            <div class="row gy-3 mt-2">
                @foreach($newsPosts as $post)
                    <div class="col-md-6">
                        <div class="post-preview card">
                            @if($post->hasImage())
                                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="card-img-top">
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 250) }}</p>
                                <a class="btn btn-primary" href="{{ route('posts.show', $post) }}">
                                    {{ trans('messages.posts.read') }}
                                </a>
                            </div>
                            <div class="card-footer text-body-secondary">
                                {{ trans('messages.posts.posted', ['date' => format_date($post->published_at), 'user' => $post->author->name]) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="te-landing-divider"></div>
@endcomponent
