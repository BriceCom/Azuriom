@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $title = trim((string) ($settings['title'] ?? ''));
    $subtitle = trim((string) ($settings['subtitle'] ?? ''));
    $count = max(1, min(12, (int) ($settings['count'] ?? 3)));

    $posts = \Azuriom\Models\Post::query()
        ->published()
        ->latest('published_at')
        ->take($count)
        ->get();
@endphp

<section class="container my-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
        <div>
            @if($title !== '')
                <h2 class="h3 mb-1">{{ $title }}</h2>
            @endif
            @if($subtitle !== '')
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            @endif
        </div>
        <a href="{{ route('posts.index') }}" class="btn btn-outline-primary btn-sm">{{ trans('theme::reborn.all_posts') }}</a>
    </div>

    <div class="row g-3">
        @forelse($posts as $post)
            <div class="col-md-6 col-xl-4">
                <article class="card h-100 border-0 shadow-sm">
                    @if($post->hasImage())
                        <img src="{{ $post->imageUrl() }}" class="card-img-top" alt="{{ $post->title }}" style="height: 180px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <p class="small text-muted mb-2">{{ $post->published_at?->translatedFormat('d M Y') }}</p>
                        <h3 class="h5 mb-2">{{ $post->title }}</h3>
                        <p class="text-muted mb-3">{{ $post->description }}</p>
                        <a href="{{ route('posts.show', $post) }}" class="stretched-link">{{ trans('messages.posts.read') }}</a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">{{ trans('theme::reborn.no_posts') }}</div>
            </div>
        @endforelse
    </div>
</section>
