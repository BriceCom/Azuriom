<footer class="bg-body-secondary">
    <div class="border-top border-bottom border-2 border-white border-opacity-10 py-2.5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                @php
                    $hasValidLinks = false;
                    $links = theme_config('footer.index.links.1.links') ?? [];

                    foreach ($links as $link) {
                        if (!empty($link['url']) || !empty($link['text'])) {
                            $hasValidLinks = true;
                            break;
                        }
                    }
                @endphp

                @if($hasValidLinks)
                    <nav class="navbar-nav d-flex flex-row align-items-center gap-4 mb-3 mb-md-0">
                        @foreach($links as $link)
                            @if(!empty($link['url']) || !empty($link['text']))
                                <li><a href="{{ $link['url'] ?? '#' }}" class="nav-link fw-light"><b>{{ $link['text'] ?? 'Link' }}</b></a></li>
                            @endif
                        @endforeach
                    </nav>
                @endif

                @if(!theme_config('footer.index.button.off'))
                    @if(theme_config('footer.index.button.url'))
                        <a href="{{ theme_config('footer.index.button.url') }}" class="btn btn-tertiary fw-bold text-uppercase rounded-pill px-4 py-2 ms-md-auto">
                            {{ theme_config('footer.index.button.text') ?? 'Button' }}
                        </a>
                    @else
                        <a href="#" class="btn btn-tertiary fw-bold text-uppercase rounded-pill px-4 py-2 ms-md-auto">
                            Shop
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="container pt-4 pb-3">
        <div class="row">
            <div class="d-flex align-items-start flex-wrap gap-4">
                <img src="{{site_logo()}}" alt="Logo {{site_name()}}" class="object-fit-contain" style="max-width: 200px"/>
                <div>
                    <p class="col-lg-6">
                        {{theme_config('footer.index.text') ?? "Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing an"}}
                    </p>
                    <ul class="d-flex align-items-center gap-3 list-unstyled">
                        @if(theme_config('footer.index.links.2.links'))
                            @foreach(theme_config('footer.index.links.2.links') as $link)
                                <li><a href="{{$link['url']}}" class="footer-link"><b>{{$link['text']}}</b></a></li>
                            @endforeach
                        @else
                            @for($i=1;$i<=2;$i++)
                                <li><a href="#" class="footer-link"><b>Lorem {{$i}}</b></a></li>
                            @endfor
                        @endif
                    </ul>
                    <small class="text-xs opacity-50">{{ setting('copyright') }}
                        |
                        @if(theme_config('premium.serveurliste.link'))
                            @if(!theme_config('footer.index.dixept_copyright.off'))
                                <span>{{trans('theme::theme.footer.copyright')}}
                        <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                    </span>|
                            @endif
                        @else
                            <span>{{trans('theme::theme.footer.copyright')}}
                    <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                </span>|
                        @endif
                        @lang('messages.copyright')
                    </small>
                </div>
            </div>
        </div>
    </div>
</footer>
