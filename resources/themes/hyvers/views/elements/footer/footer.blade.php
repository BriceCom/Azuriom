<footer class="position-relative radial-gradient">
    <div class="container pt-11 pb-7">
        <div class="row justify-content-center">
            <div class="col-lg-6 d-flex flex-column align-items-start gap-2.5 text-center">
                <a href="#top" class="mx-auto"><img src="{{site_logo()}}" alt="Logo {{site_name()}}" class="object-fit-contain" style="max-width: 360px"/></a>
                    <p class="text-sm m-0 text-white text-center">
                        {!! theme_config('footer.index.text') ?? "Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing an" !!}
                    </p>

                    <div class="mx-auto">
                        @include("components.socials")
                    </div>

                    <nav class="navbar-nav d-flex flex-row align-items-center justify-content-center flex-wrap gap-4 mb-3 mb-md-0 mx-auto">
                        @if(theme_config('footer.index.links'))
                            @foreach(theme_config('footer.index.links') as $link)
                                <li><a href="{{$link['href'] ?? "#"}}" class="nav-link fw-light text-uppercase fw-semibold" @if(isset($link['target'])) target="_blank" @endif><b>{{$link['name'] ?? ""}}</b></a></li>
                            @endforeach
                        @else
                            @for($i=1;$i<=4;$i++)
                                <li><a href="#" class="nav-link fw-light text-uppercase fw-semibold"><b>Lorem {{$i}}</b></a></li>
                            @endfor
                        @endif
                    </nav>
            </div>
        </div>
    </div>

    <div class="bg-body-secondary text-center p-2 text-white">
        <small>{{ setting('copyright') }}
            @lang('messages.copyright')

            <span>{{trans('theme::theme.footer.copyright')}}
                <a href="https://discord.com/invite/KVmpqz7n6M" target="_blank" rel="noopener noreferrer">Bryx</a>.
            </span>
        </small>
    </div>
</footer>
