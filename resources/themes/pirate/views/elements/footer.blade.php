<div class="bg-body py-5">
    <div class="container">
        <div class="row gy-3">
            <div class="col-md-4 d-flex align-items-center">
                <div class="text-center">
                    <h4 class="text-uppercase font-weight-bold">
                        {{ theme_config('footer_title_1') }}
                    </h4>
                    <p>{{ theme_config('footer_description_1') }}</p>
                </div>
            </div>
            <div class="col-md-4 d-md-block d-none">
                <img src="https://pixelrealm.fr/storage/img/texte-logo-ombre.png" class="footer-logo d-block mx-auto" width="350" alt="{{ site_name() }}">
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <h4 class="text-uppercase font-weight-bold">
                        {{ theme_config('footer_title_2') }}
                    </h4>
                    <p>{{ theme_config('footer_description_2') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="copyright py-3">
    <div class="container">
        <div class="row gy-3 mt-1">
            <div class="col-md-3 d-md-flex justify-content-between text-uppercase">
                @foreach(theme_config('footer_links') ?? [] as $link)
                    <a class="me-2 d-inline-block" href="{{ $link['value'] }}">{{ $link['name'] }}</a>
                @endforeach
            </div>
            <div class="col-md-6 text-center">
                <p class="mb-0">{{ setting('copyright') }}</p>
                <small>@lang('messages.copyright')</small>
            </div>
            <div class="col-md-3 d-flex justify-content-center justify-content-md-end">
                <div class="list-inline">
                    @foreach(social_links() as $link)
                        <a href="{{ $link->value }}" class="list-inline-item" target="_blank" rel="noreferrer noopener" data-bs-toggle="tooltip" title="{{ $link->title }}">
                            <i class="{{ $link->icon }} fs-2"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
