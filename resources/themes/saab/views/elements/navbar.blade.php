<nav class="navbar navbar-expand-lg navbar-dark py-3">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto list-unstyled gap-3 mt-5 mt-lg-0">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-white fs-6 text-uppercase @if($element->isCurrent()) active underline_custom primary center @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link fw-semibold fs-6 text-uppercase dropdown-toggle @if($element->isCurrent()) active underline_custom center @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav align-items-lg-center ml-md-auto gap-3 mt-3 mt-lg-0">

                <a href="" class="w-fit d-inline-block mt-3 mt-md-0 nav-item btn btn-primary btn-gradient rounded-pill border-3 border-primary-subtle px-5 py-2 fw-semibold text-uppercase text-sm my-4 my-md-0">
                    Boutique
                </a>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item dropdown ms-md-3">
                        <a id="guestDropdown" class="text-white text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="bi bi-person-fill fs-3"></i>
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
{{--                    @include('elements.notifications')--}}

                    <li class="nav-item dropdown ms-md-3">
                        <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{Auth::user()->getAvatar(32)}}" alt="Avatar de {{ Auth::user()->name }}" class="rounded-3">
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
