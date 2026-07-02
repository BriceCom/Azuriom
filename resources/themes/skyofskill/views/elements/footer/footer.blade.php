<div class="container mt-auto">
    <footer class="bg-body-secondary d-flex flex-column gap-4.5 px-4 pt-4 pb-1 px-md-7 pt-md-7 pb-md-2 rounded-top-5">
        <div class="row gx-5 justify-content-between">
            <div class="col-lg-9">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-4.5 mb-4 mb-lg-0">
                    <img src="{{site_logo()}}" alt="Logo {{site_name()}}" class="object-fit-contain" style="max-width: 200px"  width="190"/>

                    <div class="flex-grow-1">
                        <h2 class="h3">{{theme_config('footer.index.title') ?? "Premier serveur Skyblock et opprison de france SkyOfSkill"}}</h2>
                        <p class="mb-0 col-lg-9">{{theme_config('footer.index.text') ?? "SkyOfSkill est le premier serveur minecraft français à fusionner en un seul mode de jeu le SkyBlock et l’OpPrison. PLAY.SKYOFSKILL.FR - 1.8.8 à la 1.20.1"}}</p>

                        <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                            @include('components.join-button', ['variant' => 'primary'])
                            <a href="{{theme_config('footer.index.button.url') ?? "/shop"}}"
                               class="w-fit btn btn-tertiary"
                               rel="noopener noreferrer">@if(theme_config('footer.index.button.icon'))
                                    <i class="{{theme_config('footer.index.button.icon')}}"></i>
                                @endif {{theme_config('footer.index.button.text') ?? "Boutique"}}</a>
                            @include('components.socials')
                        </div>
                    </div>
                </div>
            </div>

            @if(theme_config('footer.index.links'))
                @foreach(theme_config('footer.index.links') as $link)
                    <div class="col-lg-3">
                        <h3 class="mb-2 text-uppercase">{{$link['title'] ?? ""}}</h3>

                        <ul class="w-100 list-unstyled col-lg-3">
                            @if(isset($link['links']))
                                @foreach($link['links'] as $sublink)
                                    @if($sublink['name'])
                                        <li><a href="{{$sublink['href'] ?? "#"}}"
                                               class="nav-link fw-light text-lg anim_text-up py-1"
                                               @if(isset($sublink['target'])) target="_blank" @endif><b>{{$sublink['name'] ?? ""}}</b></a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endforeach
            @endif

        </div>

        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 opacity-75">
            <div>
                @if(theme_config('footer.index.legals'))
                    <ul class="list-unstyled d-flex align-items-center flex-row gap-1 mb-0">
                        @foreach(theme_config('footer.index.legals.links') as $index => $link)
                                @if($link['name'])
                                    <li><a href="{{$link['href'] ?? "#"}}"
                                           class="nav-link text-xs text-decoration-underline"
                                           @if(isset($link['target'])) target="_blank" @endif>

                                            <small>{{$link['name'] ?? ""}}</small>

                                        </a>
                                    </li>
                                    @if($index != count(theme_config('footer.index.legals.links')) - 1)
                                        <li><small>-</small></li>
                                    @endif
                                @endif
                        @endforeach
                    </ul>
                @endif

                <small>{{ setting('copyright') }}</small>
            </div>

           <div class="d-flex align-items-center gap-2 opacity-25">
                <span  data-bs-toggle="tooltip" data-bs-placement="top" title="Propulsé par Azuriom">
                    <img src="{{ theme_asset('/img/azuriom.webp') }}" alt="Logo Azuriom" height="25">
                </span>
               <span  data-bs-toggle="tooltip" data-bs-placement="top" title="Réalisé par Bryx Agency">
                    <img src="{{ theme_asset('/img/bryx.webp') }}" alt="Logo Bryx Agency" height="25">
                </span>
           </div>
        </div>
    </footer>
</div>
