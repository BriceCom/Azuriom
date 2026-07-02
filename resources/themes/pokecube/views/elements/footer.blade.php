<footer class="site-footer text-white pt-5 pb-3">
    <div class="container">

        <div class="row text-center text-md-start">

            <div class="col-md-3 mb-4 footer-brand-block">
                <div class="footer-brand">
                    <img src="{{ site_logo() }}" alt="Logo" class="footer-logo-small">
                    <span class="footer-server-name">{{ site_name() }}</span>
                </div>

                <p class="footer-text footer-description">
                    {!! theme_config('footer_description') !!}
                </p>
            </div>


            {{-- Navigation --}}
            <div class="col-md-3 mb-4">
                <h5 class="footer-title">Navigation</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Accueil</a></li>
                    <li><a href="{{ url('/tebex') }}">Boutique</a></li>
                    <li><a href="{{ url('/vote') }}">Vote</a></li>
                    <li><a href="{{ url('/wiki') }}">Wiki</a></li>
                </ul>
            </div>

            {{-- Communauté --}}
            <div class="col-md-3 mb-4">
                <h5 class="footer-title">Communauté</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/rules') }}">Règlement</a></li>
                    <li><a href="{{ theme_config('discord_url') }}">Discord</a></li>
                </ul>
            </div>

            {{-- Social --}}
            <div class="col-md-3 mb-4">
                <h5 class="footer-title">Social</h5>

                <div class="footer-social-icons">
                    <a href="{{ theme_config('discord_url') }}" class="social-circle discord"><i class="fab fa-discord"></i></a>
                    <a href="{{ theme_config('tiktok_url') }}" class="social-circle twitter"><i class="fab fa-tiktok"></i></a>
                    <a href="{{ theme_config('youtube_url') }}" class="social-circle youtube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

        </div>

        <hr class="footer-separator">

        <div class="text-center mt-3">
            <small class ="footer-cgu">
                <a href="https://azuriom.com" target="_blank">CGU/CGV</a>
            </small>
        </div>

        <div class="text-center mt-3">
            <small class="footer-legal">
                © {{ date('Y') }} Faylora. Tous droits réservés. Non affilié à Mojang Studios.
                Propulsé par <a href="https://azuriom.com" target="_blank">Azuriom</a>
            </small>
        </div>

    </div>
</footer>
