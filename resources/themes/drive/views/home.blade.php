@extends('layouts.base')

@section('title', trans('messages.home'))

@php
    $newsPosts = $posts->take(5);
    $topVoters = plugins()->isEnabled('vote') ? vote_leaderboard()->take(3) : collect();
@endphp

@section('app')
    <main id="content" class="drive-page drive-home">
        <h1 class="d-none">{{ site_name() }}</h1>

        @include('elements.session-alerts')

        <section class="drive-bento">
            <article class="drive-bento__panel drive-bento__panel--intro" data-aos="fade-up">
                <span class="drive-kicker">Server Access</span>
                <h2>{{ theme_config('home.cta.title') ?? 'Join '.site_name().' in one click' }}</h2>
                <p>
                    {{ theme_config('home.cta.text') ?? 'Copy the server IP instantly or launch the client directly, then continue with the latest community updates.' }}
                </p>
                <div class="drive-hero__actions">
                    @include('components.join-button', ['variant' => 'primary', 'class' => 'drive-copyip-btn'])
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-tertiary">Dernieres nouveautes</a>
                </div>

                <p class="mb-0 drive-inline-stat">
                    <span class="pulse"></span>
                    <strong data-count="server">0</strong> joueurs en ligne
                </p>
            </article>

            <article class="drive-bento__panel drive-bento__panel--news-carousel" data-aos="fade-up" data-aos-delay="80">
                @if(!theme_config('home.news.off') && ! $newsPosts->isEmpty())
                    <div id="driveNewsCarousel" class="carousel slide drive-news-carousel" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($newsPosts as $post)
                                <button type="button"
                                        data-bs-target="#driveNewsCarousel"
                                        data-bs-slide-to="{{ $loop->index }}"
                                        class="@if($loop->first) active @endif"
                                        aria-current="@if($loop->first) true @endif"
                                        aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach($newsPosts as $post)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <a href="{{ route('posts.show', $post) }}" class="drive-news-slide">
                                        <img src="{{ $post->hasImage() ? $post->imageUrl() : 'https://placehold.co/1400x800' }}"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="{{ $post->title }}">

                                        <span class="drive-news-slide__overlay"></span>

                                        <span class="drive-news-slide__content">
                                            <span class="drive-kicker drive-kicker--sm">News</span>
                                            <span class="drive-news-slide__title">{{ $post->title }}</span>
                                            <span class="drive-news-slide__excerpt">{{ Str::limit(strip_tags($post->content), 135) }}</span>
                                            <span class="drive-news-slide__meta">{{ format_date($post->published_at) }}</span>
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#driveNewsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#driveNewsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @elseif(!theme_config('home.news.off'))
                    <div class="drive-bento__empty">
                        <h3 class="drive-panel-title">Dernieres nouveautes</h3>
                        <p class="mb-0">Aucun article publie pour le moment.</p>
                    </div>
                @else
                    <div class="drive-bento__empty">
                        <h3 class="drive-panel-title">Dernieres nouveautes</h3>
                        <p class="mb-0">Le module d'actualites est desactive dans les parametres du theme.</p>
                    </div>
                @endif
            </article>

            @if(theme_config('home.video.trailer.off') !== 'on')
                <div class="drive-trailer-stage" data-aos="fade-up" data-aos-delay="130">
                    @include('components.trailer')
                </div>
            @endif

            <article class="drive-bento__panel drive-bento__panel--top-voters" data-aos="fade-up" data-aos-delay="180">
                <h3 class="drive-panel-title">Top Voteurs</h3>
                <p class="mb-3 opacity-75">Top 3 du mois actuel.</p>

                @if(plugins()->isEnabled('vote') && ! $topVoters->isEmpty())
                    <div class="drive-voters">
                        @foreach($topVoters as $vote)
                            @php($skinIdentifier = $vote->user->game_id ?: $vote->user->name)
                            <a href="{{ route('vote.home') }}"
                               class="drive-voter-card @if($loop->first) is-first @elseif($loop->iteration === 2) is-second @else is-third @endif">
                                <span class="drive-voter-card__rank">#{{ $vote->position }}</span>
                                <img src="https://mc-heads.net/body/{{ $skinIdentifier }}/right"
                                     alt="{{ $vote->user->name }}"
                                     loading="lazy"
                                     width="94"
                                     height="130"
                                     onerror="this.onerror=null;this.src='{{ $vote->user->getAvatar(96) }}';">
                                <strong>{{ $vote->user->name }}</strong>
                                <small>{{ $vote->votes }} {{ trans('vote::messages.fields.votes') }}</small>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="mb-0 opacity-75">Activez le plugin Vote pour afficher le classement des voteurs.</p>
                @endif
            </article>

            <article class="drive-bento__panel drive-bento__panel--shop-cta" data-aos="fade-up" data-aos-delay="240">
                <div class="drive-shop-cta__header">
                    <div>
                        <span class="drive-shop-cta__badge">Exclusive Store</span>
                        <h3 class="drive-panel-title">Boutique</h3>
                        <p class="mb-3 opacity-75">Soutenez le serveur et debloquez des avantages exclusifs.</p>
                    </div>

                    <span class="drive-shop-cta__icon" aria-hidden="true">
                        <i class="bi bi-gem"></i>
                    </span>
                </div>

                @if(plugins()->isEnabled('shop'))
                    <a href="{{ route('shop.home') }}" class="btn btn-outline-tertiary w-100">
                        <i class="bi bi-bag-check me-1"></i>
                        Acceder a la boutique
                    </a>
                @else
                    <p class="mb-0">Le plugin Shop n'est pas active.</p>
                @endif
            </article>

            <article class="drive-bento__panel drive-bento__panel--socials" data-aos="fade-up" data-aos-delay="300">
                <h3 class="drive-panel-title">Stay Connected</h3>
                <p class="mb-3 opacity-75">Rejoignez Discord et consultez les membres en ligne en direct.</p>

                <a href="{{ theme_config('settings.discord.link') ?? 'https://discord.gg/ZdSPkxK5xT' }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-discord me-1"></i> {{ trans('theme::theme.join') }}
                </a>

                <div data-editable="true" class="d-flex align-items-center justify-content-end gap-2 mb-2">
                    <span class="pulse"></span>
                    <small class="text-xs fw-semibold text-uppercase">{{ theme_config('header.hero.discord.title') ?? str_replace(':count', '{discord_online}', trans('theme::theme.discord_online')) }}</small>
                </div>

                <ul class="discord-list d-flex flex-column gap-2 p-3 rounded-3 mb-3"></ul>

                @include('components.socials')
            </article>
        </section>
    </main>
@endsection
