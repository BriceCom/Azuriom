<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 section-copy">
                <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">{{ theme_config('home.hero.badge') ?? 'Nous soutenir' }}</span>
                <h1>{{ theme_config('home.hero.title') ?? 'LREM IPSUM IS SIMPLY DUMMY TEXT OFAND !' }}</h1>
                <p>
                    {{ theme_config('home.hero.text') ?? 'Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simp' }}
                </p>
                <div class="hero-buttons">
                    <div>
                        <x-join-button variant="primary" />
                        <div class="online-status mt-2">
                            <span class="status-dot"></span>
                            <span class="status-text"><span data-count="server">0</span> {{ trans('theme::theme.online_players') }}</span>
                        </div>
                    </div>
                    <a href="{{ theme_config('settings.discord.link') ?? '#' }}" class="btn btn-quaternary" target="_blank">Discord</a>
                </div>
            </div>
            <div class="col-lg-5">
                <img src="{{ theme_config('home.hero.image') ? image_url(theme_config('home.hero.image')) : 'https://images.unsplash.com/photo-1759663174469-f1e2a7a4bdcb?w=330&h=409&fit=crop' }}" alt="Hero" class="hero-image" />
            </div>
        </div>
    </div>
</section>
