<footer class="bg-body-secondary">
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-6 d-flex flex-md-row gap-3">
                <img src="{{site_logo()}}" alt="Logo {{site_name()}}" class="object-fit-contain" width="183"/>

                <div class="d-flex flex-column gap-2.5">
                    <h2 class="h3">Loem Ipsum is simpl</h2>
                    <p class="mb-0">
                        {{theme_config('footer.index.text') ?? "Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing an"}}
                    </p>
                    @include('components.socials')
                    <div>
                        @include('components.join-button')
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <h3>Lorem</h3>
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
            </div>

            <div class="col-md-3">
                <h3>Lorem</h3>
                <p class="text-muted">Lrem Ipsum is simply dummy text of the printing and typesetting </p>
                @if(theme_config('footer.index.button.url'))
                    <a href="{{theme_config('footer.index.button.url')}}" class="btn btn-warning fw-bold text-uppercase rounded-pill px-4 py-2">
                        {{theme_config('footer.index.button.text')}}
                    </a>
                @else
                    <a href="#" class="btn btn-warning fw-bold text-uppercase rounded-pill px-4 py-2">
                        Shop
                    </a>
                @endif
            </div>

            @include('components.copyright')
        </div>
    </div>
</footer>
