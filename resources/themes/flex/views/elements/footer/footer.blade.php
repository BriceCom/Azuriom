<footer class="footer">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-5">
                <img src="{{ theme_config('footer.index.logo') ? image_url(theme_config('footer.index.logo')) : site_logo() }}" alt="Logo" class="footer-logo mb-3" />
                <p class="footer-description">
                    {{ theme_config('footer.index.text') ?? "Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing an" }}
                </p>
                <div class="d-flex gap-3 align-items-center mb-3">
                    <x-join-button variant="primary" />
                    <div class="social-icons">
                        @if(theme_config('settings.discord.link'))
                            <a href="{{ theme_config('settings.discord.link') }}" class="social-icon discord-icon" target="_blank">
                                <i class="bi bi-discord text-white"></i>
                            </a>
                        @endif
                        {{-- On pourrait ajouter d'autres icônes ici selon la config --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <h5>Liens utiles</h5>
                <ul class="footer-links">
                    @if(theme_config('footer.index.links'))
                        @foreach(theme_config('footer.index.links') as $link)
                            @if(isset($link['links']))
                                @foreach($link['links'] as $sublink)
                                    <li><a href="{{ $sublink['href'] ?? '#' }}" @if(isset($sublink['target'])) target="_blank" @endif>{{ $sublink['name'] ?? '' }}</a></li>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>{{ theme_config('footer.index.button.title') ?? 'Soutenez-nous' }}</h5>
                <p class="footer-text mb-3">{{ theme_config('footer.index.button.description') ?? 'Lrem Ipsum is simply dummy text of the printing and typesetting' }}</p>
                <a href="{{ theme_config('footer.index.button.url') ?? '#' }}" class="btn btn-primary-outline">{{ theme_config('footer.index.button.text') ?? 'Boutique' }}</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="mb-0">
                {{ setting('copyright') }} | Réalisé par <span class="text-yellow">Dixept</span>. Propulsé par <span class="text-yellow">Azuriom</span>
            </p>
        </div>
    </div>
</footer>
