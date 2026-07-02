@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $showAvatar = (bool) ($settings['show_avatar'] ?? true);
    $showRole = (bool) ($settings['show_role'] ?? true);
    $logoutFormId = 'reborn-logout-form-'.uniqid();
@endphp

<div class="reborn-header-user">
    @guest
        <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
            <i class="bi bi-box-arrow-in-right"></i> {{ trans('auth.login') }}
        </a>

        @if(Route::has('register'))
            <a class="btn btn-primary btn-sm" href="{{ route('register') }}">
                <i class="bi bi-person-plus-fill"></i> {{ trans('auth.register') }}
            </a>
        @endif
    @else
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if($showAvatar)
                    <img src="{{ Auth::user()->getAvatar(64) }}" class="rounded-2" alt="Avatar" width="26" height="26">
                @endif
                <span>{{ Auth::user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                @if($showRole)
                    <li class="px-3 py-2">
                        <span class="badge" style="background-color: {{ Auth::user()->role->color }};">
                            {{ Auth::user()->role->name }}
                        </span>
                    </li>
                @endif

                <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="bi bi-person"></i> {{ trans('messages.nav.profile') }}
                    </a>
                </li>

                @foreach(plugins()->getUserNavItems() ?? [] as $navItem)
                    <li>
                        <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                            <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i> {{ $navItem['name'] }}
                        </a>
                    </li>
                @endforeach

                @if(Auth::user()->hasAdminAccess())
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                        </a>
                    </li>
                @endif

                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('{{ $logoutFormId }}').submit();">
                        <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                    </a>
                    <form id="{{ $logoutFormId }}" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    @endguest
</div>
