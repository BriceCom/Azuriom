@if(!theme_config('home.welcome.off'))
    @include('components.card-infos',
               [
                   'logo' => theme_config('home.welcome.logo') ?? true,
                   'title' => theme_config('home.welcome.title') ?? 'Bienvenue sur SkyOfSKill !',
                   'description' => theme_config('home.welcome.description') ?? 'SkyOfSkill est le premier serveur Minecraft Prison français. C’est l’unique serveur à le fusionner au SkyBlock pour une experience immersive. Progresse en prison, améliore ton île, débloque des récompenses exclusives et gagne les classements.',
                   'joinButton' => theme_config('home.welcome.joinButton') ?? false,
                   'leftImgSrc' => theme_config('home.welcome.leftImgSrc') ? image_url(theme_config('home.welcome.leftImgSrc')): null,
                   'rightImgSrc' => theme_config('home.welcome.rightImgSrc') ? image_url(theme_config('home.welcome.rightImgSrc')): theme_asset('img/boy.webp'),
                   'button' => [
                       'href' => theme_config('home.welcome.button.href') ?? '/jouer',
                       'label' => theme_config('home.welcome.button.label') ?? 'Comment jouer sur le serveur ?'
                   ],
                   'imgInText' => theme_config('home.welcome.imgInText.src') ? [
                       'src' => image_url(theme_config('home.welcome.imgInText.src')),
                       'alt' => theme_config('home.welcome.imgInText.alt')
                   ] : null,
                   'badges' => theme_config('home.welcome.badges') ?? [
                                    [
                                        'icon' => 'bi-star-fill',
                                        'htmlContent' => 'Record de joueurs: <strong>721</strong>',
                                    ],
                                    [
                                        'icon' => 'bi-calendar3',
                                        'htmlContent' => 'Ouvert depuis <strong>2019</strong>',
                                    ],
                                    [
                                        'icon' => 'bi-heart-fill',
                                        'htmlContent' => '<strong>+117000</strong> joueurs uniques',
                                    ],
                                ],
               ]
           )
@endif
