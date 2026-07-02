<footer class="footer" style="--footer-bg: url('{{ image_url(setting('background')) }}'); font-size-adjust: {{theme_config('footer.index.fontSize') != 0 ?  theme_config('footer.index.fontSize'):"unset"}};">
    <div class="container">
        <div class="row mb90">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <a href="/">
                    <img src="{{site_logo()}}" alt="Logo du serveur {{site_name()}}" height="90">
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 d-flex flex-column align-items-end">
                <ul class="footer-menu">
                    @if(theme_config('footer.index.links'))
                        @foreach(theme_config('footer.index.links') as $link)
                            @if($link['text'])
                                <li class="{{$link['url']}}">
                                    <a href="{{$link['url']}}">
                                        {{$link['text']}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <div class="mt60">
                    {!! theme_config('footer.index.text') !!}
                </div>
                <div class="social-content mt30">
                    @foreach(social_links() as $link)
                        <div class="social-list">
                            <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                               data-bs-toggle="tooltip">
                                <i class="{{ $link->icon }} text-white"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="copyright ptb30 col-lg-12">
                <p>{{ setting('copyright') }} | <span>Thème adapté par <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
            </div>
        </div>
    </div>
</footer>
