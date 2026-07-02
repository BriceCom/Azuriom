<section class="z-0 position-relative d-flex align-items-center justify-content-center py-5 pt-md-10 header-bg">
    <div class="header-bg__gradient -z-1 position-absolute top-0 start-0 w-100 h-100"
         style="background: linear-gradient(transparent 0%, var(--di-body-bg) 100%)"></div>
    <div class="hero-cubes -z-2 position-absolute top-0 start-0 w-100 h-100"></div>

    <header class="z-10 position-absolute top-0 end-0 start-0 navbar navbar-expand-lg bg-body-transparent py-3">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-logo" data-animate="navlink-anime">
                <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" height="42" draggable="false">
            </a>

            <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse py-4 py-md-0" id="navbar">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav align-items-center gap-4 mx-auto">
                    @foreach($navbar as $element)
                        @if(!$element->isDropdown())

                            <li class="nav-item" data-animate="navlink-anime">
                                <a class=" d-flex align-items-center gap-2 text-lg ff-main text-uppercase @if(str_contains(strtolower($element->name), strtolower('Boutique'))) btn bg-dark border-2 border-white border-opacity-25 rounded-3 @else nav-link @endif @if($element->isCurrent()) active @endif"
                                   href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank"
                                   rel="noopener noreferrer" @endif>
                                    {{ $element->name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown d-flex" data-animate="navlink-anime">
                                <a class="nav-link ff-main text-uppercase text-lg dropdown-toggle @if($element->isCurrent()) active @endif"
                                   href="#" id="navbarDropdown{{ $element->id }}" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $element->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                    @foreach($element->elements as $childElement)
                                        <a class="dropdown-item @if($childElement->isCurrent()) active @endif"
                                           href="{{ $childElement->getLink() }}"
                                           @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $childElement->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav-join navbar-nav flex-row align-items-center justify-content-center text-center text-md-end ml-auto mt-3 mt-md-0 align-items-center gap-2">
                    @php
                        $discordLinks = social_links()->filter(function($link) {
                            return str_contains($link['value'], 'discord.com');
                        })->first();
                    @endphp

                    <ul class="nav-socials list-unstyled" data-animate="navlink-anime">
                        @include("components.social", ["link" => $discordLinks])
                    </ul>

                    <div data-animate="navlink-anime">
                        @include('components.join-button', ['style' => "primary"])
                    </div>

                </ul>
            </div>
        </div>
    </header>


    <div class="container w-fit text-center pe-none">
            <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" class="z-1 position-relative header-logo mb-1" data-animate="header-logo"
                 height="{{theme_config('header.index.hero.img.height') ?? 184}}" draggable="false">

        <div class="w-fit d-flex flex-column align-items-center mx-auto">
            <div class="mb-4 pe-auto" data-animate="hero-btn" style="height: 41px;">
                @include('components.join-button', ['style' => "special", 'icon' => false])
            </div>

            <small class="-z-1 text-white mb-0 ff-tertiary text-dark text-lg" data-animate="hero-connected">
                <i class="hero-connected me-1"></i>
                <span data-editable="true">
                    @if($servers->where('home_display')->count() > 0)
                        {{theme_config('header.hero.joinText') ?? '{server_online} joueurs en ligne !'}}
                    @endif
                </span>
            </small>
        </div>
    </div>

    <a href="#content" class="position-absolute bottom-0 start-50 pb-4 hero-arrow" data-animate="hero-arrow" style="transform: translateX(-50%)">
        <i class="bi bi-arrow-down-short fs-1 text-dark"></i>
    </a>
</section>
