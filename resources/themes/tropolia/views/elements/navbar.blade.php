<div class="hero position-relative d-flex align-items-center justify-content-center py-5 pt-md-10">
    <header class="z-10 position-absolute top-0 end-0 start-0 navbar navbar-expand-xl bg-body bg-opacity-75 py-3">
        <div class="container">
            <a href="{{ route('home') }}" class="me-md-4.5">
                <img src="{{ favicon() }}" alt="Logo {{ site_name() }}" height="{{theme_config('header.index.hero.img.height') ?? 64}}" class="header-logo w-fit object-fit-contain"
                     draggable="false">
            </a>

            <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse py-4 py-md-0" id="navbar">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav align-items-start gap-4 me-auto">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())

                            <li class="nav-item" data-animate="navlink-anime">
                                <a class="text-lg ff-main text-uppercase nav-link d-flex align-items-center gap-2.5 @if($element->isCurrent()) active @endif"
                                   href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank"
                                   rel="noopener noreferrer" @endif>
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown d-flex align-items-center gap-2.5" data-animate="navlink-anime">
                                <a class="nav-link ff-main text-uppercase text-lg dropdown-toggle @if($element->isCurrent()) active @endif"
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
                <ul class="nav-join navbar-nav flex-column flex-xl-row justify-content-center ml-auto mt-3 mt-md-0 gap-4 gap-xl-2 align-items-xl-center">
                    @if(theme_config('header.index.button.text'))
                        <li class="text-start">
                            <a href="{{theme_config('header.index.button.url') ?? "#"}}"
                               class="w-fit btn btn-outline-tertiary me-md-2"
                               rel="noopener noreferrer">@if(theme_config('header.index.button.icon'))
                                    <i class="{{theme_config('header.index.button.icon')}}"></i>
                                @endif {{theme_config('header.index.button.text') ?? ""}}</a>
                        </li>
                    @endif


                    <li class="nav-item dropdown d-flex flex-column flex-xl-row" data-animate="navlink-anime">
                        <a class="d-flex align-items-center gap-2 fw-bold text-uppercase text-uppercase dropdown-toggle text-md text-decoration-none text-decoration-none ps-3 ps-xl-0"
                           href="#" id="navbarDropdown-auth" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @guest
                                Connexion
                            @else
                                <img src={{Auth::user()->getAvatar(64)}} class="rounded-2" alt="Avatar" width="32" height="32">
                                <div class="d-flex flex-column">
                                    <span class="text-white">{{Auth::user()->name}}</span>
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
                                    <a class="dropdown-item d-flex align-items-center gap-2.5" href="{{ route('profile.index') }}">
                                        <i class="bi bi-person"></i> {{ trans('messages.nav.profile') }}
                                    </a>
                                </li>

                                @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2.5" href="{{ route($navItem['route']) }}">
                                            <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i> {{ $navItem['name'] }}
                                        </a>
                                    </li>
                                @endforeach

                                @if(Auth::user()->hasAdminAccess())
                                   <li>
                                       <a class="dropdown-item d-flex align-items-center gap-2.5" href="{{ route('admin.dashboard') }}">
                                           <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                                       </a>
                                   </li>
                                @endif

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2.5 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

   <div class="hero-carousel position-absolute top-0">
       <div class="carousel slide" data-bs-ride="carousel">
           <div class="carousel-inner">
               @if(theme_config('header.hero.carousel'))
                   @foreach(theme_config('header.hero.carousel') as $carousel)
                       @if($carousel)
                           <div class="carousel-item @if($loop->first) active @endif" data-bs-interval="3000">
                               <img src="{{image_url($carousel)}}" class="d-block w-100" alt="" @if($loop->first) loading="lazy" draggable="false" @endif>
                           </div>
                       @endif
                   @endforeach
               @endif
           </div>
       </div>
   </div>

    <div class="hero-join position-absolute top-100 start-50 translate-middle mt-3" data-editable="true">
        <div class="hero-join__button">
            @include('components.join-button', ['icon' => false])
        </div>

        <p class="text-white mb-0 text-sm text-center mt-1 fw-semibold">
            <i class="hero-connected me-1"></i>
            <span>
                @if($servers->where('home_display')->count() > 0)
                    {{theme_config('header.hero.joinText') ?? "Rejoignez ".$servers->where('home_display')->count()." combatants !"}}
                @endif
            </span>
        </p>
    </div>
</div>
