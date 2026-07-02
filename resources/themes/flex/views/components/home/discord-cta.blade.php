@if(!theme_config('home.discord.off'))
<section class="discord-cta-section">
    <div class="container">
        <div class="section-copy text-center">
            <span class="badge text-bg-quaternary text-quaternary text-uppercase fw-bold px-3 py-2 mb-3">{{ theme_config('home.discord.badge') ?? 'Discord' }}</span>
            <h2 class="mb-3">{{ theme_config('home.discord.title') ?? 'Lrem Ipsum is simply dummy' }}</h2>
            <p class="mb-4">
                {{ theme_config('home.discord.text') ?? 'Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of' }}
            </p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ theme_config('settings.discord.link') ?? '#' }}" class="btn btn-quaternary" target="_blank">Rejoindre le discord</a>
                <a href="{{ theme_config('settings.discord.link') ?? '#' }}" class="btn btn-quaternary-outline" target="_blank">Rejoindre le discord</a>
            </div>
        </div>
    </div>
</section>
@endif
