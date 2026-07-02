<div class="navigation">
    <div class="navigation-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 phone-hide" align="center">
                    <strong class="bdg">
                    <i class="bi bi-person"></i> <span class="playercount">0</span>
                </strong> joueurs <strong>en ligne</strong>
                </div>
                <div class="col-md-6" align="center">
                    <div class="d-flex align-items-center gap-2 justify-content-md-end justify-content-center">
                        @guest
                            <a href="/user/login" class="bdg bdg-large" style="margin-right:10px;"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
                            <a href="/user/register" class="bdg bdg-large"><i class="bi bi-person-plus"></i> Inscription</a>
                        @else
                            @if(Auth::user()->hasAdminAccess())
                                <a class="bdg-large" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> {{ trans('messages.nav.admin') }}
                                </a>
                            @endif
                            <a href="/profile" class="bdg bdg-large"><i class="bi bi-person"></i> Profil</a>
                            <a class="bdg bdg-large" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-in-right"></i> {{ trans('auth.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="navigation-links phone-hide">
        @foreach($navbar as $element)
            @if(!$element->isDropdown())
                    <a class=" @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener" @endif>
                        {{ $element->name }}
                    </a>
            @endif
        @endforeach
    </div>
    <div class="navigation-links computer-hide">
        <span onclick="showMenu()"><i class="bi bi-list"></i></span>
        <div id="menuPhone" class="phone-hide">
            @foreach($navbar as $element)
                @if(!$element->isDropdown())
                    <li class="nav-item">
                        <a class="nav-link @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener" @endif>
                            {{ $element->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="background"
{{--     style="background-image: url({{ setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500' }})"--}}
>
{{--    <div id="background"></div>--}}
    <div id="background">
        <img src="{{ setting('background') ? image_url(setting('background')): 'https://via.placeholder.com/2000x500' }}" alt="" fetchpriority="high">
    </div>
    <img class="fadeIn" src="{{ site_logo() }}" loading="lazy" alt="Logo {{ site_logo() }}">
    <div class="filter"></div>
    <div class="custom-shape-divider-bottom-1662665215" id="content">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z" class="shape-fill"></path>
        </svg>
    </div>
</div>
