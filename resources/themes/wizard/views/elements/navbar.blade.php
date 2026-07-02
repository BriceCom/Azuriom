<div class="bg-purple-900 border-bottom border-purple-800 px-3">
    <div
        class="container fw-bold text-gray-100 text-uppercase py-0 navbar navbar-dark navbar-expand-xl justify-content-between">
        @if($server)
            @if($server->isOnline())
                <p class="mb-0 py-2 fs-7 ornament"><span class="text-yellow-600">{{$server->getOnlinePlayers()}}</span>
                    joueurs en ligne
                </p>
            @else
                <p class="mb-0 py-2">{{ trans('messages.server.offline') }}</p>
            @endif
        @endif
        <button class="navbar-toggler-custom border-0 d-xl-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="text-white">
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </button>
    </div>
</div>
<nav class="navbar navbar-expand-xl navbar-dark bg-transparent position-absolute w-100 py-0">
    <div class="container justify-content-around gap-4 gap-md-5">
        <a class="navbar-brand d-none d-xl-block" href="{{ route('home') }}" title="{{ site_name() }}">
            <img src="{{site_logo()}}" alt="{{site_name()}}">
        </a>

        <div class="collapse navbar-collapse flex-grow-0" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto font-family-azul text-uppercase fs-7 shadow-2xl py-3">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="nav-link border-separator fw-bold @if($element->isCurrent()) active @endif"
                               href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank"
                               rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link border-separator fw-bold dropdown-toggle @if($element->isCurrent()) active @endif"
                               href="#"
                               id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{ $element->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                @foreach($element->elements as $childElement)
                                    <a class="dropdown-item @if($childElement->isCurrent()) active @endif"
                                       href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank"
                                       rel="noopener noreferrer" @endif>
                                        {{ $childElement->name }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="d-flex flex-row align-items-center gap-4 mt-4 mt-xl-0 ms-4">
            <a href="{{theme_config('global.shop.url') ?? route('shop.home')}}" title="Boutique" class="btn-shop">
                <span class="btn-shop__over"></span>
                Boutique</a>

            <ul class="d-flex align-items-center gap-4 list-unstyled m-0">
                @guest
                    <li class="nav-item dropdown ms-md-3">
                        <a id="guestDropdown" class="text-primary text-decoration-none dropdown-toggle text-white" href="#"
                           role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                           v-pre>
                            <i class="bi bi-person-circle fs-1"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                            <a class="dropdown-item" href="{{ route('login') }}">
                                {{ trans('auth.login') }}
                            </a>
                            @if(Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">
                                    {{ trans('auth.register') }}
                                </a>
                            @endif
                        </div>
                    </li>
                @else
                    {{--                                    @include('elements.notifications')--}}

                    <li class="nav-item dropdown">
                        <a id="userDropdown" aria-label="Accéder à votre profil"
                           class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false" v-pre>
                            <img aria-hidden="true" src="{{Auth::user()->getAvatar(32)}}" alt="" width="32"
                                 height="32">
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

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
