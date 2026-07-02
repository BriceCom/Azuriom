<nav class="navbar navbar-expand-md navbar-dark py-2">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ favicon() }}" alt="{{site_name()}}" height="42">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ trans('messages.nav.toggle') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mx-auto list-unstyled">
                @foreach($navbar as $element)
                    @if(!$element->isDropdown())
                        <li class="nav-item">
                            <a class="text-center text-md-start nav-link @if($element->isCurrent()) active @endif" href="{{ $element->getLink() }}" @if($element->new_tab) rel="noopener noreferrer" @endif>
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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-primary px-4 nav-shop" href="{{theme_config('header.shop.url') ?? '#'}}">
                        {{theme_config('header.shop.title') ?? 'Boutique'}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
