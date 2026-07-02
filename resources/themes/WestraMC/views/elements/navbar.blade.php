<nav class="navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ site_logo() }}" alt="Logo du site {{site_name()}}" height="48">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mx-auto gap-3 list-unstyled">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="nav-link @if($element->isCurrent()) btn btn-primary mx-md-2 px-3 active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if($element->isCurrent()) btn btn-primary mx-md-2 px-3 active @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <ul id="nav-right" class="navbar-nav ml-auto">

                @include('elements.theme-selector')

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item dropdown ms-md-3">
                        <a id="guestDropdown" class="text-primary text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <svg width="24" height=24" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.77067 28.3182C9.50118 26.2096 13.7148 25.1046 18 25.1111C22.4444 25.1111 26.6169 26.2756 30.2293 28.3182M23.3333 14.4444C23.3333 15.8589 22.7714 17.2155 21.7712 18.2157C20.771 19.2159 19.4145 19.7778 18 19.7778C16.5855 19.7778 15.229 19.2159 14.2288 18.2157C13.2286 17.2155 12.6667 15.8589 12.6667 14.4444C12.6667 13.03 13.2286 11.6734 14.2288 10.6732C15.229 9.67301 16.5855 9.11111 18 9.11111C19.4145 9.11111 20.771 9.67301 21.7712 10.6732C22.7714 11.6734 23.3333 13.03 23.3333 14.4444ZM34 18C34 20.1011 33.5861 22.1817 32.7821 24.1229C31.978 26.0641 30.7994 27.828 29.3137 29.3137C27.828 30.7994 26.0641 31.978 24.1229 32.7821C22.1817 33.5861 20.1011 34 18 34C15.8989 34 13.8183 33.5861 11.8771 32.7821C9.93586 31.978 8.17203 30.7994 6.68629 29.3137C5.20055 27.828 4.022 26.0641 3.21793 24.1229C2.41385 22.1817 2 20.1011 2 18C2 13.7565 3.68571 9.68687 6.68629 6.68629C9.68687 3.68571 13.7565 2 18 2C22.2435 2 26.3131 3.68571 29.3137 6.68629C32.3143 9.68687 34 13.7565 34 18Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
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
                    <li class="nav-item dropdown">
                        <a id="userDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2 ms-md-3" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{Auth::user()->getAvatar(32)}}" alt="Avatar de {{ Auth::user()->name }}" class="rounded-circle">
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
    </div>
</nav>



@push('footer-scripts')
    <script>
        const navBrand = document.querySelector('.navbar-brand');
        const navRight = document.getElementById('nav-right');

        window.addEventListener('load', function () {
            navBrand.style.width = `${navRight.getBoundingClientRect().width}px`
        })

    </script>
@endpush
