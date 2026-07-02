<header class="bg-steel-50 h-[30em] bg-cover"
    style="background-image: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}');">
    <nav class="flex py-5 bg-steel-200/90 border-b-2 border-steel-50/10 backdrop-blur-sm">
        <div class="container mx-auto sm:px-4 px-8 flex items-center justify-between">
            <div class="w-auto">
                <div class="flex md:gap-x-6 gap-x-3">
                    @foreach(social_links() as $link)
                    <a class="group" aria-label="Skyhills sur {{ $link->title }}" href="{{ $link->value }}"
                        target="_blank">
                        <i
                            class="{{ $link->icon }} text-white xl:h-5 xl:w-5 h-5 w-5 fill-white group-hover:text-secondary transition ease-in-out duration-400"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="w-auto">
                <div class="flex flex-wrap gap-6">
                    @guest
                    <ul class="flex w-auto space-x-6 justify-end items-end my-auto">
                        <li><a class="xl:text-sm text-xs text-white font-medium hover:text-secondary cursor-pointer"
                                data-hs-overlay="#login_modal" data-ng="link">Connexion</a></li>
                        <li><a class="xl:text-sm text-xs text-white font-medium hover:text-secondary cursor-pointer"
                                data-hs-overlay="#register_modal" data-ng="link">Inscription</a></li>
                    </ul>
                    @else
                    <div class="hs-dropdown relative inline-flex z-[9999]">
                        <button id="hs-dropdown-with-header"
                            class="hs-dropdown-toggle flex flex-raw group max-w-[120px] overflow-hidden z-[9999] relative">
                            <img class="absolute h-7 rounded-md shadow-xl mx-auto z-50 shadow-xl"
                                src="{{ Auth::user()->getAvatar(150) }}" alt="{{ Auth::user()->name }}">
                            <div class="h-7 w-7 bg-steel-300 flex justify-center items-center rounded-md">
                                <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                            <p class="truncate text-white text-xs my-auto pl-3 pr-3 group-hover:text-secondary">
                                {{ Auth::user()->name }}
                            </p>
                        </button>
                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem] bg-steel-300 shadow-md rounded-lg mt-2"
                            aria-labelledby="hs-dropdown-with-header">
                            <div class="py-3 px-5 bg-steel-200 rounded-t-lg select-none">
                                <p class="text-xs text-white font-medium">connecter en tant que</p>
                                <p class="text-sm font-medium text-steel-50 font-medium">{{
                                    Auth::user()->email }}</p>
                            </div>
                            <div class="divide-y divide-steel-200">
                                <a class="flex items-center py-3 px-3 text-sm text-white hover:bg-steel-100 gap-x-3"
                                    href="{{ route('profile.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm-50.22 116.82C218.45 151.39 236.28 144 256 144s37.39 7.44 50.11 20.94c12.89 13.68 19.16 32.06 17.68 51.82C320.83 256 290.43 288 256 288s-64.89-32-67.79-71.25c-1.47-19.92 4.79-38.36 17.57-51.93zM256 432a175.49 175.49 0 01-126-53.22 122.91 122.91 0 0135.14-33.44C190.63 329 222.89 320 256 320s65.37 9 90.83 25.34A122.87 122.87 0 01382 378.78 175.45 175.45 0 01256 432z" />
                                    </svg>
                                    Mon profil
                                </a>
                                @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                                <a class="flex items-center py-3 px-3 text-sm text-white hover:bg-steel-100 gap-x-3"
                                    href="{{ route($navItem['route']) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5"
                                        viewBox="0 0 512 512">
                                        <circle cx="176" cy="416" r="32" />
                                        <circle cx="400" cy="416" r="32" />
                                        <path
                                            d="M456.8 120.78a23.92 23.92 0 00-18.56-8.78H133.89l-6.13-34.78A16 16 0 00112 64H48a16 16 0 000 32h50.58l45.66 258.78A16 16 0 00160 368h256a16 16 0 000-32H173.42l-5.64-32h241.66A24.07 24.07 0 00433 284.71l28.8-144a24 24 0 00-5-19.93z" />
                                    </svg>
                                    {{ $navItem['name'] }}
                                </a>
                                @endforeach
                                @if(Auth::user()->hasAdminAccess())
                                <a class="flex items-center py-3 px-3 text-sm text-danger hover:bg-steel-100 gap-x-3"
                                    href="{{ route('admin.dashboard') }}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-danger h-5 w-5"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M64 144h226.75a48 48 0 0090.5 0H448a16 16 0 000-32h-66.75a48 48 0 00-90.5 0H64a16 16 0 000 32zM448 368h-66.75a48 48 0 00-90.5 0H64a16 16 0 000 32h226.75a48 48 0 0090.5 0H448a16 16 0 000-32zM448 240H221.25a48 48 0 00-90.5 0H64a16 16 0 000 32h66.75a48 48 0 0090.5 0H448a16 16 0 000-32z" />
                                    </svg>
                                    {{ trans('messages.nav.admin') }}
                                </a>
                                @endif
                                <a class="flex items-center py-3 px-3 text-sm text-white hover:bg-steel-100 gap-x-3 rounded-b-lg"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5"
                                        viewBox="0 0 512 512">
                                        <path xmlns="http://www.w3.org/2000/svg"
                                            d="M160 256a16 16 0 0116-16h144V136c0-32-33.79-56-64-56H104a56.06 56.06 0 00-56 56v240a56.06 56.06 0 0056 56h160a56.06 56.06 0 0056-56V272H176a16 16 0 01-16-16zM459.31 244.69l-80-80a16 16 0 00-22.62 22.62L409.37 240H320v32h89.37l-52.68 52.69a16 16 0 1022.62 22.62l80-80a16 16 0 000-22.62z" />
                                    </svg>
                                    {{ trans('auth.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <nav class="h-28 bg-steel-300/90 flex justify-center items-center border-b-2 border-steel-50/10">
        <div class="container mx-auto sm:px-4 px-8 flex items-center">
            <div
                class="lg:absolute xl:top-28 top-20 lg:left-1/2 lg:transform lg:-translate-y-1/2 lg:-translate-x-1/2 z-0">
                <a class="text-white text-3xl font-bold leading-none" href="{{ route('home') }}" data-config-id="brand">
                    @if(setting('logo'))
                    <img class="xl:h-64 lg:h-56 h-16 hover:scale-105 transition duration-200"
                        src="{{ image_url(setting('logo')) }}" alt="Logo" width="auto">
                    @else
                    {{ site_name() }}
                    @endif
                </a>
            </div>
            <ul class="hidden lg:flex lg:w-auto xl:space-x-8 lg:space-x-2 justify-start items-start z-50">
                @foreach ($navbar as $element)
                @if ($loop->index < $loop->count / 2)
                    @if (!$element->isDropdown())
                    <li>
                        <a class="xl:text-sm text-xs uppercase font-medium xl:px-6 xl:py-3 px-5 py-2.5 hover:bg-steel-50/10 rounded-xl transition ease-in-out duration-400 @if ($element->isCurrent()) text-secondary @else text-white @endif"
                            href="{{ $element->getLink() }}" @if ($element->new_tab) target="_blank" rel="noopener
                            noreferrer" @endif data-ng="link">
                            {{ $element->name }}
                        </a>
                    </li>
                    @else
                    <li class="dropdown">
                        <a class="xl:text-sm text-xs uppercase font-medium xl:px-6 xl:py-3 px-5 py-2.5 hover:bg-steel-50/10 rounded-xl transition ease-in-out duration-400 dropdown-toggle"
                            href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="{{ $element->icon }} me-2"></i>
                            {{ Str::replace('<i class="'.$element->icon.'"></i>','',$element->getRawNameAttribute()) }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                            @foreach ($element->elements as $childElement)
                            <a class="dropdown-item @if ($childElement->isCurrent()) active @endif"
                                href="{{ $childElement->getLink() }}" @if ($childElement->new_tab) target="_blank"
                                rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    @endif
                    @endif
                    @endforeach
            </ul>
            <div class="hidden lg:ml-auto lg:block lg:w-1/3 text-right">
                <ul class="hidden lg:flex lg:w-auto xl:space-x-8 lg:space-x-2 justify-end items-end z-50">
                    @foreach ($navbar as $element)
                    @if ($loop->index >= $loop->count / 2)
                    @if (!$element->isDropdown())
                    <li>
                        <a class="xl:text-sm text-xs uppercase font-medium xl:px-6 xl:py-3 px-5 py-2.5 hover:bg-steel-50/10 rounded-xl transition ease-in-out duration-400 @if ($element->isCurrent()) text-secondary @else text-white @endif"
                            href="{{ $element->getLink() }}" @if ($element->new_tab) target="_blank" rel="noopener
                            noreferrer" @endif data-ng="link">{{
                            $element->name }}
                        </a>
                    </li>
                    @else
                    <li class="dropdown">
                        <a class="xl:text-sm text-xs uppercase font-medium xl:px-6 xl:py-3 px-5 py-2.5 hover:bg-steel-50/10 rounded-xl transition ease-in-out duration-400 dropdown-toggle"
                            href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="{{ $element->icon }} me-2"></i>
                            {{ Str::replace('<i class="'.$element->icon.'"></i>','',$element->getRawNameAttribute()) }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                            @foreach ($element->elements as $childElement)
                            <a class="dropdown-item @if ($childElement->isCurrent()) active @endif"
                                href="{{ $childElement->getLink() }}" @if ($childElement->new_tab) target="_blank"
                                rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    @endif
                    @endif
                    @endforeach
                </ul>
            </div>
            <div class="lg:hidden ml-auto">
                <button class="navbar-burger flex items-center text-white p-3" data-hs-overlay="#navbar-burger">
                    <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu pour mobile</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    <nav class="hs-overlay bg-steel-300/50 p-8 lg:hidden flex flex-col h-full [--overlay-backdrop:false] [--body-scroll:true] hidden"
        id="navbar-burger">
        <ul class="gap-4">
            @foreach ($navbar as $element)
            <li><a class="text-xs uppercase font-medium transition ease-in-out duration-400 @if ($element->isCurrent()) text-secondary @else text-white @endif"
                    href="{{ $element->getLink() }}" @if ($element->new_tab) target="_blank" rel="noopener
                    noreferrer" @endif
                    data-ng="link">{{ $element->name }}</a></li>
            @endforeach
        </ul>
    </nav>
    @guest
    @include('elements.auth.login_modal')
    @include('elements.auth.register_modal')
    @include('elements.auth.forgot_modal')
    @endguest
</header>
