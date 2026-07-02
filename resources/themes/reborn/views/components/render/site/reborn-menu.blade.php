@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $style = trim((string) ($settings['style'] ?? 'pills'));
    $uppercase = (bool) ($settings['uppercase'] ?? false);

    if (!isset($navbar)) {
        $rebornNavbarElements = \Illuminate\Support\Facades\Cache::get(\Azuriom\Models\NavbarElement::CACHE_KEY, function () {
            return \Azuriom\Models\NavbarElement::query()
                ->orderBy('position')
                ->with('roles')
                ->get();
        });

        if ($rebornNavbarElements instanceof \Illuminate\Database\Eloquent\Collection) {
            \Illuminate\Support\Facades\Cache::put(\Azuriom\Models\NavbarElement::CACHE_KEY, $rebornNavbarElements->toArray(), now()->addDay());
        } else {
            $rebornNavbarElements = \Azuriom\Models\NavbarElement::hydrate($rebornNavbarElements)->each(function (\Azuriom\Models\NavbarElement $rebornElement) {
                $rebornElement->setRelation('roles', \Azuriom\Models\Role::hydrate($rebornElement->roles));
                $rebornElement->setRawAttributes(\Illuminate\Support\Arr::except($rebornElement->getAttributes(), 'roles'), true);
            });
        }

        $rebornNavbarElements = $rebornNavbarElements
            ->filter(fn (\Azuriom\Models\NavbarElement $rebornElement) => $rebornElement->hasPermission());

        $navbar = $rebornNavbarElements->whereNull('parent_id');

        foreach ($navbar as $rebornParentElement) {
            if (! $rebornParentElement->isDropdown()) {
                $rebornParentElement->setRelation('elements', collect());
                continue;
            }

            $rebornParentElement->setRelation('elements', $rebornNavbarElements->where('parent_id', $rebornParentElement->id));
        }
    }
@endphp

<nav class="reborn-header-menu reborn-menu-{{ in_array($style, ['minimal', 'underline', 'pills'], true) ? $style : 'pills' }}">
    <ul class="navbar-nav">
        @foreach($navbar as $element)
            @if(!$element->isDropdown())
                <li class="nav-item">
                    <a class="nav-link @if($element->isCurrent()) active @endif @if($uppercase) text-uppercase @endif"
                       href="{{ $element->getLink() }}"
                       @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                        {{ $element->name }}
                    </a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if($element->isCurrent()) active @endif @if($uppercase) text-uppercase @endif"
                       href="#" id="rebornNavbarDropdown{{ $element->id }}"
                       role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        {{ $element->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="rebornNavbarDropdown{{ $element->id }}">
                        @foreach($element->elements as $childElement)
                            <li>
                                <a class="dropdown-item @if($childElement->isCurrent()) active @endif"
                                   href="{{ $childElement->getLink() }}"
                                   @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $childElement->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
