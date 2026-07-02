<nav class="navbar navbar-expand-md navbar-dark p-0">
    <div class="container h-100 flex-column flex-md-row justify-content-end">

        <button class="navbar-toggler ms-auto my-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon-open bi bi-x-lg d-none"></span>
        </button>

        <div class="d-none d-md-block">
            <a href="/" class="position-absolute top-100 start-50 translate-middle">
                <img src="{{site_logo()}}" alt="Logo de {{site_name()}}" style="max-height: 168px">
            </a>
        </div>
        <div class="collapse navbar-collapse flex-column w-100" id="navbar">
            <div class="w-100 d-flex flex-column flex-md-row py-4">
                <ul class="container navbar-nav d-flex align-center gap-2 p-0">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())
                            <li class="nav-item">
                                <a class="nav-link @if($element->isCurrent()) active text-primary @endif fw-bold h6 my-2 my-md-0 text-uppercase
                                @if(strtolower($element->name) === 'boutique')  rounded-3 bg-tertiary bg-tertiary text-white @endif
                                "
                                   href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank"
                                   rel="noopener noreferrer" @endif>
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if($element->isCurrent()) active ps-3 @endif fw-bold h6 my-2 my-md-0 text-uppercase"
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
                <ul class="container navbar-nav justify-content-end gap-3 p-0">
                    @if(plugins()->isEnabled('shop'))
                        @include('elements.basket')
                    @endif
                    <!-- Authentication Links -->
                    @guest
                        <li>
                            <a class="text-uppercase btn btn-primary"
                               href="{{ route('login') }}">
                                Connexion
                            </a>
                        </li>
                    @else
                        @include('elements.notifications')

                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ Auth::user()->getAvatar(24) }}" alt="Avatar de {{ Auth::user()->name }}">
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
    </div>
</nav>
