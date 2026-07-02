@props([
    'id' => null,
    'wrapperClass' => null,
    'logo' => false,
    'leftImgSrc' => null,
    'rightImgSrc' => null,
    'title' => 'Comment rejoindre le serveur minecraft ?',
    'description' => 'Pour rejoindre un serveur Minecraft comme SkyOfSkill, il suffit d’ouvrir Minecraft Java 1.20.1, puis d’aller dans le menu Multijoueur. Depuis cette interface, ajoute un nouveau serveur en cliquant sur « Ajouter un serveur ». Choisis le nom que tu veux et dans le champ Adresse du serveur indique PLAY.SKYOFSKILL.FR. Enfin valide l’ajout du serveur minecraft pour te connecter.',
    'button' => [
        'href' => null,
        'label' => null
    ],
    'badges' => [],
    'imgInText' => null,
    'joinButton' => false
])

<div id="{{$id}}" class="card-infos__section"
     data-has-leftimg="{{ $leftImgSrc ? 'true' : 'false' }}"
     data-has-rightimg="{{ $rightImgSrc ? 'true' : 'false' }}"
>
    <div class="position-relative w-fit mx-auto card card-infos__wrapper {{ $wrapperClass }}">
        @if($logo)
            <div class="position-absolute top-0 start-50 translate-middle">
                <img src="{{ site_logo() }}" alt="logo" height="132" class="card-infos__logo">
            </div>
        @endif

        @if($leftImgSrc)
            <div class="card-infos__img position-absolute bottom-0 start-0 translate-middle-x">
                <img src="{{ $leftImgSrc }}" alt="" class="card-infos__img card-infos__img-img">
            </div>
        @endif

        @if($rightImgSrc)
            <div class="card-infos__img position-absolute bottom-0 start-100 translate-middle-x">
                <img src="{{ $rightImgSrc }}" alt="" class="card-infos__img-img">
            </div>
        @endif

        <div class="position-relative card-infos rounded-5">
            @if($logo)
                <div class="position-absolute position-absolute top-0 start-100 translate-middle-x card-infos__background">
                    <img src="{{ site_logo() }}" alt="logo" height="510">
                </div>
            @endif

            <div class="card-body card-infos__content">
                <div class="d-flex align-items-center flex-column flex-lg-row gap-3 ga">
                    @if($imgInText)
                        <img src="{{$imgInText['src']}}" alt="{{ $imgInText['alt'] }}" class="object-fit-contain rounded-3" width="170" height="170">
                    @endif
                    <div>
                        <h2 class="card-infos__title text-center">{{ $title }}</h2>
                        <p class="mb-4 text-center">{!! $description !!}</p>
                    </div>
                </div>

                @if($joinButton || $button)
                    <ul class="d-flex justify-content-center align-items-center flex-wrap gap-3 m-0 p-0 list-unstyled">
                        @if($joinButton)
                            <li>
                                @include('components.join-button', ['variant' => 'primary'])
                            </li>
                        @endif
                        @if($button['label'])
                            <li>
                                <a href="{{ $button['href'] }}" class="btn btn-primary">{{ $button['label'] }}</a>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>

        @if(count($badges) > 0)
            <ul class="position-absolute top-100 start-50 translate-middle w-100 d-flex align-items-center justify-content-center flex-wrap gap-2 gap-md-3 m-0 p-0 list-unstyled card-infos__badges">
                @foreach($badges as $badge)
                    <li>
                        @include('components.large-badge',
                            [
                                'icon' => $badge['icon'],
                                'text' => $badge['htmlContent'],
                            ]
                        )
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
