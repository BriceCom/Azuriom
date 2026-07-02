<div class="footer container">
    <div class="card bg-body-secondary border-0">
        <div class="card-body d-flex justify-content-between align-items-center py-5 px-8">
            <div class="d-flex flex-column align-items-center gap-3">
                <a href="/">
                    <img src="{{site_logo()}}" height="57"/>
                </a>
                @include('components.socials')
            </div>

            <div class="d-flex align-items-baseline gap-8">
                @if(theme_config('footer.index.links'))
                    @foreach(theme_config('footer.index.links') as $i => $links)
                        <div>
                            <h3 class="h6 text-uppercase fw-semibold text-end text-secondary">{{$links['title']}}</h3>
                            <ul class="list-unstyled">
                                @foreach($links['links'] as $link => $i)
                                    <li><a href="{{isset($i['url']) ? $i['url']:"#"}}"
                                           @if(isset($i['blank']) && $i['blank']) target="_blank"
                                           @endif class="text-sm text-end text-decoration-none">{{isset($i['text']) ? $i['text']: ''}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between px-3 mt-2">
        <ul class="list-unstyled m-0">
            @if(!theme_config('style.index.theme.dark.off'))
                @include('elements.theme-selector')
            @endif
        </ul>
        <p class="text-xs text-end m-0 fw-semibold">{{ setting('copyright') }}
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
        </p>
    </div>
</div>
