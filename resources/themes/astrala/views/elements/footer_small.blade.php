<footer id="footer-small">
    <div class="container-fluid d-flex justify-content-between align-items-center align-items-md-end flex-column flex-md-row gap-3">
        <div class="w-50 order-2 order-md-0 text-center text-md-start copyright">
            <p class="m-0">{{ setting('copyright') }}</p>
            <p class="m-0" data-bs-toggle="tooltip" data-bs-title="Thème intégré par Dixept.fr"><span>Édité par Nekore.</span> @lang('messages.copyright')</p>
        </div>
        <div class="w-50 text-center">
            <h2 class="text-uppercase fw-bold h5 mb-3">Rejoins-nous :</h2>
            <ul class="d-flex justify-content-center gap-2_5 gap-md-3_5 list-unstyled">
                @foreach(social_links() as $link)
                    <li>
                        <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                           class="d-inline-flex justify-content-center align-items-center  btn btn-primary btn-social">
                            <i class="{{ $link->icon }} text-white"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <ul class="w-50 d-flex justify-content-center justify-content-md-end gap-3 order-3 order-md-0 gap-md-4 list-unstyled">
            @if(theme_config('footer.important.links'))
                @foreach(theme_config('footer.important.links') as $link)
                    @if($link['text'] != null)
                        <li><a class="text-decoration-none" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>

</footer>
