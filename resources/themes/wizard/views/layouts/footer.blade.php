<footer class="footer position-relative">
    <div class="footer-top bg-purple-900 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 border-footer text-center pe-md-5">
                    <img class="logo" src="{{site_logo()}}" alt="{{site_name()}}">
                    <p class="text-purple-200 fw-bold mt-2">{!! setting('copyright') !!}</p>
                </div>
                <div class="col-md-9">
                    <div
                        class="d-flex flex-column flex-md-row flex-wrap justify-content-center justify-content-lg-start">
                        <div class="px-5 py-3 py-md-0">
                            <h2 class="text-yellow-550 text-uppercase fw-bold fs-6 font-family-sans-serif text-start">Le site</h2>
                            <ul class="list-unstyled">

                                @foreach(theme_config('footer.site.index') ?? [] as $link)
                                    <li>
                                        <a href="{{$link['url']}}" class="footer-link">
                                            <img class="float-left icon-arrow"
                                                 src="{{theme_asset('/images/petits/fleche-droite.svg')}}" alt="décoration">
                                            <span>{{$link['name']}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="px-5 py-3 py-md-0">
                            <h2 class="text-yellow-550 text-uppercase fw-bold fs-6 font-family-sans-serif text-start">
                                Statistiques</h2>
                            <ul class="list-unstyled">
                                <li>
                                    <span class="footer-link">
                                        <img class="float-left icon-status"
                                             src="{{theme_asset('/images/petits/users.svg')}}" alt="inscrits">
                                        <span>inscrits</span>
                                        <span
                                            class="text-yellow-600 fw-bold">{{\Azuriom\Models\User::all()->count()}}</span>
                                    </span>
                                </li>
                                <li>
                                    <span class="footer-link">
                                        <img class="float-left icon-status"
                                             src="{{theme_asset('/images/petits/globe.svg')}}" alt="connectés">
                                            <span>connectés</span>
                                        <span class="text-yellow-600 fw-bold">
                                            @if($server)
                                                @if($server->isOnline())
                                                    {{$server->getOnlinePlayers()}}
                                                @else
                                                    {{ trans('messages.server.offline') }}
                                                @endif
                                            @endif
                                        </span>
                                    </span>
                                </li>
                                <li>
                                    <span class="footer-link">
                                        <img class="float-left icon-status"
                                             src="{{theme_asset('/images/petits/vues-sur-les-joueur.svg')}}"
                                             alt="connectés">
                                        <span>connectés max</span>
                                        <span class="text-yellow-600 fw-bold">
                                            {{theme_config('footer.stats.max-player')}}
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="px-5 py-3 py-md-0">
                            <h2 class="text-yellow-550 text-uppercase fw-bold fs-6 font-family-sans-serif text-start">
                                Réseaux sociaux</h2>
                            <ul class="list-unstyled">

                                @foreach(social_links() as $link)
                                    <li>
                                        <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank"
                                           rel="noopener noreferrer"
                                           data-bs-toggle="tooltip"
                                           class="footer-link text-decoration-none">
                                            <img class="float-left icon-arrow"
                                                 src="{{theme_asset('/images/petits/fleche-droite.svg')}}"
                                                 alt="décoration">
                                            <span>{{ $link->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-purple-1000 py-2">
        <div class="container">
            <div class="row px-5 px-md-0">
                <div class="col-md-4 align-self-center">
                    <div class="d-flex gap-3">
                        @foreach(theme_config('footer.policy.index') ?? [] as $link)
                            <a href="{{$link['url']}}"
                               class="underline-effect text-white text-decoration-none">{{$link['name']}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="copyright float-md-end py-2">
                        <p class="lh-1 mb-0">
                            <span class="fs-7 fw-light">
                                @lang('messages.copyright')
                                Thème réalisé par
                                <a href="https://discord.gg/wmYrG2c" target="_blank"
                                   rel="noopener noreferrer">Linedev</a>
                                </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
