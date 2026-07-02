<nav class="navbar navbar-expand-xl">
    <div class="container position-relative">
        <a class="navbar-brand" href="{{ route('home') }}" style="transform: translate(50%, {{60 + theme_config('header.index.img.marge')??0}}%);">
            <img src="{{site_logo()}}" alt="Logo du site {{site_name()}}" height="{{theme_config('header.index.img.height') ?? 99}}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse py-7 py-xl-0" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto gap-6 list-unstyled">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="nav-link @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if($element->isCurrent()) active @endif" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <ul class="navbar-nav align-items-xl-center gap-6 ml-auto mt-6 mt-xl-0">
                @if(theme_config('header.index.link'))
                    @foreach(theme_config('header.index.link') as $link)
                        @if(!empty($link['text']))
                            <li class="nav-item">
                                <a href="{{ $link['url'] }}" @if(isset($link['newTab'])) rel="noopener noreferrer" target="_blank" @endif class="@if(str_contains(strtolower($link['text']), strtolower('Boutique'))) btn btn-primary py-3 px-5 rounded-3 @else nav-link @endif">{{ $link['text'] }}</a>
                            </li>
                        @endif
                    @endforeach
{{--                @else--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="https://discord.gg/Gh2yBxUWvV" rel="noopener noreferrer" target="_blank" class="nav-link">Discord</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="https://boutique.hypenetwork.fr/" rel="noopener noreferrer" target="_blank" class="btn btn-primary py-3 px-5 rounded-3">Boutique</a>--}}
{{--                    </li>--}}
                @endif
            </ul>
        </div>
    </div>
</nav>
