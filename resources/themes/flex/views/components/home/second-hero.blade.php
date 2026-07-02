<section class="second-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="{{ theme_config('home.second-hero.image') ? image_url(theme_config('home.second-hero.image')) : 'https://images.unsplash.com/photo-1765881736141-bda98391c3b5?w=497&h=331&fit=crop' }}" alt="Section" class="section-image" />
            </div>
            <div class="col-lg-6 section-copy">
                <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">{{ theme_config('home.second-hero.badge') ?? 'Nous soutenir' }}</span>
                <h2>{{ theme_config('home.second-hero.title') ?? 'LREM IPSUM IS SIMPLY DUMMY TEXT OFAND !' }}</h2>
                <p>
                    {{ theme_config('home.second-hero.text') ?? 'Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simp' }}
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ theme_config('sidebar.shop_button.url') ?? '#' }}" class="btn btn-primary">{{ theme_config('sidebar.shop_button.text') ?? 'Boutique' }}</a>
                    <a href="{{ theme_config('home.second-hero.contact.url') ?? '#' }}" class="btn btn-primary-outline">{{ theme_config('home.second-hero.contact.text') ?? 'Nous contacter' }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
