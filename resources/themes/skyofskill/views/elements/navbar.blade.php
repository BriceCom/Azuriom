<div class="hero pt-4 pb-7 pb-md-15">
        <div class="container mx-auto">
            <header class="navbar navbar-expand-xl py-xl-0">
                <div class="container mb-auto">
                    <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                            aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <a class="header-logo d-xl-none " href="{{ route('home') }}">
                        <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" class="object-fit-contain"
                             width="100" draggable="false">
                    </a>

                    <nav class="row gap-3 gap-xl-0 bg-dark bg-opacity-33 border border-3 border-dark border-opacity-10 rounded-4 collapse navbar-collapse py-2 px-3 mt-2 mt-xl-0" id="navbar">
                        <div class="d-none d-xl-block col-xl-2 position-relative h-100 align-self-end">
                            <a class="header-logo d-block top-100 start-50" href="{{ route('home') }}">
                                <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" class="object-fit-contain"
                                     width="172" draggable="false">
                            </a>
                        </div>

                        <!-- Left Side Of Navbar -->
                        <ul class="col flex-grow-1 navbar-nav align-items-xl-center align-items-start justify-content-center gap-4 p-0 mt-0"  id="navbarLinks">
                            @foreach($navbar as $element)
                                @if(!$element->isDropdown())
                                    <li class="nav-item" data-animate="navlink-anime">
                                        <a class="text-lg ff-main text-uppercase btn

                                                @php
                                                    $name = strtolower($element->name);

                                                    $shopKey = strtolower(theme_config('header.index.links.shop_variant.text') ?? 'boutique');
                                                    $voteKey = strtolower(theme_config('header.index.links.vote_variant.text') ?? 'voter');
                                                    $playKey = strtolower(theme_config('header.index.links.play_variant.text') ?? 'jouer');
                                                @endphp

                                                @if($shopKey && str_contains($name, $shopKey))
                                                    btn-{{ theme_config('header.index.links.shop_variant.color') ?? 'quaternary' }}

                                                @elseif($voteKey && str_contains($name, $voteKey))
                                                    btn-{{ theme_config('header.index.links.vote_variant.color') ?? 'tertiary' }}

                                                @elseif($playKey && str_contains($name, $playKey))
                                                    btn-{{ theme_config('header.index.links.play_variant.color') ?? 'primary' }}
                                                @else
                                                    border-0 nav-link
                                                @endif

                                                d-flex align-items-center gap-2.5 @if($element->isCurrent()) active bg-opacity-10 @endif"
                                               href="{{ $element->getLink() }}"
                                               @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>

                                            {{ $element->name }}
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item dropdown d-flex align-items-center gap-2.5"
                                        data-animate="navlink-anime">
                                        <a class="nav-link ff-main text-uppercase text-lg dropdown-toggle @if($element->isCurrent()) active bg-opacity-10 @endif"
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
                        <ul id="userNav" class="col-xl-2 nav-join navbar-nav flex-column flex-xl-row justify-content-end gap-2 align-items-xl-center list-unstyled mt-2 mt-xl-0">
                            @if(!theme_config('style.index.theme.dark.off'))
                                @include('elements.theme-selector')
                            @endif

                            <li class="nav-item dropdown d-flex flex-column flex-xl-row" data-animate="navlink-anime">
                                <a class="d-flex align-items-center gap-2 fw-bold text-uppercase text-uppercase dropdown-toggle text-md text-decoration-none text-decoration-none ps-3 ps-xl-0 after-none"
                                   href="#" id="navbarDropdown-auth" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    @guest
                                        <i class="bi bi-person-fill text-xxl big-icon"></i>
                                    @else
                                        <img src={{Auth::user()->getAvatar(64)}} class="rounded-2" alt="Avatar" width="38"
                                             height="38">
                                    @endcanany
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="navbarDropdown-auth">
                                    @guest
                                        <li class="nav-item">
                                            @includeIf('components.auth.login.login-trigger-modal')
                                        </li>
                                        <li class="nav-item">
                                            @if(Route::has('register'))
                                                @includeIf('components.auth.register.register-trigger-modal')
                                            @endif
                                        </li>
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

            @if(request()->is('/'))
                @include('components.bentobox')
            @endif

        </div>
</div>

@includeIf('components.auth.login.login-modal')
@includeIf('components.auth.register.register-modal')
