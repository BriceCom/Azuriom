@php
    $siteName = site_name();
    $footerMainTitle = theme_config('footer.main.title') ?? trans('theme::theme.footer.main_title_default', ['site' => $siteName]);
    $footerMainText = theme_config('footer.main.text') ?? trans('theme::theme.footer.main_text_default', ['site' => $siteName]);
    $footerNavigationTitle = theme_config('footer.navigation.title') ?? trans('theme::theme.footer.navigation_title_default');
    $footerContactTitle = theme_config('footer.contact.title') ?? trans('theme::theme.footer.contact_title_default');

    $footerNavigationLinks = theme_config('footer.navigation.links');
    if (! is_array($footerNavigationLinks)) {
        $footerNavigationLinks = [];
    }
    $footerNavigationLinks = array_values(array_filter($footerNavigationLinks, static function ($link): bool {
        return is_array($link) && ! empty(data_get($link, 'name')) && ! empty(data_get($link, 'url'));
    }));
    if ($footerNavigationLinks === []) {
        $footerNavigationLinks = [
            ['icon' => 'bi bi-house', 'name' => trans('theme::theme.footer.links.home'), 'url' => '/', 'new_tab' => false],
            ['icon' => 'bi bi-envelope', 'name' => trans('theme::theme.footer.links.vote'), 'url' => '/vote', 'new_tab' => false],
            ['icon' => 'bi bi-cart', 'name' => trans('theme::theme.footer.links.shop'), 'url' => '/shop', 'new_tab' => false],
        ];
    }

    $footerContactLinks = theme_config('footer.contact.links');
    if (! is_array($footerContactLinks)) {
        $footerContactLinks = [];
    }
    $footerContactLinks = array_values(array_filter($footerContactLinks, static function ($link): bool {
        return is_array($link) && ! empty(data_get($link, 'name')) && ! empty(data_get($link, 'url'));
    }));
    if ($footerContactLinks === []) {
        $footerContactLinks = [
            ['icon' => 'bi bi-discord', 'name' => trans('theme::theme.footer.links.discord'), 'url' => 'https://discord.com/invite/VKpSJrV', 'new_tab' => true],
        ];
    }
@endphp

<footer class="text-center text-lg-start bg-body-tertiary text-body mt-auto">
    <div class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="container mx-auto d-flex align-items-center justify-content-lg-between">
            <div class="me-5 d-none d-lg-block">
                <span>{{ trans('theme::theme.footer.follow', ['site' => $siteName]) }}</span>
            </div>

            <div>
                @foreach(social_links() as $link)
                    @php
                        $socialIconClass = trim((string) $link->icon);
                        if ($socialIconClass === '') {
                            $socialIconClass = 'bi bi-globe2';
                        }
                    @endphp
                    <a href="{{ $link->value }}" class="me-4 text-reset" target="_blank" rel="noopener noreferrer" title="{{ $link->title }}">
                        <i class="{{ $socialIconClass }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <div class="container text-center text-md-start py-4">
            <div class="row mt-3 g-4">
                <div class="col-12 col-xl-6 mb-4 d-flex flex-column flex-md-row gap-4">
                    <div class="mb-4 col-3">
                        <img src="{{ site_logo() }}" alt="Logo" style="max-height: 128px; width: auto;">
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 fs-6">{{ $footerMainTitle }}</h2>
                        <p class="mb-0">{{ $footerMainText }}</p>
                    </div>
                </div>

                <div class="col d-flex flex-wrap justify-content-xl-end gap-3 gap-md-5">
                    <div>
                        <h3 class="text-uppercase fw-bold mb-3 fs-6">{{ $footerNavigationTitle }}</h3>
                        @foreach($footerNavigationLinks as $link)
                            @php
                                $name = data_get($link, 'name');
                                $url = data_get($link, 'url');
                                $newTab = (bool) data_get($link, 'new_tab', false);
                                $iconClass = trim((string) data_get($link, 'icon'));
                                if ($iconClass !== '' && str_starts_with($iconClass, 'bi-')) {
                                    $iconClass = 'bi '.$iconClass;
                                }
                                if ($iconClass === '') {
                                    $iconClass = 'bi bi-link-45deg';
                                }
                            @endphp
                            @if(!empty($name) && !empty($url))
                                <p class="mb-2">
                                    <a href="{{ $url }}" class="text-reset d-inline-flex align-items-center gap-2" @if($newTab) target="_blank" rel="noopener noreferrer" @endif>
                                        <i class="{{ $iconClass }}"></i>
                                        <span>{{ $name }}</span>
                                    </a>
                                </p>
                            @endif
                        @endforeach
                    </div>

                    <div>
                        <h3 class="text-uppercase fw-bold mb-3 fs-6">{{ $footerContactTitle }}</h3>
                        @foreach($footerContactLinks as $link)
                            @php
                                $name = data_get($link, 'name');
                                $url = data_get($link, 'url');
                                $newTab = (bool) data_get($link, 'new_tab', false);
                                $iconClass = trim((string) data_get($link, 'icon'));
                                if ($iconClass !== '' && str_starts_with($iconClass, 'bi-')) {
                                    $iconClass = 'bi '.$iconClass;
                                }
                                if ($iconClass === '') {
                                    $iconClass = 'bi bi-link-45deg';
                                }
                            @endphp
                            @if(!empty($name) && !empty($url))
                                <p class="mb-2">
                                    <a href="{{ $url }}" class="text-reset d-inline-flex align-items-center gap-2" @if($newTab) target="_blank" rel="noopener noreferrer" @endif>
                                        <i class="{{ $iconClass }}"></i>
                                        <span>{{ $name }}</span>
                                    </a>
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center p-4 border-top">
        {{ str_replace('{year}', date('Y'), setting('copyright')) }} | @lang('messages.copyright')
    </div>
</footer>
