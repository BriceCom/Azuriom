<div class="container">
    <div class="row flex-md-nowrap gap-4 gap-md-8">
        <div class="col-md-2 d-flex flex-column align-items-center gap-2">
            <img src="{{theme_config('footer.index.logo.url') ? image_url(theme_config('footer.index.logo.url')) : site_logo()}}" alt="Logo {{site_logo()}}" height="{{theme_config('footer.index.logo.height') ?? '121' }}">
           <ul class="list-unstyled d-flex align-items-center gap-3">
               @foreach(social_links() as $link)
                   <li>
                       <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                          data-bs-toggle="tooltip"
                          class="d-inline-block">
                           <i class="{{ $link->icon }}"></i>
                       </a>
                   </li>
               @endforeach
           </ul>
        </div>
        <div class="col-md-4">
            <h2 class="fs-3 fw-semibold font-base">À propos</h2>
            <p>{{ setting('description') }}</p>
        </div>
        <div class="col-md-4">
            <h2 class="fs-3 fw-semibold font-base">Liens</h2>
            <ul>
                @if(theme_config('footer.index.link'))
                    @foreach(theme_config('footer.index.link') as $link)
                        @if(isset($link['text']))
                            <li><a href="{{$link['url']}}" target="{{isset($link['blank']) ? '_blank' : '_self'}}}}">{{$link['text']}}</a></li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <p class="text-center text-md-start mt-5 mt-md-3">{{ setting('copyright') }} | <span title="Version {{$version_theme['version']}}">{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
</div>
