<nav class="navbar navbar-expand-md navbar-dark flex-column p-0">
    <div class="w-100 d-flex flex-wrap align-items-center justify-content-between bg-dark bg-opacity-75 py-2 px-md-8 px-4">
        <span class="text-uppercase">
            @if($servers)
                @php($connected = 0)
                @foreach($servers as $server)
                    @if($server->isOnline())
                        @php($connected += $server->getOnlinePlayers())
                    @endif
                @endforeach
                {{$connected}} Joueurs en ligne
            @else
                Serveur hors-ligne
            @endif
        </span>

        <ul class="navbar-nav ml-auto">
            @guest
                <li class="d-flex align-items-center gap-2">
                    @includeIf('components.login-modal')
                    •
                    @if(Route::has('register'))
                        @includeIf('components.register-modal')
                    @endif
                </li>
            @else
{{--                @include('elements.notifications')--}}

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
    <div class="w-100 d-flex justify-content-between align-items-center flex-wrap bg-dark bg-opacity-50 py-2 px-md-8 px-4">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ site_name() }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mx-auto list-unstyled">
                @foreach($navbar as $element)
{{--                    {{dd($loop->iteration)}}--}}
                    @if(!$element->isDropdown())
                        <li class="nav-item @if($loop->iteration == (round($navbar->count() / 2))) mx-md-4 fs-6 fw-semibold @endif">
                            <a class="nav-link @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
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
        </div>
    </div>
</nav>

@push('footer-scripts')
    <script>
        const brand = document.querySelector('.navbar-brand');
        const navbar = document.querySelector('#navbar')

        navbar.style.marginRight = brand.offsetWidth + 72 +'px';
    </script>
@endpush
