<nav class="navbar navbar-expand-lg navbar-light z-1">
    <div class="container py-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-lg-start text-center" id="navbar">
            <a class="w-25 navbar-brand m-0" href="{{ route('home') }}">
                @if(theme_config('general.navbarLogo.toggle'))
                    <img class="object-fit-contain" style="height: 50px" src="{{ site_logo() }}" alt="Logo {{site_name()}}">
                @else
                    {{ site_name() }}
                @endif
            </a>
            <hr class="d-lg-none d-block"/>
            <!-- Left Side Of Navbar -->
            <ul class="flex-grow-1 text-start navbar-nav justify-content-center list-unstyled gap-2">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class=" @if($element->isCurrent()) active @endif @if(str_contains(strtolower($element->name), strtolower(theme_config('header.btn.shop')))) btn btn-secondary @else nav-link @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if($element->isCurrent()) active @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $element->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                @foreach($element->elements as $childElement)
                                    <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) rel="noopener noreferrer" @endif>
                                        {{ $childElement->name }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
            <hr class="d-lg-none d-block"/>
            <!-- Right Side Of Navbar -->
            <ul class="w-25 navbar-nav flex-row justify-content-center justify-content-lg-end gap-3 gap-lg-0">

                @include('elements.theme-selector')

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('login') }}">
                            {{ trans('auth.login') }}
                        </a>
                    </li>

                    @if(Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                {{ trans('auth.register') }}
                            </a>
                        </li>
                    @endif
                @else
                    @include('elements.notifications')

                    <li class="nav-item dropdown">
                        <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                {{ trans('messages.nav.profile') }}
                            </a>

                            @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                                <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                                    {{ $navItem['name'] }}
                                </a>
                            @endforeach

                            @if(Auth::user()->hasAdminAccess())
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    {{ trans('messages.nav.admin') }}
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
