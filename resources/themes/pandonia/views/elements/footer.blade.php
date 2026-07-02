<footer id="footer" class="mt-15">
    <div id="footer-wrapper">
        <div class="footer-content container position-relative d-flex flex-column gap-3_5 pb-7 pb-md-4 pt-4">
            <div class="container px-3 px-md-4 row flex-column flex-md-row gap-4_5">
                <div class="col col-lg-3 d-flex flex-column p-0 flex-grow-1">
                    <h3 class="text-uppercase h4 mb-4 fw-bold">{{theme_config('footer.about_us.title') ?? "A propos"}}</h3>
                    <p class="fw-semibold m-0 text-white-50 text-sm">{{theme_config('footer.about_us.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim."}}</p>
                        @if(theme_config('footer.about_us.links'))
                            <ul class="about_us_list d-flex flex-column border-start border-primary border-3 ps-4 py-3 mt-3 d-flex gap-2_5 gap-md-3_5 list-unstyled">
                                @foreach(theme_config('footer.about_us.links') as $link)
                                    @if($link['text'] != null)
                                        <li><a class="d-flex align-items-center footer-link text-decoration-none text-primary fw-semibold" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">@if($link['icon'])<i class="{{$link['icon']}} d-flex align-items-center me-2"></i>@endif{{$link['text']}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                </div>
                <ul class="col-lg-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                    <h3 class="text-uppercase h4 mb-4 fw-bold">{{theme_config('footer.web.links.title') ?? "Liens utiles"}}</h3>
                    @if(theme_config('footer.web.links'))
                        @foreach(theme_config('footer.web.links') as $link)
                            @if($link['text'] != null)
                                <li class="px-3"><a class="footer-link d-flex align-items-center text-white-50 fw-semibold text-decoration-none" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">@if($link['icon'])<i class="{{$link['icon']}} d-flex align-items-center me-2"></i>@endif{{$link['text']}}</a></li>
                                <hr class="m-1" />
                            @endif
                        @endforeach
                    @endif
                </ul>
                <ul class="col-lg-4 d-flex flex-column gap-2 order-md-0 gap-md-2 list-unstyled m-0 p-0">
                    <h3 class="text-uppercase h4 mb-4 fw-bold">{{theme_config('footer.support.title') ?? "Nous supporter"}}</h3>
                    <p class="fw-semibold m-0 text-white-50 text-sm">{{theme_config('footer.support.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim."}}</p>

                    @if(theme_config('footer.support.links'))
                        @foreach(theme_config('footer.support.links') as $link)
                            @if($link['text'] != null)
                                <a href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener" class="w-fit btn btn-primary p-2 px-3 mt-3">{{$link['text']}} @if($link['icon'])<i class="{{$link['icon']}} ms-2"></i>@endif</a>
                            @endif
                        @endforeach
                    @else
                        <a href="/shop" class="w-fit btn btn-primary p-2 px-3 mt-3">La boutique <i class="bi bi-arrow-right ms-2"></i></a>
                    @endif
                </ul>
            </div>
            <hr/>
            <div class="row gx-4 copyright text-white-25">
                <div class="col-12 col-md-6">
                    <p class="m-0 fw-bold h5"><i class="bi bi-c-circle"></i> {{ setting('copyright') }}</p>
                    <p class="m-0 text-xs"><span>Thème crée par <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
                </div>
            </div>
        </div>
    </div>
</footer>
