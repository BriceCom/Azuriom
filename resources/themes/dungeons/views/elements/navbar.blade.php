<header>
    @if(theme_config('navbar.announce-bar.show'))
        <div class="bg-primary announce-bar text-uppercase text-center py-2">
            <p class="m-0 my-1 px-3">{{ theme_config('navbar.announce-bar.text') ? theme_config('navbar.announce-bar.text'):'DUNGEONS EST EN COURS DE DÉVELOPPEMENT, REJOIGNEZ NOUS SUR DISCORD POUR SUIVRE NOTRE ACTIVITÉS' }}</p>
        </div>
    @endif
    <nav class="navbar navbar-expand-xl navbar-dark bg-black py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ site_logo() }}" alt="{{site_name()}}" height="37">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mx-auto list-unstyled align-items-center gap-3 gap-md-4 py-3 py-md-0">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())
                            @php
                                $icon = match(strtolower($element->name)){
                                    'accueil' => '
                                        <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 14.3425V8.79451V8.79376C17 8.25992 17 7.99286 16.9351 7.74434C16.8775 7.52399 16.7827 7.31504 16.6548 7.12661C16.5104 6.91398 16.3096 6.7381 15.9074 6.38623L11.1074 2.18623C10.3608 1.53295 9.98751 1.20635 9.56738 1.08211C9.19719 0.972631 8.80281 0.972631 8.43262 1.08211C8.01272 1.20628 7.63979 1.53259 6.894 2.18516L6.89278 2.18623L2.09277 6.38623L2.09182 6.38707C1.69032 6.73838 1.48944 6.91415 1.34521 7.12661C1.2173 7.31504 1.12255 7.52399 1.06497 7.74434C1 7.99298 1 8.26017 1 8.79451V14.3425C1 15.2743 1 15.7402 1.15224 16.1077C1.35523 16.5978 1.74481 16.9872 2.23486 17.1901C2.60241 17.3424 3.06835 17.3424 4.00023 17.3424C4.93211 17.3424 5.39782 17.3424 5.76537 17.1901C6.25542 16.9872 6.64467 16.5978 6.84766 16.1077C6.9999 15.7402 7 15.2742 7 14.3424V13.3424C7 12.2378 7.89543 11.3424 9 11.3424C10.1046 11.3424 11 12.2378 11 13.3424V14.3424C11 15.2742 11 15.7402 11.1522 16.1077C11.3552 16.5978 11.7448 16.9872 12.2349 17.1901C12.6024 17.3424 13.0683 17.3424 14.0002 17.3424C14.9321 17.3424 15.3978 17.3424 15.7654 17.1901C16.2554 16.9872 16.6447 16.5978 16.8477 16.1077C16.9999 15.7402 17 15.2743 17 14.3425Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                     ',
                                     'voter' => '
                                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 4.15428C8 -0.540161 1 -0.0401611 1 5.95987C1 11.9599 10 16.9598 10 16.9598C10 16.9598 19 11.9599 19 5.95987C19 -0.0401611 12 -0.540161 10 4.15428Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                     ',
                                     'boutique' => '
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 15C13.8954 15 13 15.8954 13 17C13 18.1046 13.8954 19 15 19C16.1046 19 17 18.1046 17 17C17 15.8954 16.1046 15 15 15ZM15 15H7.29395C6.83269 15 6.60197 15 6.41211 14.918C6.24466 14.8456 6.09934 14.7288 5.99349 14.5802C5.87348 14.4118 5.82609 14.1863 5.72945 13.7353L3.27148 2.26477C3.17484 1.81376 3.12587 1.58825 3.00586 1.4198C2.90002 1.27123 2.75525 1.15441 2.5878 1.08205C2.39794 1 2.16779 1 1.70653 1H1M4 4H16.8732C17.595 4 17.9557 4 18.1979 4.15036C18.4101 4.28206 18.5652 4.48838 18.6329 4.72876C18.7102 5.00319 18.611 5.34996 18.411 6.04346L17.0264 10.8435C16.9068 11.2581 16.8469 11.4655 16.7256 11.6193C16.6185 11.7551 16.4772 11.8608 16.3171 11.926C16.1356 12 15.9199 12 15.4883 12H5.73047M6 19C4.89543 19 4 18.1046 4 17C4 15.8954 4.89543 15 6 15C7.10457 15 8 15.8954 8 17C8 18.1046 7.10457 19 6 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                     ',
                                     'wiki' => '
                                        <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 17.5V4.19995C1 3.07985 1 2.51986 1.21799 2.09204C1.40973 1.71572 1.71547 1.40973 2.0918 1.21799C2.51962 1 3.08009 1 4.2002 1H13.4002C13.9602 1 14.2405 1 14.4544 1.10899C14.6425 1.20487 14.7948 1.35786 14.8906 1.54602C14.9996 1.75993 15 2.03992 15 2.59998V14.4C15 14.96 14.9996 15.2401 14.8906 15.454C14.7948 15.6422 14.6425 15.7951 14.4544 15.891C14.2405 16 13.9601 16 13.4 16H3.25C2.00736 16 1 17.0074 1 18.25C1 18.6642 1.33579 19 1.75 19H12.4C12.9601 19 13.2405 19 13.4544 18.891C13.6425 18.7951 13.7948 18.6422 13.8906 18.454C13.9996 18.2401 14 17.9601 14 17.4V16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                     ',
                                     'support' => '
                                        <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 8C17 4.13401 13.866 1 10 1C6.13401 1 3 4.13401 3 8M14 11.5V13.5C14 13.9647 14 14.197 14.0384 14.3902C14.1962 15.1836 14.816 15.8037 15.6094 15.9615C15.8026 16 16.0353 16 16.5 16C16.9647 16 17.197 16 17.3902 15.9615C18.1836 15.8037 18.8041 15.1836 18.9619 14.3902C19.0003 14.197 19 13.9647 19 13.5V11.5C19 11.0353 19.0003 10.8031 18.9619 10.6099C18.8041 9.81648 18.1836 9.19624 17.3902 9.03843C17.197 9 16.9647 9 16.5 9C16.0353 9 15.8026 9 15.6094 9.03843C14.816 9.19624 14.1962 9.81648 14.0384 10.6099C14 10.8031 14 11.0353 14 11.5ZM6 11.5V13.5C6 13.9647 6.00034 14.197 5.96191 14.3902C5.8041 15.1836 5.18356 15.8037 4.39018 15.9615C4.19698 16 3.96421 16 3.49956 16C3.0349 16 2.80257 16 2.60938 15.9615C1.81599 15.8037 1.19624 15.1836 1.03843 14.3902C1 14.197 1 13.9647 1 13.5V11.5C1 11.0353 1 10.8031 1.03843 10.6099C1.19624 9.81648 1.81599 9.19624 2.60938 9.03843C2.80257 9 3.0349 9 3.49956 9C3.96421 9 4.19698 9 4.39018 9.03843C5.18356 9.19624 5.8041 9.81648 5.96191 10.6099C6.00034 10.8031 6 11.0353 6 11.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                     ',
                                    default => ''
                                };
                            @endphp
                            <li class="nav-item text-center">
                                <a class="nav-link @if($element->isCurrent()) active @endif text-uppercase
                                @if(str_contains(strtolower($element->name), 'boutique')) btn custom-link @endif
                                "
                                   href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                    @if($icon != '')
                                        <i class="d-inline-block">{!! $icon !!}</i>
                                    @endif
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if($element->isCurrent()) active @endif text-uppercase" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $element->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                    @foreach($element->elements as $childElement)
                                        <a class="dropdown-item @if($childElement->isCurrent()) active @endif text-uppercase" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $childElement->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item mt-3 mt-md-0">
                            <a class="nav-link btn custom-user-link" href="{{ route('login') }}">
                              <i class="bi bi-person"></i>  {{ trans('auth.login') }}
                            </a>
                        </li>

                        @if(Route::has('register'))
                            <li class="nav-item mt-2 mt-md-0 ms-2">
                                <a class="nav-link btn custom-user-link" href="{{ route('register') }}">
                                    <i class="bi bi-person"></i>
                                    {{ trans('auth.register') }}
                                </a>
                            </li>
                        @endif
                    @else

                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle btn custom-user-link mt-3 mt-xl-0" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person me-2"></i> Mon compte
                            </a>

                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person me-2"></i> Mon profil
                                </a>

                                @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                                    <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                                        @php
                                            $nav_item = match (strtolower($navItem['name'])) {
                                                'vos achats' => array('icon' => 'bi bi-cart', 'custom_name' => 'Mes achats'),
                                                default => array('icon' => 'bi bi-three-dots', 'custom_name' => $navItem['name']),
                                            };
                                        @endphp
                                        <i class="{{ $nav_item['icon'] }} me-2"></i> {{ $nav_item['custom_name'] }}
                                    </a>
                                @endforeach

                                @if(Auth::user()->hasAdminAccess())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-sliders me-2"></i> Administrateur
                                    </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ trans('auth.logout') }}
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
</header>
