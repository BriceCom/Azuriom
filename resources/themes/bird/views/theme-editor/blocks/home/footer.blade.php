@php
    $showLogo = !empty($params['show_logo']);
    $showSocialLinks = !empty($params['show_social_links']);
    $description = trim((string) ($params['description'] ?? ''));
    $advancedModeEnabled = (bool) theme_config('advanced.advanced_mode', false);
    $showDixeptCopyright = array_key_exists('show_dixept_copyright', $params)
        ? !empty($params['show_dixept_copyright'])
        : true;
    $allowDixeptDisplay = $advancedModeEnabled ? $showDixeptCopyright : true;
@endphp

<footer data-te-block="footer" class="te-footer-block mt-auto py-5">
    <div class="container container-footer">
        <div class="row gy-4 pb-4 border-bottom border-secondary-subtle">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="te-footer-brand-dot"></span>
                    <img
                        src="{{ site_logo() }}"
                        alt="{{ site_name() }}"
                        style="max-height: 44px;"
                        data-te-footer-logo
                        @if(!$showLogo) hidden @endif
                    >
                    <span class="fw-bold text-uppercase small">{{ site_name() }}</span>
                </div>

                @if($description !== '')
                    <p class="mb-3 text-body-secondary" data-te-param="description">{{ $description }}</p>
                @else
                    <p class="mb-3 text-body-secondary" data-te-param="description" hidden></p>
                @endif

                <div class="d-flex flex-wrap gap-2" data-te-footer-social @if(!$showSocialLinks) hidden @endif>
                    @foreach(social_links() as $link)
                        <a
                            href="{{ $link->value }}"
                            title="{{ $link->title }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            data-bs-toggle="tooltip"
                            class="te-footer-social-link d-inline-flex align-items-center justify-content-center rounded-circle"
                            style="--te-social-color: {{ $link->color }}; background: {{ $link->color }};"
                        >
                            <i class="{{ $link->icon }} text-white"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="pt-3">
            <p class="mb-0 text-body-secondary" data-te-node="footer-default-copyright">
                <small>{{ setting('copyright') }}
                    |
                    @if($allowDixeptDisplay)
                        <span data-te-node="footer-dixept-copyright">
                            {{ trans('theme::theme.footer.copyright') }}
                            <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                        </span>|
                    @else
                        <span data-te-node="footer-dixept-copyright" hidden>
                            {{ trans('theme::theme.footer.copyright') }}
                            <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                        </span>
                    @endif
                    @lang('messages.copyright')
                </small>
            </p>
        </div>
    </div>
</footer>
