<div class="mt-10 bg-dark text-white box-sizing">
    <div class="footer-bg mt-5"
    style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;"
    >
        <span class="footer-bg__img">
            <img src="{{theme_asset('images/LifeSky_Icon_2.png')}}" alt="Mascotte de LifeSky" height="180">
        </span>
        <a href="{{theme_config('footer.index.bandeau.url') ?? 'https://discord.gg/Gh2yBxUWvV'}}" class="w-100 py-5 d-block text-decoration-none bg-dark bg-opacity-50 text-uppercase fw-semibold text-center h5">
            <span class="d-block px-5 w-75 mx-auto">
                {{theme_config('footer.index.bandeau.text') ?? "LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING ELIT. SAPIENTE, VOL ?"}}
            </span>
        </a>
    </div>

    <div class="container mx-auto">
        <div class="row justify-content-between py-5">
            <div class="col-md-2 footer__logo d-flex justify-content-center opacity-25">
                <img src="{{site_logo()}}" alt="Logo de {{site_name()}}" height="150">
            </div>
            <div class="col-md-5 m-0 py-4 py-md-0">
                <h2 class="start fw-semibold h5 text-uppercase">{{theme_config('footer.index.about.title') ?? site_name()}}</h2>
                <p class="text-sm text-white-50">
                    {{theme_config('footer.index.about.text') ?? "LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING ELIT. SAPIENTE, VOL ?"}}
                </p>

                <button
                    class="copyButton w-50 d-flex flex-column align-items-center bg-body-secondary bg-opacity-25 cursor-pointer border-0 mb-0 rounded-pill"
                    style="width: 200px;"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual"
                >
                    <span class="fw-semibold text-uppercase text-white py-1 px-3">
                        @if($servers)
                            <span>{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}</span>
                        @else
                            Serveur hors-ligne
                        @endif
                    </span>
                </button>
            </div>
            <ul class="col-md-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-md-0">
                <h2 class="fw-semibold h5 text-uppercase">Liens utiles</h2>
                @if(theme_config('footer.index.link'))
                    @foreach(theme_config('footer.index.link') as $link)
                        @if($link['text'] != null)
                            <li><a class="footer-link d-flex align-items-center text-white-50 fw-semibold text-decoration-none" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="bg-black">
        <div class="container py-3">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="footer-copyright">
                    <p class="m-0 fw-semibold">{{ setting('copyright') }} </p>
                    <span class="text-sm opacity-50" title="Version {{$version_theme['version']}}">{{trans('theme::theme.footer.copyright')}} <a
                            href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>. | @lang('messages.copyright')</span>
                </div>
                <ul class="list-unstyled">
                    @if(theme_config('footer.index.link-important'))
                        @foreach(theme_config('footer.index.link-important') as $link)
                            @if($link['text'] != null)
                                <li class="px-3"><a class="text-decoration-none text-xs text-white-50" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
