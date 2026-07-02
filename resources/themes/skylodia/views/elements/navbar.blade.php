<div class="nav__top">
    <div class="container d-flex align-items-center justify-content-between">
        <button
            class="copyButton d-flex flex-column  bg-transparent cursor-pointer border-0 mb-0"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual"
        >
            <span class="fw-medium">
                    @if($servers)
                    @php
                        $connected = 0
                    @endphp
                    @foreach($servers as $server)
                        @if($server->isOnline())
                            @php
                                $connected += $server->getOnlinePlayers()
                            @endphp
                        @endif
                    @endforeach
                    {{$connected}} Joueurs en ligne
                @else
                    Serveur hors-ligne
                @endif
                </span>
        </button>
        <ul class="navbar-nav d-flex flex-row align-items-center ml-auto">
            <!-- Authentication Links -->
            @guest
                @if(Route::has('register'))
                    <li class="nav-item">
                        <a class="d-flex align-items-center gap-2 nav-auth p-3 text-white fw-medium text-decoration-none" href="{{ route('register') }}">
                            <i>
                                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.5 4.5C4.5 6.981 6.519 9 9 9C11.481 9 13.5 6.981 13.5 4.5C13.5 2.019 11.481 0 9 0C6.519 0 4.5 2.019 4.5 4.5ZM17 19H18V18C18 14.141 14.859 11 11 11H7C3.14 11 0 14.141 0 18V19H17Z" fill="white"/>
                                </svg>
                            </i>
                            {{ trans('auth.register') }}
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="d-flex align-items-center gap-2 nav-auth p-3 text-white fw-medium text-decoration-none" href="{{ route('login') }}">
                        <i>
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.433325 15.325L0.0793249 17.8C0.0574474 17.9536 0.0716203 18.1102 0.120722 18.2574C0.169824 18.4046 0.252507 18.5384 0.362229 18.6481C0.471952 18.7578 0.605703 18.8405 0.752901 18.8896C0.900099 18.9387 1.0567 18.9529 1.21032 18.931L3.68532 18.577C4.06032 18.524 5.00032 16 5.00032 16C5.00032 16 5.47232 16.405 5.66532 16.466C6.07732 16.596 6.47832 16.192 6.61332 15.782L7.00032 14.01C7.00032 14.01 7.57732 14.302 7.78632 14.345C8.05232 14.4 8.31033 14.236 8.49333 14.052C8.60326 13.9424 8.68582 13.8085 8.73433 13.661L9.00033 12.01C9.00033 12.01 9.67533 12.197 9.90633 12.224C10.1693 12.254 10.4253 12.12 10.6133 11.931L11.7513 10.794C12.7146 11.1062 13.7454 11.1464 14.7301 10.9103C15.7148 10.6743 16.6153 10.171 17.3323 9.456C18.362 8.42365 18.9403 7.02508 18.9403 5.567C18.9403 4.10892 18.362 2.71035 17.3323 1.678C16.3 0.648316 14.9014 0.0700684 13.4433 0.0700684C11.9852 0.0700684 10.5867 0.648316 9.55433 1.678C8.83913 2.39493 8.33575 3.29539 8.09966 4.28014C7.86357 5.2649 7.90394 6.29572 8.21632 7.259L0.715325 14.759C0.562218 14.9119 0.463206 15.1107 0.433325 15.325ZM15.5043 3.506C16.0499 4.05317 16.3562 4.79432 16.3562 5.567C16.3562 6.33968 16.0499 7.08083 15.5043 7.628L11.3823 3.506C11.9295 2.96044 12.6706 2.65409 13.4433 2.65409C14.216 2.65409 14.9572 2.96044 15.5043 3.506Z" fill="white"/>
                            </svg>
                        </i>
                        {{ trans('auth.login') }}
                    </a>
                </li>
            @else
{{--                @include('elements.notifications')--}}

                <li class="nav-item dropdown ms-3">
                    <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{Auth::user()->getAvatar(32)}}" alt="Avatar de {{ Auth::user()->name }}" class="rounded-1">
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
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav gap-4 list-unstyled px-5 py-4 px-md-0">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item px-1">
                            <a class="nav-link btn btn-primary py-1 text-white text-uppercase @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown px-1">
                            <a class="nav-link btn btn-primary py-1 text-white text-uppercase dropdown-toggle @if($element->isCurrent()) active @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

            <div class="ms-auto px-5 pb-5 pb-md-0 px-md-0">
                <a href="{{theme_config("header.button.link") ?? "/shop"}}" class="btn btn-primary shop-btn text-uppercase active ms-md-auto mx-auto">
                    {{theme_config("header.button.text") ?? "Boutique"}}
                </a>
            </div>
        </div>
    </div>
</nav>
