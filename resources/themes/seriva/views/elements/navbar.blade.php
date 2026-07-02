<header class="seriva-navbar-wrap">
    <div class="container-xl">
        <nav class="navbar navbar-expand-lg seriva-navbar" aria-label="{{ trans('messages.nav.toggle') }}">
            <a class="navbar-brand seriva-brand" href="{{ route('home') }}">
                {{ site_name() }}
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#serivaNavbar" aria-controls="serivaNavbar" aria-expanded="false"
                    aria-label="{{ trans('messages.nav.toggle') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="serivaNavbar">
                <ul class="navbar-nav mx-lg-auto align-items-lg-center gap-lg-1">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())
                            <li class="nav-item">
                                <a class="nav-link seriva-nav-link {{ $element->isCurrent() ? 'active' : '' }}"
                                   href="{{ $element->getLink() }}"
                                   @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link seriva-nav-link dropdown-toggle {{ $element->isCurrent() ? 'active' : '' }}"
                                   href="#" id="navbarDropdown{{ $element->id }}" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $element->name }}
                                </a>
                                <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="navbarDropdown{{ $element->id }}">
                                    @foreach($element->elements as $childElement)
                                        <li>
                                            <a class="dropdown-item {{ $childElement->isCurrent() ? 'active' : '' }}"
                                               href="{{ $childElement->getLink() }}"
                                               @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $childElement->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <ul class="navbar-nav ms-lg-auto align-items-lg-center gap-2 mt-3 mt-lg-0">
                    @auth
                        @if(!theme_config('header.index.notif.off'))
                            @include('elements.notifications')
                        @endif
                    @endauth

                    @if(!theme_config('style.index.theme.dark.off'))
                        @include('elements.theme-selector')
                    @endif

                    @guest
                        <li class="nav-item">
                            <a class="btn btn-link text-decoration-none seriva-login" href="{{ route('login') }}">
                                {{ trans('auth.login') }}
                            </a>
                        </li>
                        @if(Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('register') }}">
                                    {{ trans('theme::theme.hero.cta') }}
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="seriva-user dropdown-toggle text-decoration-none" href="#" id="serivaUserDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->getAvatar(64) }}" class="rounded-circle" alt="Avatar" width="36" height="36">
                                <span class="d-none d-xl-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="serivaUserDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.index') }}">
                                        <i class="bi bi-person"></i>
                                        {{ trans('messages.nav.profile') }}
                                    </a>
                                </li>

                                @foreach(plugins()->getUserNavItems() ?? [] as $navItem)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route($navItem['route']) }}">
                                            <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i>
                                            {{ $navItem['name'] }}
                                        </a>
                                    </li>
                                @endforeach

                                @if(Auth::user()->hasAdminAccess())
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2"></i>
                                            {{ trans('messages.nav.admin') }}
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i>
                                        {{ trans('auth.logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</header>
