<header class="drive-topbar">
    <div class="drive-topbar__left">
        <button type="button" class="btn drive-sidebar-toggle drive-sidebar-toggle--mobile" data-drive-sidebar-toggle aria-label="Toggle sidebar">
            <i class="bi bi-layout-sidebar-inset"></i>
        </button>

        <form class="drive-search" action="{{ url()->current() }}" method="GET" role="search">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search players, posts, pages..." aria-label="Search">
        </form>
    </div>

    <div class="drive-topbar__actions">
        @auth
            <div class="drive-credit">
                <span class="drive-credit__label">Credits</span>
                <strong>{{ format_money((float) auth()->user()->money) }}</strong>
            </div>
        @endauth

        <div class="drive-topbar__icon">
            <ul class="navbar-nav flex-row align-items-center gap-2 mb-0">
                @auth
                    @include('elements.notifications')
                @endauth

                @if(!theme_config('style.index.theme.dark.off'))
                    @include('elements.theme-selector')
                @endif
            </ul>
        </div>

        @auth
            <div class="dropdown drive-topbar__user-menu">
                <a href="#" id="driveUserDropdown" class="drive-topbar__user dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->getAvatar(64) }}" alt="Avatar {{ auth()->user()->name }}" width="36" height="36" class="rounded-2">
                    <span>{{ auth()->user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="driveUserDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="bi bi-person"></i> {{ trans('messages.nav.profile') }}
                        </a>
                    </li>

                    @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                        <li>
                            <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                                <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i> {{ $navItem['name'] }}
                            </a>
                        </li>
                    @endforeach

                    @if(auth()->user()->hasAdminAccess())
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                            </a>
                        </li>
                    @endif

                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('drive-topbar-logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                        </a>
                    </li>
                </ul>

                <form id="drive-topbar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        @endauth
    </div>
</header>
