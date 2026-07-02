<footer id="footer-big" class="position-relative">
    <div class="position-absolute top-0 start-0 h-100 w-100 overflow-hidden">
        <div class="footer-gradient-circle gradient-circle"></div>
    </div>
    <div id="footer-big-wrapper">
        <div class="container come-us position-absolute top-0 start-50 translate-middle mx-auto">
            <div class="row flex-column flex-md-row gx-3 gy-4 text-center text-md-start">
                <div class="col col-md-2 order-md-2">
                    <img height="177" src="{{ theme_config('footer.come.image') ? image_url(theme_config('footer.come.image')):site_logo() }}" alt="{{site_name()}}" class="w-100 object-fit-contain">
                </div>
                <div class="col col-md-10">
                    <h2>{{theme_config('footer.come.title') ?? "Rejoins nous sur Astrala"}}</h2>
                    <p class="mb-4_5">{{theme_config('footer.come.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."}}</p>
                    <button id="copyButton" class="btn btn-primary text-uppercase btn-ip">{{theme_config('footer.btn') ?? "play.astrala.fr"}}</button>
                </div>
            </div>
        </div>
        <div class="footer-content container position-relative d-flex flex-column gap-3_5 pb-7 pb-md-4 pt-4">
            <div class="row flex-column flex-md-row gap-4_5">
                <div class="col col-md-4 d-flex flex-column gap-4_5 gap-md-4">
                    <div class="d-flex gap-3 align-items-center">
                        <img height="72" src="{{ theme_config('footer.about.image') ? image_url(theme_config('footer.about.image')):favicon() }}" alt="{{site_name()}}" class="object-fit-contain">
                        <span class="site-name h1">{{site_name()}}</span>
                    </div>
                    <p>{{theme_config('footer.about.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim."}}</p>
                    <ul class="d-flex gap-2_5 gap-md-3_5 list-unstyled">
                        @foreach(social_links() as $link)
                            <li>
                                <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                                   class="d-flex justify-content-center align-items-center btn btn-primary btn-social">
                                    <i class="{{ $link->icon }} text-white"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col row d-flex gap-4 gap-md-0 m-0">
                    <ul class="col-3 col-md-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                        <h3 class="text-uppercase fw-bold h5">{{theme_config('footer.web.links.title') ?? "Site web"}}</h3>
                        @if(theme_config('footer.web.links'))
                            @foreach(theme_config('footer.web.links') as $link)
                                @if($link['text'] != null)
                                    <li><a class="footer-link text-decoration-none opacity-50" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                    <ul class="col-3 col-md-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                        <h3 class="text-uppercase fw-bold h5">{{theme_config('footer.ressources.title') ?? "Ressources"}}</h3>
                        @if(theme_config('footer.ressources.links'))
                            @foreach(theme_config('footer.ressources.links') as $link)
                                @if($link['text'] != null)
                                    <li><a class="footer-link text-decoration-none opacity-50" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                    <ul class="col-12 col-md-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                        <h3 class="text-uppercase fw-bold h5">{{theme_config('footer.important.title') ?? "Légal"}}</h3>
                        @if(theme_config('footer.important.links'))
                            @foreach(theme_config('footer.important.links') as $link)
                                @if($link['text'] != null)
                                    <li><a class="footer-link text-decoration-none opacity-50" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr/>
            <div class="row gx-4 copyright">
                <div class="col-12 col-md-6">
                    <p class="m-0">{{ setting('copyright') }}</p>
                    <p class="m-0 dixept" data-bs-toggle="tooltip" data-bs-title="Thème intégré par Dixept.fr"><span>Édité par Nekore.</span> @lang('messages.copyright')</p>
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <p class="text-md-end">Nous ne sommes pas affiliés à Mojang AB.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
