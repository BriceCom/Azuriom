<div class="hero d-flex align-items-center justify-content-center py-5 pt-md-10">
    <div class="container container-header d-flex flex-column flex-md-row align-items-center justify-content-center gap-3 gap-lg-5">
        @if(!theme_config('header.hero.server.hide'))
            <button
                    class="btn d-flex align-items-center gap-3"
                    data-copyboard="true"
                    data-copyboard-text="{{theme_config('settings.server.ip')?? 'play.dixept.fr'}}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-original-title="{{theme_config('header.hero.server_address_copied') ?? trans('theme::theme.server_address_copied')}}"
                    data-bs-trigger="manual"
            >
                <div class="text-uppercase fw-semibold text-end" data-editable="true">
                    <p class="text-primary mb-0">
                        <i class="pulse me-1"></i>
                        {{theme_config('header.hero.joinText') ?? $totalPlayers . " " . trans('theme::theme.online_players')}}
                    </p>
                    @if(!theme_config('settings.server.launcher'))
                        <span class="text-sm">{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}</span>
                    @endif
                </div>

                <i class="bi bi-people-fill text-2xl"></i>
            </button>
        @endif

        @php($headerImage = theme_config('header.index.image'))
        <div class="hero-brand d-flex flex-column align-items-center text-center gap-2">
            <a href="{{ route('home') }}" class="hero-brand-logo">
                <img src="{{ $headerImage ? image_url($headerImage) : site_logo() }}" alt="Logo {{ site_name() }}" class="w-100 object-fit-contain"
                     height="{{theme_config('header.index.hero.img.height') ?? 100}}" draggable="false">
            </a>
        </div>

        @if(!theme_config('header.hero.discord.hide'))
            <a class="btn d-flex align-items-center gap-3 text-start" href="{{theme_config('settings.discord.link') ?? "https://discord.gg/ZdSPkxK5xT"}}" target="_blank">
                <i class="bi bi-discord text-2xl"></i>

                <div class="text-uppercase fw-semibold" data-editable="true">
                    <p class="text-primary mb-0">
                        @if(theme_config('header.hero.discord.title'))
                            {{ theme_config('header.hero.discord.title') }}
                        @else
                            <span data-count="discord">0</span>

                            {{ trans('theme::theme.online') }}
                        @endif
                    </p>

                    <span class="text-sm">{{theme_config('header.hero.discord.text') ?? 'Discord'}}</span>
                </div>
            </a>
        @endif
    </div>

    <div class="z-10 position-absolute top-0 end-0 start-0">
        @include('elements.header.announce-bar')

        <header class="navbar navbar-expand-xl bg- bg-opacity-25 py-4">

            <div class="container container-header">
                <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                        aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <nav class="collapse navbar-collapse py-4 py-md-0" id="navbar">
                    <!-- Left Side Of Navbar -->
                    <ul class="flex-grow-1 navbar-nav align-items-center justify-content-center gap-2"  id="navbarLinks">
                        @foreach($navbar as $element)
                            @if(!$element->isDropdown())
                                <li class="nav-item" data-animate="navlink-anime">
                                    <a class="text-lg ff-main btn @if($element->value === "shop.home" || $element->value === "tebex.index") btn-outline-{{ theme_config('header.index.links.shop_variant') ?? 'tertiary' }} @else border-0 nav-link @endif d-flex align-items-center gap-2.5 @if($element->isCurrent()) active bg-opacity-10 @endif"
                                       href="{{ $element->getLink() }}" @if($element->new_tab)
                                           target="_blank"
                                       rel="noopener noreferrer" @endif
                                       data-remove-active-background="{{ theme_config('header.index.links.remove_active_background') }}">
                                        {{ $element->name }}
                                    </a>
                                </li>
                            @else
                                <li class="nav-item dropdown d-flex align-items-center gap-2.5" data-animate="navlink-anime">
                                    <a class="text-lg ff-main btn dropdown-toggle @if($element->isCurrent()) active bg-opacity-10 @endif"
                                       href="#" id="navbarDropdown{{ $element->id }}" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $element->name }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                        @foreach($element->elements as $childElement)
                                            <a class="dropdown-item @if($childElement->isCurrent()) active @endif"
                                               href="{{ $childElement->getLink() }}"
                                               @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $childElement->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul id="userNav" class="nav-join navbar-nav flex-column flex-xl-row justify-content-center list-unstyled mt-3 mt-md-0 gap-4 gap-xl-2 align-items-center">
                        @auth
                            @if(!theme_config('header.index.notif.off'))
                                @include('elements.notifications')
                            @endif
                        @endauth

                        @if(!theme_config('style.index.theme.dark.off'))
                            @include('elements.theme-selector')
                        @endif
                        <li class="nav-item dropdown d-flex flex-column flex-xl-row" data-animate="navlink-anime">

                            <a class="d-flex align-items-center gap-2 fw-bold dropdown-toggle text-md text-decoration-none ps-3 ps-xl-0"
                               href="#" id="navbarDropdown-auth" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                @guest
                                    <i class="bi bi-person-fill text-2xl"></i>
                                @else
                                    <img src={{Auth::user()->getAvatar(64)}} class="rounded-2" alt="Avatar" width="38"
                                         height="38">
                                    <div class="d-flex flex-column">
                                        <span class="text-white">{{Auth::user()->name}}</span>
                                        <span class="badge fw-normal text-xs"
                                              style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->role->name}}</span>
                                    </div>
                                @endcanany
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown-auth">
                                @guest
                                    <li class="nav-item">
                                        <a class="dropdown-item d-flex align-items-center gap-2.5"
                                           href="{{ route('login') }}">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                            {{ trans('auth.login') }}
                                        </a>
                                    </li>

                                    @if(Route::has('register'))
                                        <li class="nav-item">
                                            <a class="dropdown-item d-flex align-items-center gap-2.5"
                                               href="{{ route('register') }}">
                                                <i class="bi bi-person-plus"></i>
                                                {{ trans('auth.register') }}
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2.5"
                                           href="{{ route('profile.index') }}">
                                            <i class="bi bi-person"></i> {{ trans('messages.nav.profile') }}
                                        </a>
                                    </li>

                                    @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2.5"
                                               href="{{ route($navItem['route']) }}">
                                                <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i> {{ $navItem['name'] }}
                                            </a>
                                        </li>
                                    @endforeach

                                    @if(Auth::user()->hasAdminAccess())
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2.5"
                                               href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2.5 text-danger"
                                           href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>

                                @endguest
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </header>
    </div>
</div>

@push('footer-scripts')
    @if(!theme_config('header.index.links.center'))
        <script>
            const userNav = document.querySelector('#userNav');
            const navbarLinks = document.querySelector('#navbarLinks');

            resize()

            window.addEventListener('resize', () => {
                resize()
            });

            function resize(){
                if (window.innerWidth >= 1279) {
                    navbarLinks.style.paddingLeft = userNav.getBoundingClientRect().width + 'px';
                } else {
                    navbarLinks.style.paddingLeft = '0';
                }
            }
        </script>
    @endif
@endpush
