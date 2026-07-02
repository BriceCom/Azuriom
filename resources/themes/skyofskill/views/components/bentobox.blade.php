<div class="bentobox d-flex flex-column gap-4 mt-7 mt-md-15">
    <div class="d-flex flex-column flex-lg-row gap-4">
            <div class="bentobox-card bentobox-card__shop-wrapper">
                <a class="bentobox-card bentobox-card__shop"
                   href="{{theme_config('home.bentobox.shop.href') ?? "/shop"}}"
                   style="
                --linear-end: #FFDB59;
                --linear-start: #EBB907;
            ">
                    <div class="bentobox-card__content">
                        <div class="bentobox-card__icon">
                            <i class="bi bi-cart4"></i>
                        </div>
                        <h3 class="bentobox-card__title">
                            {{theme_config('home.bentobox.shop.title') ?? "Boutique"}}
                        </h3>
                    </div>
                </a>

                <div class="bentobox-card__shop-chest position-absolute top-50 end-0 translate-middle-y">
                    <img src="{{ theme_asset('img/chest.webp') }}" class="object-fit-contain" alt="">
                </div>
            </div>

            <div class="bentobox-card__small d-flex flex-column flex-sm-row gap-4">
                <a class="bentobox-card bentobox-card__small"
                   href="{{theme_config('settings.discord.link') ?? "#"}}"
                   target="_blank"
                   style="
                --linear-end: #939CFF;
                --linear-start: #5865F2;
            ">
                    <div class="bentobox-card__content">
                        <div class="bentobox-card__discord">
                            <i class="bi bi-discord"></i>
                        </div>
                        <h3 class="bentobox-card__title">
                            {{theme_config('home.bentobox.discord.title') ?? "7,000+"}}
                        </h3>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="pulse"></div>
                            <span class="bentobox-card__subtitle">
                                {{theme_config('home.bentobox.discord.text') ?? "Membres"}}
                            </span>
                        </div>
                    </div>
                </a>

                <a class="d-lg-none bentobox-card bentobox-card__small"
                   href="{{theme_config('home.bentobox.vote.href') ?? "/vote"}}"
                   style="
                --linear-end: #F880FF;
                --linear-start: #A412AD;
            ">
                    <div class="bentobox-card__content">
                        <div class="bentobox-card__icon">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <h3 class="bentobox-card__title">
                            {{theme_config('home.bentobox.vote.title') ?? "Voter"}}
                        </h3>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span class="bentobox-card__subtitle">{{theme_config('home.bentobox.vote.text') ?? "Cadeaux gratuits"}}</span>
                        </div>
                    </div>
                </a>
            </div>
    </div>
    <div class="d-flex flex-column flex-lg-row gap-4">
        <a class="d-none d-lg-flex bentobox-card bentobox-card__small"
           href="{{theme_config('home.bentobox.vote.href') ?? "/vote"}}"
           style="
                --linear-end: #F880FF;
                --linear-start: #A412AD;
            ">
            <div class="bentobox-card__content">
                <div class="bentobox-card__icon">
                    <i class="bi bi-gift-fill"></i>
                </div>
                <h3 class="bentobox-card__title">
                    {{theme_config('home.bentobox.vote.title') ?? "Voter"}}
                </h3>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="bentobox-card__subtitle">{{theme_config('home.bentobox.vote.text') ?? "Cadeaux gratuits"}}</span>
                </div>
            </div>
        </a>

        <div class="bentobox-card">
            <div class="bentobox-card__bgImg"
                 style="--background: url('{{ theme_config('home.bentobox.howToJoin.bg') ? image_url(theme_config('home.bentobox.howToJoin.bg')) : image_url(setting('background')) }}')"></div>
            <a
                href="{{theme_config('home.bentobox.howToJoin.href') ?? "/#comment-nous-rejoindre"}}"
                class="bentobox-card__content">
                <h3 class="bentobox-card__title">
                    {{theme_config('home.bentobox.howToJoin.title') ?? "Comment jouer ?"}}
                </h3>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <span class="bentobox-card__subtitle">
                        {{theme_config('home.bentobox.howToJoin.text') ?? "Au serveur minecraft SkyBlock OpPrison n°1 en France ?"}}
                    </span>
                </div>
            </a>

            <div class="bentobox-card__players z-2 position-absolute top-0 end-0 pe-3 pt-3">
                <div class="d-flex align-items-center justify-content-center gap-2 text-white fw-bold">
                    <span data-count="server">0</span>
                    <span class="text-uppercase">Joueurs</span>
                    <div class="pulse"></div>
                </div>
            </div>

            <div class="z-2 position-absolute top-100 start-50 translate-middle">
                @include('components.join-button', ['variant' => 'primary', 'class' => 'bentobox-card__copyip'])
            </div>
        </div>
    </div>

    @include('components.alert', [
                                 'class' => 'mt-5 justify-content-center',
                                 'type' => 'success',
                                 'message' => theme_config('home.bentobox.howToJoinServerText') ?? "<p>Clique ici pour pour voir <strong>comment rejoindre</strong> un Serveur Minecraft en <strong>vidéo !</strong></p>",
                                 'icon' => theme_config('home.bentobox.howToJoinServerIcon') ?? 'bi bi-play-btn-fill',
                                 'href'=> theme_config('home.bentobox.howToJoinServerHref') ?? '#',
                                 'target'=> "_blank"
                             ])
</div>
