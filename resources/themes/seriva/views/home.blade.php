@extends('layouts.base')

@section('title', trans('messages.home'))

@php
    $primaryAction = Route::has('register') ? route('register') : route('login');
    $serverCollection = collect();

    if (isset($servers)) {
        if ($servers instanceof \Illuminate\Support\Collection) {
            $serverCollection = $servers;
        } elseif (is_iterable($servers)) {
            $serverCollection = collect($servers);
        }
    }

    $totalPlayers = $serverCollection->sum(function ($server) {
        return $server->isOnline() ? $server->getOnlinePlayers() : 0;
    });

    $blogPosts = collect();

    if (isset($posts)) {
        if ($posts instanceof \Illuminate\Support\Collection) {
            $blogPosts = $posts->take(3);
        } elseif (method_exists($posts, 'getCollection')) {
            $blogPosts = collect($posts->getCollection())->take(3);
        } elseif (is_iterable($posts)) {
            $blogPosts = collect($posts)->take(3);
        }
    }

    if ($blogPosts->isEmpty()) {
        $blogPosts = \Azuriom\Models\Post::query()
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    $heroImage = theme_config('home.hero.image') ? image_url(theme_config('home.hero.image')) : theme_asset('img/seriva-hero.png');
    $supportImage = theme_config('home.support.image') ? image_url(theme_config('home.support.image')) : theme_asset('img/seriva-reference.png');

    $serverAddress = theme_config('settings.server.ip')
        ?? optional($serverCollection->first())->fullAddress()
        ?? 'play.example.com';

    $showSidebar = !(
        theme_config('sidebar.buttons.off')
        && (theme_config('sidebar.vote.off') || !plugins()->isEnabled('vote'))
        && theme_config('sidebar.discord.off')
        && (theme_config('sidebar.article.off') || !plugins()->isEnabled('shop'))
    );
@endphp

@section('app')
    <main class="seriva-main">
        <div class="container-xl">
            <h1 class="d-none">{{ site_name() }}</h1>
            @include('elements.session-alerts')

            @if($message ?? false)
                <section class="seriva-surface seriva-message reveal-up">
                    {{ $message }}
                </section>
            @endif

            @if(! theme_config('home.hero.off'))
                <section class="seriva-surface seriva-hero reveal-up">
                    <div class="seriva-hero-grid">
                        <div class="seriva-copy">
                            <span class="seriva-chip">
                                <i class="bi bi-stars"></i>
                                {{ theme_config('home.hero.badge') ?? trans('theme::theme.hero.badge') }}
                            </span>

                            <h2 class="seriva-display">{{ theme_config('home.hero.title') ?? trans('theme::theme.hero.title') }}</h2>
                            <p class="seriva-lead">{{ theme_config('home.hero.subtitle') ?? trans('theme::theme.hero.subtitle') }}</p>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ $primaryAction }}" class="btn btn-primary btn-lg">
                                    {{ theme_config('home.hero.cta') ?? trans('theme::theme.hero.cta') }}
                                </a>
                                <button type="button"
                                        class="btn btn-outline-light btn-lg"
                                        data-copyboard="true"
                                        data-copyboard-text="{{ $serverAddress }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        data-bs-original-title="{{ trans('theme::theme.server_address_copied') }}"
                                        data-bs-trigger="manual"
                                        aria-label="{{ trans('theme::theme.copy_server_address') }}">
                                    <i class="bi bi-copy"></i>
                                    {{ $serverAddress }}
                                </button>
                            </div>

                            <ul class="seriva-checklist">
                                <li>{{ theme_config('home.hero.point_1') ?? trans('theme::theme.hero.point_1') }}</li>
                                <li>{{ theme_config('home.hero.point_2') ?? trans('theme::theme.hero.point_2') }}</li>
                                <li>{{ theme_config('home.hero.point_3') ?? trans('theme::theme.hero.point_3') }}</li>
                            </ul>

                            <div class="seriva-counters">
                                <article class="seriva-counter">
                                    <p class="mb-1 text-uppercase">{{ trans('theme::theme.hero.float_score') }}</p>
                                    <strong data-count="server">{{ $totalPlayers }}</strong>
                                    <small>{{ trans('theme::theme.online_players') }}</small>
                                </article>
                                <article class="seriva-counter">
                                    <p class="mb-1 text-uppercase">{{ trans('theme::theme.join_community') }}</p>
                                    <strong data-count="discord">0</strong>
                                    <small>{{ trans('theme::theme.online') }}</small>
                                </article>
                            </div>
                        </div>

                        <div class="seriva-media">
                            <img src="{{ $heroImage }}" alt="{{ trans('theme::theme.hero.image_alt') }}" class="img-fluid seriva-media-image">

                            <div class="seriva-media-panel">
                                <div class="d-flex flex-column gap-2" data-editable="true">
                                    <p class="mb-0 fw-semibold">{{ theme_config('home.hero.float_review') ?? trans('theme::theme.hero.float_review') }}</p>
                                    <small class="opacity-75">
                                        {{ theme_config('home.hero.float_score_label') ?? trans('theme::theme.hero.float_score') }}:
                                        {{ theme_config('home.hero.float_score_value') ?? '100+' }}
                                    </small>
                                </div>

                                <ul class="list-unstyled mb-0 d-grid gap-2">
                                    @forelse($serverCollection->take(3) as $server)
                                        <li class="seriva-server-line">
                                            <span>{{ $server->name }}</span>

                                            @if($server->isOnline())
                                                <span class="badge text-bg-success">
                                                    {{ $server->getOnlinePlayers() }}/{{ $server->getMaxPlayers() }}
                                                </span>
                                            @else
                                                <span class="badge text-bg-danger">{{ trans('messages.server.offline') }}</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li class="seriva-server-line">
                                            <span>{{ site_name() }}</span>
                                            <span class="badge text-bg-secondary">N/A</span>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <div class="row g-4 mt-1">
                <div class="{{ $showSidebar ? 'col-lg-8 col-xl-9' : 'col-12' }} d-flex flex-column gap-4">
                    @if(! theme_config('home.support.off'))
                        <section class="seriva-surface seriva-split reveal-up">
                            <div class="row g-4 align-items-center">
                                <div class="col-lg-5">
                                    <img src="{{ $supportImage }}" alt="{{ trans('theme::theme.sections.support_image_alt') }}" class="img-fluid seriva-rounded-image">
                                </div>
                                <div class="col-lg-7">
                                    <h2 class="seriva-section-title">{{ theme_config('home.support.title') ?? trans('theme::theme.sections.support_title') }}</h2>
                                    <p class="seriva-lead mb-4">{{ theme_config('home.support.subtitle') ?? trans('theme::theme.sections.support_subtitle') }}</p>

                                    <ul class="list-unstyled d-grid gap-2 mb-4">
                                        <li class="seriva-point"><i class="bi bi-check-circle-fill"></i>{{ theme_config('home.support.point_1') ?? trans('theme::theme.sections.support_point_1') }}</li>
                                        <li class="seriva-point"><i class="bi bi-check-circle-fill"></i>{{ theme_config('home.support.point_2') ?? trans('theme::theme.sections.support_point_2') }}</li>
                                        <li class="seriva-point"><i class="bi bi-check-circle-fill"></i>{{ theme_config('home.support.point_3') ?? trans('theme::theme.sections.support_point_3') }}</li>
                                    </ul>

                                    <a href="{{ $primaryAction }}" class="btn btn-outline-primary">
                                        {{ theme_config('home.support.cta') ?? trans('theme::theme.hero.cta') }}
                                    </a>
                                </div>
                            </div>
                        </section>
                    @endif

                    @if(! theme_config('home.results.off') || $serverCollection->isNotEmpty())
                        <section class="seriva-surface reveal-up">
                            <div class="row g-4">
                                @if(! theme_config('home.results.off'))
                                    <div class="col-xl-5">
                                        <h2 class="seriva-section-title">{{ theme_config('home.results.title') ?? trans('theme::theme.results.title') }}</h2>
                                        <p class="seriva-lead">{{ theme_config('home.results.subtitle') ?? trans('theme::theme.results.subtitle') }}</p>

                                        <article class="seriva-testimonial mt-4">
                                            <p class="mb-2">“{{ theme_config('home.results.quote') ?? trans('theme::theme.results.quote') }}”</p>
                                            <small>{{ theme_config('home.results.author') ?? trans('theme::theme.results.author') }}</small>
                                        </article>
                                    </div>
                                @endif

                                @if($serverCollection->isNotEmpty())
                                    <div class="{{ theme_config('home.results.off') ? 'col-12' : 'col-xl-7' }}">
                                        <div class="row g-3">
                                            @foreach($serverCollection->take(4) as $server)
                                                <div class="col-md-6">
                                                    <article class="seriva-server-card">
                                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                                            <h3>{{ $server->name }}</h3>
                                                            @if($server->isOnline())
                                                                <span class="badge text-bg-success">{{ trans('theme::theme.online') }}</span>
                                                            @else
                                                                <span class="badge text-bg-danger">{{ trans('messages.server.offline') }}</span>
                                                            @endif
                                                        </div>

                                                        @if($server->isOnline())
                                                            <div class="progress mt-3">
                                                                <div class="progress-bar" role="progressbar" style="width: {{ $server->getPlayersPercents() }}%"></div>
                                                            </div>

                                                            <p class="mb-0 mt-2 text-muted">
                                                                {{ trans_choice('messages.server.total', $server->getOnlinePlayers(), ['max' => $server->getMaxPlayers()]) }}
                                                            </p>
                                                        @else
                                                            <p class="mb-0 mt-3 text-muted">{{ trans('messages.server.offline') }}</p>
                                                        @endif

                                                        @if($server->join_url)
                                                            <a href="{{ $server->join_url }}" class="btn btn-primary btn-sm mt-3">
                                                                {{ trans('messages.server.join') }}
                                                            </a>
                                                        @else
                                                            <p class="mb-0 mt-3 text-muted">{{ $server->fullAddress() }}</p>
                                                        @endif
                                                    </article>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif

                    @if(! theme_config('home.blog.off'))
                        <section class="seriva-surface reveal-up">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                                <h2 class="seriva-section-title">{{ theme_config('home.blog.title') ?? trans('theme::theme.blog.title') }}</h2>
                                @if(Route::has('posts.index'))
                                    <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                                        {{ theme_config('home.blog.all_articles') ?? trans('theme::theme.blog.all_articles') }}
                                    </a>
                                @endif
                            </div>

                            @if($blogPosts->isNotEmpty())
                                <div class="row g-3">
                                    @foreach($blogPosts as $post)
                                        <div class="col-md-6 col-xl-4">
                                            <a class="seriva-post h-100" href="{{ route('posts.show', $post) }}">
                                                <div class="seriva-post-image">
                                                    @if($post->hasImage())
                                                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="img-fluid h-100 w-100 object-fit-cover">
                                                    @else
                                                        <i class="bi bi-controller"></i>
                                                    @endif
                                                </div>
                                                <div class="seriva-post-body">
                                                    <small>{{ format_date($post->published_at) }}</small>
                                                    <h3>{{ $post->title }}</h3>
                                                    <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <article class="seriva-post h-100">
                                            <div class="seriva-post-body">
                                                <h3>{{ theme_config('home.blog.placeholder_1_title') ?? trans('theme::theme.blog.placeholder_1_title') }}</h3>
                                                <p>{{ theme_config('home.blog.placeholder_1_text') ?? trans('theme::theme.blog.placeholder_1_text') }}</p>
                                            </div>
                                        </article>
                                    </div>
                                    <div class="col-md-6">
                                        <article class="seriva-post h-100">
                                            <div class="seriva-post-body">
                                                <h3>{{ theme_config('home.blog.placeholder_2_title') ?? trans('theme::theme.blog.placeholder_2_title') }}</h3>
                                                <p>{{ theme_config('home.blog.placeholder_2_text') ?? trans('theme::theme.blog.placeholder_2_text') }}</p>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            @endif
                        </section>
                    @endif
                </div>

                @if($showSidebar)
                    <aside class="col-lg-4 col-xl-3 d-flex flex-column gap-4">
                        @include('components.sidebar.buttons')
                        @include('components.sidebar.top-vote')
                        @include('components.sidebar.discord')
                        @include('components.sidebar.hightlight-shop')
                    </aside>
                @endif
            </div>
        </div>
    </main>
@endsection
