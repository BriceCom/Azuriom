<nav class="navbar navbar-expand-lg navbar-dark sticky-top custom-navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" class="navbar-logo" />
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 nav-links">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a href="{{ $element->getLink() }}" class="nav-link-custom @if($element->isCurrent()) active @endif" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link-custom dropdown-toggle @if($element->isCurrent()) active @endif" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $element->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                @foreach($element->elements as $childElement)
                                    <li>
                                        <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $childElement->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                @php($shopVariant = theme_config('header.index.links.shop_variant') ?? 'primary')
                <a href="{{ theme_config('sidebar.shop_button.url') ?? '#' }}" class="btn btn-outline-{{ $shopVariant }}">{{ theme_config('sidebar.shop_button.text') ?? 'Boutique' }}</a>

                @if(!theme_config('style.index.theme.dark.off'))
                    @include('elements.theme-selector')
                @endif

                @guest
                    <a href="{{ route('login') }}" class="user-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="white">
                            <path d="M6 28C6 28 4 28 4 26C4 24 6 18 16 18C26 18 28 24 28 26C28 28 26 28 26 28H6ZM16 16C17.5913 16 19.1174 15.3679 20.2426 14.2426C21.3679 13.1174 22 11.5913 22 10C22 8.4087 21.3679 6.88258 20.2426 5.75736C19.1174 4.63214 17.5913 4 16 4C14.4087 4 12.8826 4.63214 11.7574 5.75736C10.6321 6.88258 10 8.4087 10 10C10 11.5913 10.6321 13.1174 11.7574 14.2426C12.8826 15.3679 14.4087 16 16 16Z"/>
                        </svg>
                    </a>
                @else
                    <div class="dropdown">
                        <a href="#" class="user-icon dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}" width="42" height="42" class="rounded-2">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                {{ trans('messages.nav.profile') }}
                            </a>
                            @if(auth()->user()->hasAdminAccess())
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    {{ trans('messages.nav.admin') }}
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ trans('auth.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
