<div>
    @if(!theme_config('footer.toggle'))
        <div class="container d-flex flex-column gap-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between gap-2 gap-md-4">
                <a class="w-25 navbar-brand text-md-start text-center" href="{{ route('home') }}">
                    @if(!theme_config('footer.top.image.url'))
                        {{ site_name() }}
                    @else
                        <img src="{{image_url(theme_config('footer.top.image.url'))}}" class="object-fit-contain" height="{{theme_config('footer.top.image.height') ?? '40'}}" width="{{theme_config('footer.top.image.width') ?? '100'}}" alt="{{theme_config('footer.top.image.alt')}}">
                    @endif
                </a>
                <ul class="flex-grow-1 d-flex align-items-center justify-content-center gap-4">
                    @if(theme_config('footer.top.links'))
                        @foreach(theme_config('footer.top.links') as $link)
                            <li>
                                <a href="{{ $link['url'] ?? '' }}"  @if(isset($link['active']) && $link['active']) target="_blank" @endif rel="noopener noreferrer" class="text-decoration-none text-nowrap">
                                    {{$link['text'] ?? ''}}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <a href="https://www.serveurliste.com/faq"  target="_blank" class="text-decoration-none">
                                FAQ de ServeurListe pour aider les serveurs
                            </a>
                        </li>
                    @endif
                </ul>
                <ul class="w-25 d-flex align-items-center justify-content-end gap-1">
                    @foreach(social_links() as $link)
                        <li>
                            <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                               data-bs-toggle="tooltip"
                               class="d-inline-block p-2">
                                <i class="{{ $link->icon }} text-white"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div id="copyright" class="d-flex flex-column flex-md-row align-items-center justify-content-between text-muted">
                <p>{{ setting('copyright') }} | <span>{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
                <ul class="d-flex align-items-center justify-content-md-end gap-4">
                    @if(theme_config('footer.bottom.links'))
                        @foreach(theme_config('footer.bottom.links') as $link)
                            <li>
                                <a href="{{ $link['url'] ?? '' }}"  @if(isset($link['active']) && $link['active']) target="_blank" @endif rel="noopener noreferrer" class="text-decoration-none">
                                    {{$link['text'] ?? ''}}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <a href="https://www.serveurliste.com/" target="_blank">Serveur Minecraft</a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    @else
        <p class="text-center">{{ setting('copyright') }} | <span>{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
    @endif
</div>
