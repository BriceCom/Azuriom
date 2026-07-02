<footer id="footer" class="mt-15 border-top border-opacity-10 border-secondary pt-4 bg-dark bg-opacity-25">
    <div id="footer-wrapper">
        <div class="footer-content container position-relative d-flex flex-column gap-3_5 pb-7 pb-md-4 pt-4">
            <div class="container px-3 px-md-4 row flex-column flex-md-row gap-4_5">
                <div class="col col-lg-3 d-flex flex-column p-0 flex-grow-1">
                    <h3 class="text-uppercase h5 mb-4 fw-bold">{{theme_config('footer.about_us.title') ?? site_name()}}</h3>
                    <p class="m-0 text-white-50">{{theme_config('footer.about_us.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim."}}</p>
                        @if(theme_config('footer.about_us.links'))
                            <ul class="about_us_list d-flex flex-column border-start border-primary border-3 ps-4 py-3 mt-3 d-flex gap-2_5 gap-md-3_5 list-unstyled">
                                @foreach(theme_config('footer.about_us.links') as $link)
                                    @if($link['text'] != null)
                                        <li><a class="d-flex align-items-center footer-link text-decoration-none text-primary" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">@if($link['icon'])<i class="{{$link['icon']}} d-flex align-items-center me-2"></i>@endif{{$link['text']}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    <ul class="list-unstyled d-flex gap-3 m-0 mt-2 p-0">
                        @foreach(social_links() as $link)
                            <li><a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                                   data-bs-toggle="tooltip"
                                   class="d-inline-block">
                                    <i class="{{ $link->icon }} text-white"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul class="col-lg-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                    <h3 class="text-uppercase h5 mb-4 fw-bold">{{theme_config('footer.web.title') ?? "Liens"}}</h3>
                    @if(theme_config('footer.web.links'))
                        @foreach(theme_config('footer.web.links') as $link)
                            @if($link['text'] != null)
                                <li class="px-3"><a class="footer-link d-flex align-items-center text-white-50 text-decoration-none" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">@if($link['icon'])<i class="{{$link['icon']}} d-flex align-items-center me-2"></i>@endif{{$link['text']}}</a></li>
                                <hr class="m-1" />
                            @endif
                        @endforeach
                    @endif
                </ul>
                <ul class="col-lg-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                    <h3 class="text-uppercase h5 mb-4 fw-bold">{{theme_config('footer.support.title') ?? "Boutique"}}</h3>
                    <p class="m-0 text-white-50">{{theme_config('footer.support.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim."}}</p>

                    @if(theme_config('footer.support.links'))
                        @foreach(theme_config('footer.support.links') as $link)
                            @if($link['text'] != null)
                                <a href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener" class="w-fit btn btn-primary p-2 px-3 mt-3">{{$link['text']}} @if($link['icon'])<i class="{{$link['icon']}} ms-2"></i>@endif</a>
                            @endif
                        @endforeach
                    @else
                        <a href="/shop" class="btn btn-primary p-2 mt-3 text-uppercase text-sm"><i class="bi bi-basket2-fill"></i> Boutique</a>
                    @endif
                </ul>
            </div>
            <hr/>
            <div class="row gx-4 copyright text-white-25">
                <img src="{{site_logo()}}" class="object-fit-contain" height="130" alt="Logo de {{site_logo()}}">
                <p class="m-0 text-sm text-center"><i class="bi bi-c-circle"></i> {{ setting('copyright') }} | <span>Thème crée par <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
            </div>
        </div>
    </div>
</footer>
