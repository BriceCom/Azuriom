<nav class="navbar navbar-expand-lg navbar-dark bg-transparent py-lg-3 mt-lg-3">
    <div class="container-fluid px-xxl-5">
        <div class="d-flex flex-wrap flex-xxl-nowrap justify-content-between justify-content-lg-around w-100">
            <a id="navbarLogo" class="navbar-brand text-md-center" href="{{ route('home') }}">
                <img src="{{theme_config('navbar.image') ? image_url(theme_config('navbar.image')):site_logo()}}" alt="Logo de {{site_name()}}" class="object-fit-contain" height="{{theme_config('navbar.imageHeightMax') ?? 40}}">
            </a>
            <div class="d-lg-none text-end my-auto">
                <button class="navbar-toggler d-contents" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse flex-wrap flex-xxl-nowrap" id="navbar">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mx-auto list-unstyled gap-2 gap-md-5 text-uppercase py-5 py-md-1 px-0 px-md-2 justify-content-center align-items-md-center text-center">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())
                            @php
                                $icon = match(strtolower($element->name)){
                                     'boutique' => '
                                        <svg style="vertical-align: unset;" xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                                          <path d="M2.97 0.35C3.06389 0.240235 3.18044 0.152111 3.31163 0.0916911C3.44283 0.0312716 3.58556 -9.50066e-06 3.73 2.16448e-09H12.27C12.4144 -9.50066e-06 12.5572 0.0312716 12.6884 0.0916911C12.8196 0.152111 12.9361 0.240235 13.03 0.35L15.639 3.394C15.8719 3.66583 16 4.01201 16 4.37V4.625C16.0001 5.11998 15.8455 5.6026 15.5578 6.00542C15.2702 6.40824 14.8639 6.71113 14.3957 6.87174C13.9275 7.03236 13.4208 7.04268 12.9465 6.90127C12.4721 6.75986 12.0538 6.47377 11.75 6.083C11.5281 6.36877 11.2438 6.59998 10.9188 6.75892C10.5938 6.91786 10.2368 7.00033 9.875 7C9.51321 7.0004 9.15612 6.91797 8.83112 6.75902C8.50611 6.60007 8.22181 6.36882 8 6.083C7.77819 6.36882 7.49389 6.60007 7.16888 6.75902C6.84388 6.91797 6.48679 7.0004 6.125 7C5.76321 7.0004 5.40612 6.91797 5.08112 6.75902C4.75611 6.60007 4.47181 6.36882 4.25 6.083C3.94619 6.47377 3.52788 6.75986 3.05354 6.90127C2.57919 7.04268 2.07252 7.03236 1.60432 6.87174C1.13613 6.71113 0.729823 6.40824 0.442182 6.00542C0.154542 5.6026 -5.45986e-05 5.11998 1.44645e-08 4.625V4.37C1.26075e-05 4.01201 0.128057 3.66583 0.361 3.394L2.971 0.349L2.97 0.35ZM4.75 4.625C4.75 4.98967 4.89487 5.33941 5.15273 5.59727C5.41059 5.85513 5.76033 6 6.125 6C6.48967 6 6.83941 5.85513 7.09727 5.59727C7.35513 5.33941 7.5 4.98967 7.5 4.625C7.5 4.49239 7.55268 4.36521 7.64645 4.27145C7.74021 4.17768 7.86739 4.125 8 4.125C8.13261 4.125 8.25979 4.17768 8.35355 4.27145C8.44732 4.36521 8.5 4.49239 8.5 4.625C8.5 4.98967 8.64487 5.33941 8.90273 5.59727C9.16059 5.85513 9.51033 6 9.875 6C10.2397 6 10.5894 5.85513 10.8473 5.59727C11.1051 5.33941 11.25 4.98967 11.25 4.625C11.25 4.49239 11.3027 4.36521 11.3964 4.27145C11.4902 4.17768 11.6174 4.125 11.75 4.125C11.8826 4.125 12.0098 4.17768 12.1036 4.27145C12.1973 4.36521 12.25 4.49239 12.25 4.625C12.25 4.98967 12.3949 5.33941 12.6527 5.59727C12.9106 5.85513 13.2603 6 13.625 6C13.9897 6 14.3394 5.85513 14.5973 5.59727C14.8551 5.33941 15 4.98967 15 4.625V4.37C15 4.25083 14.9575 4.13557 14.88 4.045L12.27 1H3.73L1.12 4.045C1.04255 4.13557 0.999991 4.25083 1 4.37V4.625C1 4.98967 1.14487 5.33941 1.40273 5.59727C1.66059 5.85513 2.01033 6 2.375 6C2.73967 6 3.08941 5.85513 3.34727 5.59727C3.60513 5.33941 3.75 4.98967 3.75 4.625C3.75 4.49239 3.80268 4.36521 3.89645 4.27145C3.99021 4.17768 4.11739 4.125 4.25 4.125C4.38261 4.125 4.50979 4.17768 4.60355 4.27145C4.69732 4.36521 4.75 4.49239 4.75 4.625ZM1.5 7.5C1.63261 7.5 1.75979 7.55268 1.85355 7.64645C1.94732 7.74021 2 7.86739 2 8V14H3V9C3 8.73478 3.10536 8.48043 3.29289 8.29289C3.48043 8.10536 3.73478 8 4 8H7C7.26522 8 7.51957 8.10536 7.70711 8.29289C7.89464 8.48043 8 8.73478 8 9V14H14V8C14 7.86739 14.0527 7.74021 14.1464 7.64645C14.2402 7.55268 14.3674 7.5 14.5 7.5C14.6326 7.5 14.7598 7.55268 14.8536 7.64645C14.9473 7.74021 15 7.86739 15 8V14H15.5C15.6326 14 15.7598 14.0527 15.8536 14.1464C15.9473 14.2402 16 14.3674 16 14.5C16 14.6326 15.9473 14.7598 15.8536 14.8536C15.7598 14.9473 15.6326 15 15.5 15H0.5C0.367392 15 0.240215 14.9473 0.146447 14.8536C0.0526784 14.7598 1.44645e-08 14.6326 1.44645e-08 14.5C1.44645e-08 14.3674 0.0526784 14.2402 0.146447 14.1464C0.240215 14.0527 0.367392 14 0.5 14H1V8C1 7.86739 1.05268 7.74021 1.14645 7.64645C1.24021 7.55268 1.36739 7.5 1.5 7.5ZM4 14H7V9H4V14ZM9 9C9 8.73478 9.10536 8.48043 9.29289 8.29289C9.48043 8.10536 9.73478 8 10 8H12C12.2652 8 12.5196 8.10536 12.7071 8.29289C12.8946 8.48043 13 8.73478 13 9V12C13 12.2652 12.8946 12.5196 12.7071 12.7071C12.5196 12.8946 12.2652 13 12 13H10C9.73478 13 9.48043 12.8946 9.29289 12.7071C9.10536 12.5196 9 12.2652 9 12V9ZM12 9H10V12H12V9Z" fill="white"/>
                                        </svg>
                                     ',
                                    default => ''
                                };
                            @endphp
                            <li class="nav-item text-nowrap">
                                <a class="nav-link
                            @if($element->isCurrent() && strtolower($element->name) != 'boutique') btn bg-primary px-3 py-1 @endif
                            @if(str_contains(strtolower($element->name), 'boutique')) custom-link px-3 py-1 @endif
                            " href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
                                    @if($icon != '')
                                        <i class="d-inline-block me-1">{!! $icon !!}</i>
                                    @endif
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if($element->isCurrent()) btn bg-primary px-3 py-1 active @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <ul id="userDropdownWrapper" class="@auth user-online @endauth navbar-nav mx-auto mx-lg-0 ml-md-auto align-items-center justify-content-center text-uppercase py-1 px-3 rounded" id>

                    <!-- Authentication Links -->
                    @guest
                        <div class="bg-black d-flex align-items-center py-1 px-3 rounded">
                            <li class="nav-item">
                                <a class="nav-link py-0 me-2" href="{{ route('login') }}">
                                    {{ trans('auth.login') }}
                                </a>
                            </li>
                            /
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link py-0 ms-2" href="{{ route('register') }}">
                                        {{ trans('auth.register') }}
                                    </a>
                                </li>
                            @endif
                        </div>
                    @else
                        <li class="nav-item dropdown ">
                            <a id="userDropdown" class="nav-link justify-content-center dropdown-toggle bg-dark rounded d-flex align-items-center gap-2 px-3" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ Auth::user()->getAvatar() }}" alt="Votre tête du personnage minecraft" height="25">
                                <span>{{ Auth::user()->name }}</span>
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
                                    {{ trans('auth.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <div class="text-center py-3">
                                    @if(plugins()->isEnabled('shop'))
                                        <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block">
                                            <i class="bi bi-cart"></i> MON PANIER
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</nav>
