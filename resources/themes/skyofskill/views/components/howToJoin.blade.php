@if(!theme_config('home.howToJoin.off'))
    @include('components.card-infos',
               [
                   'id' => 'comment-nous-rejoindre',
                   'logo' => theme_config('home.howToJoin.logo') ?? false,
                   'title' => theme_config('home.howToJoin.title') ?? 'Comment rejoindre le serveur minecraft ?',
                   'description' => theme_config('home.howToJoin.description') ?? 'Pour rejoindre un serveur Minecraft comme SkyOfSkill, il suffit d’ouvrir Minecraft Java 1.20.1, puis d’aller dans le menu Multijoueur. Depuis cette interface, ajoute un nouveau serveur en cliquant sur « Ajouter un serveur ». Choisis le nom que tu veux et dans le champ Adresse du serveur indique <strong>PLAY.SKYOFSKILL.FR</strong>. Enfin valide l’ajout du serveur minecraft pour te connecter.',
                   'joinButton' => theme_config('home.howToJoin.joinButton') ?? true,
                   'leftImgSrc' => theme_config('home.howToJoin.leftImgSrc') ? image_url(theme_config('home.howToJoin.leftImgSrc')): theme_asset('img/girl.webp'),
                   'rightImgSrc' => theme_config('home.howToJoin.rightImgSrc') ? image_url(theme_config('home.howToJoin.rightImgSrc')): null,
                   'button' => [
                       'href' => theme_config('home.howToJoin.button.href'),
                       'label' => theme_config('home.howToJoin.button.label')
                   ],
                   'imgInText' => theme_config('home.howToJoin.imgInText.src') ? [
                       'src' => image_url(theme_config('home.howToJoin.imgInText.src')),
                       'alt' => theme_config('home.howToJoin.imgInText.alt')
                   ] : null,
                   'badges' => theme_config('home.howToJoin.badges') ?? [
                        [
                            'icon' => 'bi-check2-circle',
                            'htmlContent' => 'Accès: Gratuit',
                        ],
                        [
                            'icon' => 'bi-info-circle-fill',
                            'htmlContent' => 'Versions: 1.8.8 à 1.20.1',
                        ],
                    ],
               ]
           )
@endif
