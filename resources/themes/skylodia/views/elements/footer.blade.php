<footer class="footer box-sizing pt-5">
        <div class="container">
            <div class="footer__content row gx-9 gy-10 justify-content-center align-items-center">
                <div class="col-md-6 ps-md-0 pe-5 border-md-3 border-end border-white border-opacity-10">
                    <h3 class="text-white mb-3">{{ setting('copyright') }}</h3>
                    <p>{{theme_config('footer.index.about_us.paragraph' ?? "Créé en 2023, Skylodia se distingue en tant que serveur Minecraft Francophone dédié au mode SkyBlock, visant à offrir une expérience de jeu novatrice qui repousse les frontières du gameplay vanilla. Fruit d'une réflexion approfondie et de plusieurs mois d'efforts intensifs, Skylodia représente une véritable révolution dans le monde du skyblock.")}}</p>
                </div>
                <div class="col-md-1">
                    <ul class="d-flex flex-column gap-2 list-unstyled m-0 p-md-0">
                        @if(theme_config('footer.index.link'))
                            @foreach(theme_config('footer.index.link') as $link)
                                @if($link['text'] != null)
                                    <li><a class="footer-link d-flex align-items-center text-white fw-semibold text-decoration-none" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-lg-4 text-center">
                    <a href="{{theme_config('footer.index.button.link') ?? "/shop"}}" class="btn btn-primary footer__btn text-uppercase active mx-auto">
                        {{theme_config('footer.index.button.text') ?? "Boutique"}}
                    </a>
                </div>
            </div>
        </div>
        <p class="container opacity-25 pb-3 text-sm mt-3 text-center text-md-start px-4"><span title="Version {{$version_theme['version']}}">{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
</footer>
