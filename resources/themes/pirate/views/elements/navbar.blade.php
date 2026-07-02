@push('scripts')
    <script>
        const navbarBrand = document.querySelector('.navbar-brand');
        const userMenu = document.querySelector('#userMenu');

        function updateNavbarWidth() {
            navbarBrand.style.width = userMenu.offsetWidth;
        }

        window.addEventListener('resize', updateNavbarWidth);
        updateNavbarWidth();
    </script>
@endpush

<nav class="navbar navbar-expand-xl z-3 pt-3 position-relative px-5">
    <div class="container justify-content-center px-lg-5">
        <div class="w-100 d-flex align-items-center justify-content-betweent gap-5 navbar-overlay px-lg-4">
            <!-- Logo à gauche -->
            <a class="navbar-brand me-0" href="{{ route('home') }}">
                @if(setting('logo'))
                    <img src="https://pixelrealm.fr/storage/img/faviconshadow.png" alt="Logo" width="55" class="navbar-logo">
                @else
                    {{ site_name() }}
                @endif
            </a>

            <!-- Bouton burger (mobile) -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenu de la navbar -->
            <div class="collapse navbar-collapse gap-5" id="navbar">
                <!-- Menu principal (centré grâce à mx-auto) -->
                <ul class="navbar-nav mx-auto navbar-main-nav">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())
                            <li class="nav-item">
                                <a class="nav-link @if($element->isCurrent()) active @endif"
                                   href="{{ $element->getLink() }}"
                                   @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if($element->isCurrent()) active @endif" href="#"
                                   id="navbarDropdown{{ $element->id }}" role="button"
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

                <!-- Menu utilisateur (login/register ou pseudo) aligné à droite grâce à ms-auto -->
                <ul id="userMenu" class="navbar-nav justify-content-end">
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
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#"
                               role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false" v-pre>
                                <!-- Pseudo potentiellement très long -->
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
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
    </div>
</nav>
