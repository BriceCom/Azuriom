<section class="z-0 position-relative d-flex align-items-center justify-content-center py-5 header-bg">
    <div class="-z-1 position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(transparent 0%, var(--di-tertiary-bg) 100%)"></div>
    <div class="position-absolute top-0 end-0 pt-4 pe-4 pe-md-8">
        <div class="d-flex align-items-center gap-4">
            <ul class="list-unstyled d-flex align-items-center gap-2.5 mb-0">
                @guest
                    <ul class="bg-dark rounded-2 px-4 list-unstyled d-flex align-items-center gap-3 mb-0 bg-body p-2.5 rounded ms-2">
                        @if(!theme_config('style.index.theme.dark.off'))
                            @include('elements.theme-selector')
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                {{ trans('auth.login') }}
                            </a>
                        </li>

                        @if(Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    {{ trans('auth.register') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                @else
                    @if(!theme_config('style.index.theme.dark.off'))
                        @include('elements.theme-selector')
                    @endif
                    @include('elements.notifications')
                @endguest
            </ul>

            @auth
                <div class="nav-item dropdown">
                    <a id="userDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src={{Auth::user()->getAvatar(64)}} class="rounded-2" alt="Avatar" width="32" height="32">
                        <div class="d-flex flex-column">
                            <span class="text-white">{{Auth::user()->name}}</span>
                            <span class="badge fw-normal" style="background-color: {{Auth::user()->role->color}}">{{Auth::user()->role->name}}</span>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="bi bi-person"></i> {{ trans('messages.nav.profile') }}
                        </a>

                        @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                            <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                                <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i> {{ $navItem['name'] }}
                            </a>
                        @endforeach

                        @if(Auth::user()->hasAdminAccess())
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                            </a>
                        @endif

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <div class="container text-center">
        <a href="{{ route('home') }}">
            <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" class="mb-4 w-100 object-fit-contain" height="{{theme_config('header.index.hero.img.height') ?? 235}}" draggable="false" >
        </a>

        <div class="w-fit d-flex flex-column align-items-end gap-1 mx-auto">
            @include('components.join-button')
            <small class="text-white mb-0" data-editable="true">
                <i class="hero-connected me-1"></i>
                    @if($servers->where('home_display')->count() > 0)
                        {{theme_config('header.hero.joinText') ?? 'Join {server_online} players !'}}
                    @endif
            </small>
        </div>
    </div>
</section>
<header class="z-10 position-sticky top-0 navbar navbar-expand-md bg-body-secondary py-3 border-bottom border-2 border-white border-opacity-10">
    <div class="container">
        <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-md-none">
            @include('components.socials')
        </div>


        <div class="collapse navbar-collapse flex-wrap" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav align-items-center gap-4 me-auto">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())

                        <li class="nav-item">
                            <a class="fw-semibold text-lg @if($element->value === "shop.home") btn btn-primary @else nav-link @endif @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown d-flex ">
                            <a class="nav-link fw-semibold text-lg dropdown-toggle @if($element->isCurrent()) active @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $element->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                @foreach($element->elements as $childElement)
                                    <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                        {{ $childElement->name }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="d-none d-md-flex navbar-nav text-center text-md-end ml-auto mt-3 mt-md-0">
                @include('components.socials')
            </ul>
        </div>
    </div>
</header>
