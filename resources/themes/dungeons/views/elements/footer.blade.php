<footer class="bg-black mt-auto pt-5">
    <div>
        <div class="container">
            <div class="footer-links row justify-content-center justify-content-md-between gap-xl-3 gy-4 py-md-5 mt-md-3">
                <div class="col-12 col-md-5 p-0 text-center text-md-start">
                    <a href="/" rel="noopener"><img id="dungeonsGames" src="{{theme_asset('/image/dungeons_games.svg')}}" draggable="false" alt="Dungeons Games" height="110"/></a>
                </div>
                <div class="row col mt-5 mt-md-0">
                    <div class="col-12 col-sm-4 col-md-4 p-0 text-center text-sm-start">
                        <h2 class="text-uppercase h5">DUNGEONS</h2>
                        <ul class="list-unstyled">
                            @if(theme_config('footer.dungeons'))
                                @foreach(theme_config('footer.dungeons') as $link)
                                    @if($link['text'] != null)
                                        <li><a href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 p-0 text-center text-sm-start">
                        <h2 class="text-uppercase h5">Lien utiles</h2>
                        <ul class="list-unstyled">
                            @if(theme_config('footer.utility'))
                                @foreach(theme_config('footer.utility') as $link)
                                    @if($link['text'] != null)
                                        <li><a href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 p-0 text-center text-sm-start">
                        <h2 class="text-uppercase h5">Communauté</h2>
                        <ul class="list-unstyled">
                            @foreach(social_links() as $link)
                                <li><a href="{{ $link->value }}" target="_blank" rel="noopener">{{ $link->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div>
                    <ul class="list-unstyled d-flex gap-md-4 gap-3 flex-wrap justify-content-md-start justify-content-center">
                       @if(theme_config('footer.important'))
                            @foreach(theme_config('footer.important') as $link)
                                @if($link['text'] != null)
                                    <li><a href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                <hr/>
                <div class="d-flex flex-column flex-md-row justify-content-between text-center text-md-start">
                    <p>{{ setting('copyright') }} </p>
                    <p>
                        Propulsé par <a href="https://azuriom.com/" target="_blank" rel="noopener"><img src="{{theme_asset('/image/azuriom.webp')}}" alt="Azuriom" height="16"/> Azuriom</a>.
                        <span title="Version {{$version_theme['version']}}">Thème par <a href="https://behance.net/chrisgraph" target="_blank" rel="noopener">Chris Graph</a></span>.
                        Intégration par <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener">Dixept</a>.
                    </p>
                </div>

            </div>
        </div>
    </div>
</footer>
