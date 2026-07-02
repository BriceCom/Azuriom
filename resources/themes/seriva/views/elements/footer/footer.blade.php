<footer class="seriva-footer">
    <div class="container-xl">
        <div class="seriva-footer-surface">
            <div class="row g-4 align-items-start">
                <div class="col-lg-6">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-start gap-3">
                        @php($footerImage = theme_config('footer.index.image'))
                        <img src="{{ $footerImage ? image_url($footerImage) : site_logo() }}" alt="Logo {{ site_name() }}" class="seriva-footer-logo">

                        <div>
                            <h2 class="seriva-brand mb-2">{{ theme_config('footer.index.title') ?? site_name() }}</h2>
                            <p class="mb-0 text-secondary">
                                {{ theme_config('footer.index.text') ?? trans('theme::theme.footer.tagline') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">{{ trans('auth.login') }}</a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">{{ trans('auth.register') }}</a>
                            @endif
                        @else
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-primary">{{ trans('messages.nav.profile') }}</a>
                            <a href="{{ route('logout') }}" class="btn btn-primary"
                               onclick="event.preventDefault(); document.getElementById('footer-logout-form').submit();">
                                {{ trans('auth.logout') }}
                            </a>
                            <form id="footer-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </div>

                    @if(social_links()->isNotEmpty())
                        <div class="d-flex justify-content-lg-end mt-3">
                            @include('components.socials')
                        </div>
                    @endif

                    @if(theme_config('footer.index.button.text') && !theme_config('footer.index.button.off'))
                        <div class="d-flex justify-content-lg-end mt-3">
                            <a href="{{ theme_config('footer.index.button.url') ?? '#' }}"
                               class="btn btn-outline-primary">
                                {{ theme_config('footer.index.button.text') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if(theme_config('footer.index.links'))
                <div class="row g-3 mt-3">
                    @foreach(theme_config('footer.index.links') as $group)
                        @if(!empty($group['title']) || !empty($group['links']))
                            <div class="col-sm-6 col-lg-3">
                                @if(!empty($group['title']))
                                    <h3 class="seriva-footer-group-title">{{ $group['title'] }}</h3>
                                @endif

                                @if(!empty($group['links']))
                                    <ul class="list-unstyled d-grid gap-2 mb-0">
                                        @foreach($group['links'] as $link)
                                            @if(!empty($link['name']))
                                                <li>
                                                    <a href="{{ $link['href'] ?? '#' }}"
                                                       class="seriva-footer-link"
                                                       @if(!empty($link['target'])) target="_blank" rel="noopener noreferrer" @endif>
                                                        {{ $link['name'] }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <div class="seriva-footer-meta d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mt-4">
                <small>
                    {{ setting('copyright') }}
                    @if(!theme_config('footer.index.dixept_copyright.off'))
                        |
                        {{ trans('theme::theme.footer.copyright') }}
                        <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                    @endif
                </small>
                <small>@lang('messages.copyright')</small>
            </div>
        </div>
    </div>
</footer>
