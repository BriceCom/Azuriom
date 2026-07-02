<nav class="navbar navbar-expand-md navbar-dark p-0">
        <div class="container-fluid p-0">
{{--            <div class="w-100 p-3 text-end">--}}
                <button class="navbar-toggler m-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon-open bi bi-x-lg d-none"></span>
                </button>
{{--            </div>--}}

        <div class="collapse navbar-collapse flex-column" id="navbar">
            <!-- Right Side Of Navbar -->
            <div class="w-100 bg-dark bg-opacity-50 py-2">
                <ul class="container navbar-nav justify-content-end">
                    <!-- Authentication Links -->
                    @guest
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
                    @else
                        @include('elements.notifications')

                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
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
                        </li>
                    @endguest
                </ul>
            </div>
            <!-- Left Side Of Navbar -->

            <div class="w-100 bg-dark bg-opacity-25 py-4">
                <ul class="container navbar-nav d-flex justify-content-center align-center">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())
                            <li class="nav-item">
                                <a class="nav-link @if($element->isCurrent()) active border-3 border-start border-primary ps-3 @endif fw-bold h6 my-2 my-md-0 mx-md-3" href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if($element->isCurrent()) active border-3 border-start border-primary ps-3 @endif fw-bold h6 my-2 my-md-0 mx-md-3" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            </div>

        </div>
    </div>
</nav>
