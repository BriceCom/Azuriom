@if(!theme_config('home.hym.off'))
    @include('components.card-infos',
       [
           'wrapperClass' => "bg-secondary bg-opacity-10",
           'logo' => theme_config('home.hym.logo') ?? false,
           'title' => theme_config('home.hym.title') ?? 'HYM-Network',
           'description' => theme_config('home.hym.description') ?? 'Notre ambition depuis 2015 : réunir une grande communauté francophone autour des modes de jeu qui vous passionnent, sur des serveurs sécurisés, pensés pour offrir la meilleure expérience de jeu possible.',
           'joinButton' => theme_config('home.hym.joinButton') ?? false,
           'leftImgSrc' => theme_config('home.hym.leftImgSrc') ? image_url(theme_config('home.hym.leftImgSrc')): null,
           'rightImgSrc' => theme_config('home.hym.rightImgSrc') ? image_url(theme_config('home.hym.rightImgSrc')): null,
           'button' => [
               'href' => theme_config('home.hym.button.href'),
               'label' => theme_config('home.hym.button.label')
           ],
           'imgInText' => [
               'src' => theme_config('home.hym.imgInText.src') ? image_url(theme_config('home.hym.imgInText.src')): theme_asset('/img/hym.webp'),
               'alt' => theme_config('home.hym.imgInText.alt') ?? 'Logo HYM Network'
            ],
           'badges' => theme_config('home.hym.badges') ?? [
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
