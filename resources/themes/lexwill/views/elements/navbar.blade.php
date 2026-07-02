<!-- HEADER START -->
<div class="header-line-wrapper">
    <header class="header-wrapper position-relative fixed-top plr100" style="font-size-adjust: {{theme_config('header.index.fontSize') != 0 ?  theme_config('header.index.fontSize'):"unset"}};">
        <div class="header-di h-100">
            <div>
                <a href="/" class="logo">
                    <img height="75" src="{{site_logo()}}" alt="Logo du site {{site_name()}}"
                         class="img-responsive inline-block">
                </a>
            </div>
            <div class= ms-auto">
                <div class="main-menu">
                    <ul class="menu clearfix d-flex flex-column flex-lg-row align-items-md-center pt-8 pt-lg-0 gap-4 gap-lg-0 m-0">
                        @foreach($navbar as $element)
                            @if(!$element->isDropdown())
                                <li class="@if($element->isCurrent()) active @endif text-nowrap">
                                    <a href="{{ $element->getLink() }}"
                                       @if($element->new_tab) rel="noopener noreferrer" @endif>
                                        {{ $element->name }}
                                    </a>
                                </li>
                            @else
                                <li class="inline-block menu-item-has-children text-nowrap @if($element->isCurrent()) active @endif">
                                    <a href="#">
                                        {{ $element->name }}
                                    </a>
                                    <ul class="sub-menu">
                                        @foreach($element->elements as $childElement)
                                            <li class="@if($childElement->isCurrent()) active @endif">
                                                <a href="{{ $childElement->getLink() }}"
                                                   @if($childElement->new_tab) rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div>
                <div class="w-fit d-flex align-items-center justify-content-end gap-3">
                    @include('components.nav-search')

                    <ul class="d-flex align-items-center gap-4 list-unstyled m-0">
                        @guest
                            <li class="nav-item dropdown ms-md-3">
                                <a id="guestDropdown" class="text-primary text-decoration-none dropdown-toggle" href="#"
                                   role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                   v-pre>
                                    <i class="bi bi-person-fill  fsize-28"></i>
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
                            {{--                                    @include('elements.notifications')--}}

                            <li class="nav-item dropdown">
                                <a id="userDropdown" aria-label="Accéder à votre profil"
                                   class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img aria-hidden="true" src="{{Auth::user()->getAvatar(32)}}" alt="" width="32"
                                         height="32">
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

                    <div
                        class="h-100 d-flex align-items-center justify-content-between justify-content-lg-end d-none d-md-flex">
                        <div class="right-bl">
                            @if(theme_config('header.index.link.text'))
                                <a href="{{theme_config('header.index.link.url')}}"
                                   @if(theme_config('header.index.link.href')) target="_blank"
                                   @endif class="btn header-btn ml25 color-white hidden-sm hidden-xs">
                                    {{theme_config('header.index.link.text')}}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="main-menu">
                            <span class="toggle_menu">
                                <span></span>
                            </span>
                    </div>

                </div>

            </div>
        </div>
    </header>
</div>
<!-- HEADER END -->
