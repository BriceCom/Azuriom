<div class="container">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6 d-md-flex flex-md-column align-items-md-start align-items-center">
            <div>
                <img class="footer-logo" height="{{theme_config('footer.imageHeightMax') ?? 70}}" src="{{theme_config('footer.image') ? image_url(theme_config('footer.image')):site_logo()}}" alt="Serveur {{site_name()}}">
            </div>
            <p class="text-md-start text-center py-3 fs-6">OriginCube est un serveur Minecraft disponible en 1.46.8 pour tous les joueurs de plus de 16 ans et 7 mois qui se concentre sur l'histoire de l'Amérique. Avec nos plugins plus vrai que nature, découvrez la vraie vie.</p>
        </div>
        <div class="col-12 col-lg-6 justify-content-between">
            <div class="row flex-col flex-md-row justify-content-center justify-content-md-end">
                <div class="col-5 col-xl-4 col-xxl-3 fs-6">
                    <p class="my-1 fw-medium">NOTRE SITE WEB</p>
                    <ul class="list-unstyled d-flex flex-column gap-1">
                        @if(theme_config('footer.urWeb') != null)
                            @foreach(theme_config('footer.urWeb') as $link)
                                @if($link['text'] != null)
                                    <li><a href="{{$link['url']}}" class="text-white" @if(isset($link['blank']) && $link['blank']) target="_blank" rel="noopener" @endif>{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-5 col-xl-4 col-xxl-3  fs-6">
                    <p class="my-1 fw-medium">NOUS SOUTENIR</p>
                    <ul class="list-unstyled d-flex flex-column gap-1">
                        @if(theme_config('footer.supportUs') != null)
                            @foreach(theme_config('footer.supportUs') as $link)
                                @if($link['text'] != null)
                                    <li><a href="{{$link['url']}}" class="text-white" @if(isset($link['blank']) && $link['blank']) target="_blank" rel="noopener" @endif>{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-12 col-lg-8 text-xl-start text-center">
            <p class="fs-6">{{ setting('copyright') ?? '© 2023 OriginCube ·  Tous droits réservés' }} · Propulsé par <a href="https://azuriom.com/" class="text-white" target="_blank" rel="noopener noreferrer">Azuriom</a> · Thème réalisé par <span title="Version {{$version_theme['version']}}"> <a href="https://discord.gg/Gh2yBxUWvV" class="text-white" target="_blank" rel="noopener noreferrer">Dixept</a> et <a href="https://www.heleriastudio.com/" class="text-white" target="_blank" rel="noopener noreferrer">Nolan Glade</a>.</span></p>
        </div>
        <div class="col-12 col-lg-4">
            <ul class="d-flex flex-row flex-wrap align-items-center justify-content-xl-end justify-content-center gap-3 list-unstyled">
                @foreach(social_links() as $link)
                    <li>
                        <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                           class="d-inline-block rounded-circle fs-5"><i class="{{ $link->icon }} text-primary"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
