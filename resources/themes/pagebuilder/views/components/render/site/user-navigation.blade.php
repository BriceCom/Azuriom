@php
    $componentAttributes = is_array($component['attributes'] ?? null) ? $component['attributes'] : [];
    $componentClasses = collect($component['classes'] ?? [])
        ->filter(fn ($className) => is_string($className) && trim($className) !== '')
        ->values()
        ->all();
    $componentStyles = is_array($component['style'] ?? null) ? $component['style'] : [];
    $componentId = isset($componentAttributes['id']) && is_string($componentAttributes['id']) ? $componentAttributes['id'] : null;
    $componentStyleString = collect($componentStyles)
        ->filter(fn ($value, $property) => is_string($property) && is_scalar($value) && trim((string) $value) !== '')
        ->map(fn ($value, $property) => $property.':'.trim((string) $value))
        ->implode(';');
    $userDropdownId = 'navbarDropdownAuth'.uniqid();
    $logoutFormId = 'logout-form-'.uniqid();
@endphp

<div @if($componentId) id="{{ $componentId }}" @endif @class($componentClasses) @if($componentStyleString) style="{{ $componentStyleString }}" @endif>
    <ul id="userNav" class="navbar-nav flex-column flex-xl-row justify-content-center list-unstyled mt-3 mt-md-0 gap-3 align-items-center">
        <li class="nav-item dropdown d-flex flex-column flex-xl-row">
            <a class="d-flex align-items-center gap-2 fw-bold text-uppercase dropdown-toggle text-decoration-none ps-0"
               href="#" id="{{ $userDropdownId }}" role="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @guest
                    <i class="bi bi-person-fill fs-4"></i>
                @else
                    <img src="{{ Auth::user()->getAvatar(64) }}" class="rounded-2" alt="Avatar" width="38" height="38">
                    <div class="d-flex flex-column">
                        <span>{{ Auth::user()->name }}</span>
                        <span class="badge fw-normal" style="background-color: {{ Auth::user()->role->color }}">{{ Auth::user()->role->name }}</span>
                    </div>
                @endguest
            </a>

            <ul class="dropdown-menu" aria-labelledby="{{ $userDropdownId }}">
                @guest
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            {{ trans('auth.login') }}
                        </a>
                    </li>

                    @if(Route::has('register'))
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i>
                                {{ trans('auth.register') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.index') }}">
                            <i class="bi bi-person"></i> {{ trans('messages.nav.profile') }}
                        </a>
                    </li>

                    @foreach(plugins()->getUserNavItems() ?? [] as $navItem)
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route($navItem['route']) }}">
                                <i class="{{ $navItem['icon'] ?? 'bi bi-three-dots' }}"></i> {{ $navItem['name'] }}
                            </a>
                        </li>
                    @endforeach

                    @if(Auth::user()->hasAdminAccess())
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                            </a>
                        </li>
                    @endif

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('{{ $logoutFormId }}').submit();">
                            <i class="bi bi-box-arrow-right"></i> {{ trans('auth.logout') }}
                        </a>
                        <form id="{{ $logoutFormId }}" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </li>
    </ul>
</div>
