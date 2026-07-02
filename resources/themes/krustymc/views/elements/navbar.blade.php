<nav class="position-relative z-1 navbar navbar-expand-md navbar-dark py-3">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse flex-wrap gap-3 navbar-collapse mt-5 mt-md-0 py-md-2 px-md-5" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav align-items-center gap-3 list-unstyled me-auto">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="@if($element->isCurrent()) active @endif @if(strtolower($element->name) == 'boutique') py-1 btn btn-primary btn-gradient navbar-shop__btn @else nav-link @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
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

            <!-- Right Side Of Navbar -->
            <div class="user__btn d-flex flex-row-reverse flex-md-row flex-wrap flex-grow-1 flex-sm-grow-0 align-items-center gap-3 mt-4 mt-md-0 ms-md-2">
                @auth
                    <ul class="list-unstyled d-flex gap-2 mb-0">
                        @include('elements.notifications')
                    </ul>
                @endauth

                <ul class="flex-grow-1 navbar-nav flex-row align-items-center justify-content-center justify-content-md-start gap-5 gap-md-2 @guest px-3 @else px-1 @endguest bg-body-secondary rounded-1">

                    <!-- Authentication Links -->
                    @guest
                        <div class="d-flex gap-2 bg-dark rounded-1 px-3">
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
                        </div>
                    @else
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link d-flex gap-2 dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ Auth::user()->getAvatar(32) }}" class="object-fit-contain rounded-1" height="32" width="32" alt="Avatar {{ Auth::user()->name }}">
                                <div class="d-flex flex-column me-1">
                                    <span class="text-xs fw-bold">{{ Auth::user()->name }}</span>
                                    <span class="d-block badge text-xxs" style="background-color: {{Auth::user()->role->color}};">{{Auth::user()->role->name}}</span>
                                </div>
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
    </div>
</nav>
