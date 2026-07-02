<div class="bg-dark py-2 first-nav">
    <div class="container d-flex flex-md-row flex-column justify-content-between align-items-center">
        <span class="text-primary text-uppercase fw-bold">
            @if($server)
                @if($server->isOnline())
                    {{ $server->getOnlinePlayers() }} <span class="fw-lighter">JOUEUR(S) EN LIGNE</span>
                @else
                    <span class="fw-lighter">{{ trans('messages.server.offline') }}</span>
                @endif
            @endif
        </span>

        <ul class="d-flex gap-4 ml-md-auto mb-0 p-0 list-unstyled">

            <!-- Authentication Links -->
            @guest

                @if(Route::has('register'))
                    <li>
                        <a class="text-white text-uppercase fw-light text-decoration-none" href="{{ route('register') }}">
                            S'inscrire
                        </a>
                    </li>
                @endif

                <li>
                    <a class="text-white text-uppercase fw-light text-decoration-none" href="{{ route('login') }}">
                        Se connecter
                    </a>
                </li>
            @else
                @include('elements.notifications')

                <li class="dropdown">
                    <a id="userDropdown" class="dropdown-toggle text-white text-uppercase fw-light text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ trans('auth.logout') }}
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
<nav class="navbar navbar-expand-md navbar-light flex-column bg-topbar-grey py-4">
    <div class="container">
        <h1 class="mb-0">
            <a class="navbar-brand p-0" href="{{ route('home') }}">
                <img src="{{site_logo()}}" alt="Serveur minecraft {{site_name()}}" height="60">
            </a>
        </h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ms-auto text-uppercase">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="nav-link @if($element->isCurrent()) active text-primary @endif" href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if($element->isCurrent()) active text-primary @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $element->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                @foreach($element->elements as $childElement)
                                    <a class="dropdown-item @if($childElement->isCurrent()) active text-primary @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
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
</nav>
