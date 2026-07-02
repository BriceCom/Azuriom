@extends('layouts.app')

@section('title', "Accueil")

@section('content')


@include('elements.section')




<div class="home-section">
    <div class="home-container">
        <div class="presentation">
            <h2>REJOIGNEZ L'AVENTURE DE <span class="presentation-title-poke">POKE</span><span class="presentation-title-cube">CUBE</span> AVEC VOS AMIS !</h2>
            <p>{{theme_config('presentation-text') }}</p>
            <a href="https://pokecube.fr/p/jouer" class="hero-action-btn ip-btn">
                <span>REJOINDRE LE SERVEUR</span>
            </a>
        </div>
            <div class="home-card">
                <div class="home-card-inner">
                    <div class="home-card-text">
                        <h5>COMMENT REJOINDRE ?</h5>
                        <div class="card-element">
                            <span class="card-typewriter" data-text="Télécharger le launcher"></span>
                            <a href="https://pokecube.fr/p/jouer" class="link-btn">
                                <i class="fa-solid fa-download" style="color: rgb(255, 255, 255);"></i>
                            </a>
                        </div>
                        <div class="card-element">
                            <span class="card-typewriter" data-text="play.pokecube.fr"></span>
                            <a href="#" class="link-btn">
                                <i style="color: rgb(255, 255, 255);"></i> MODPACK
                            </a>
                        </div>
                    </div>
                    <div class="pres-card-img">
                        <img src="{{ theme_asset('img/imgpres.png') }}" alt="laggron">
                    </div>
                </div>
            </div>
    </div>

    @php
        $raw = theme_config('carousel-items', []);
        $carouselItems = is_array($raw) ? $raw : (json_decode($raw, true) ?? []);
    @endphp

    @if(!empty($carouselItems))
    <div class="home-carousel-section">
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">
                @foreach($carouselItems as $i => $item)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div class="carousel-layout">
                        {{-- Image à gauche --}}
                        <div class="carousel-img-wrapper">
                            @if(!empty($item['image']))
                                <img src="{{ $item['image'] }}" class="carousel-bg-img" alt="{{ $item['title'] }}">
                            @else
                                <div class="carousel-img-placeholder"></div>
                            @endif
                        </div>
                        {{-- Titre + description à droite --}}
                        <div class="carousel-content">
                            <h5>POURQUOI <span class="presentation-title-poke">POKE</span><span class="presentation-title-cube">CUBE</span> ?</h5>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['description'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

                <div class="carousel-controls-wrapper">
                    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <div class="carousel-indicators-custom">
                        @foreach($carouselItems as $i => $item)
                            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>

                    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

        </div>
    </div>
    @endif
</div>
<div class="home-stats-wrapper">
    <div class="home-stats-line left"></div>

    <div class="home-stats-block">
        <span class="home-stats-title"><span class="presentation-title-poke">POKE</span><span class="presentation-title-cube">CUBE</span> EN CHIFFRE</span>
        <div class="home-stats">

            <div class="stat-item">
                @php
                    $totalUsers = \Azuriom\Models\User::count();
                @endphp
                <span class="stat-number">{{ number_format($totalUsers, 0, ',', ' ') }} <i class="fa-solid fa-user"></i></span>
                <span class="stat-label">JOUEURS INSCRITS</span>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <span class="stat-number">{{ theme_config('record')}} <i class="fa-solid fa-trophy"></i></span>
                <span class="stat-label">RECORDS</span>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <span class="stat-number">
                    @if(file_exists(theme_path('img/stats_logo.png')))
                        <img src="{{ theme_asset('img/stats_logo.png') }}" alt="Logo" style="height: 50px; width: auto;">
                    @else
                        <span class="presentation-title-poke">POKE</span><span class="presentation-title-cube">CUBE</span>
                    @endif
                </span>
                <span class="stat-label">SERVEUR MINECRAFT</span>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <span class="stat-number"><span class="stat-number">
    @if(!$servers->isEmpty())
        {{ $servers->first()->getOnlinePlayers() }}
    @else
        ...
    @endif
</span>
 <i class="fa-solid fa-signal"></i></span>
                <span class="stat-label">EN LIGNE</span>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <span class="stat-number">{{theme_config('vues-moyen')}} ⭐</span>
                <span class="stat-label">VUES MOYENS</span>
            </div>

        </div>
    </div>

    <div class="home-stats-line right"></div>
</div>

<div class="home-diagonal-wrapper">

    <div class="discord-card-outer">
        <div class="home-diagonal-content">
            <div class="discord-card">
                <div class="discord-card-img">
                    <img src="{{ theme_asset('img/wumpus.png') }}" alt="Wumpus">
                </div>
                <div class="discord-card-body">
                    <h3>REJOINS NOTRE DISCORD !</h3>
                    <p>Retrouve la communauté PokeCube sur notre serveur Discord. Annonces, événements, entraide et bien plus t'attendent !</p>
                    <a href="https://discord.gg/pokecube" class="discord-join-btn" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-discord"></i>
                        REJOINDRE LE DISCORD
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="home-diagonal-section">
        <div class="home-diagonal-content">

            {{-- NEWS dans la continuité de l'orange --}}
            <div class="home-news-section-inner">

                <div class="home-section-title-wrapper">
                    <span class="home-section-title home-section-title--light">NOS DERNIÈRES NOUVEAUTÉS</span>
                </div>

                <div class="home-news-container">

                    @if($posts->isEmpty())
                        <div class="home-news-empty home-news-empty--light">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            AUCUNE NOUVEAUTÉ N'A ÉTÉ CRÉÉE POUR LE MOMENT
                        </div>
                    @else
                        @foreach($posts->take(3) as $post)
                        <a href="{{ route('posts.show', $post->slug) }}" class="home-news-card-link">
                            <div class="home-news-card">

                                @if($post->hasImage())
                                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="home-news-img">
                                @elseif(theme_config('articles_default_image'))
                                    <img src="{{ image_url(theme_config('articles_default_image')) }}" alt="{{ $post->title }}" class="home-news-img">
                                @else
                                    <div class="home-news-img-placeholder"></div>
                                @endif

                                <div class="home-news-body">
                                    <h4>{{ $post->title }}</h4>
                                    <p>{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    <div class="home-news-meta">
                                        <span><i class="fa-solid fa-clock"></i> {{ format_date($post->created_at) }}</span>
                                        <span><i class="fa-solid fa-user"></i> {{ $post->author->name }}</span>
                                    </div>
                                </div>

                            </div>
                        </a>
                        @endforeach
                    @endif

                </div>

                <div class="home-news-btn-wrapper">
                    <a href="{{ route('posts.index') }}" class="discord-join-btn">
                        <i class="fa-solid fa-newspaper"></i>
                        TOUTES LES NOUVEAUTÉS
                    </a>
                </div>

            </div>

        </div>
    </div>


</div>
<script>
function typewriterAll() {
    const els = document.querySelectorAll('.card-typewriter');
    els.forEach((el, i) => {
        const text = el.dataset.text;

        // Écrit le texte final invisible pour réserver la place
        el.textContent = text;
        el.style.visibility = 'hidden';
        el.style.width = el.offsetWidth + 'px'; // fixe la largeur finale

        // Efface et recommence lettre par lettre
        el.textContent = '';
        el.style.visibility = 'visible';

        let j = 0;
        setTimeout(() => {
            const interval = setInterval(() => {
                el.textContent += text[j];
                j++;
                if (j >= text.length) clearInterval(interval);
            }, 50);
        }, i * (text.length * 50 + 300));
    });
}

document.fonts.ready.then(() => {
    const img = document.querySelector('.pres-card-img img');
    if (img && !img.complete) {
        img.addEventListener('load', typewriterAll);
    } else {
        typewriterAll();
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.home-container, .home-carousel-section, .home-stats-block, .home-stats-line, .discord-card, .home-news-section-inner, .last-infos').forEach(el => {
        observer.observe(el);
    });
});
</script>

@endsection