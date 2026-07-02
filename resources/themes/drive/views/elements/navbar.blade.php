<aside class="drive-sidebar">
    <div class="drive-sidebar__inner">
        @php
            $resolveIcon = function (?string $value): string {
                $value = (string) $value;

                return match (true) {
                    str_contains($value, 'home') => 'bi-house-door',
                    str_contains($value, 'forum') => 'bi-chat-left-text',
                    str_contains($value, 'posts') || str_contains($value, 'news') => 'bi-megaphone',
                    str_contains($value, 'vote') => 'bi-trophy',
                    str_contains($value, 'shop') || str_contains($value, 'tebex') => 'bi-bag',
                    str_contains($value, 'profile') => 'bi-person',
                    default => 'bi-grid',
                };
            };
        @endphp

        <div class="drive-brand-row">
            <a class="drive-brand" href="{{ route('home') }}">
                <img src="{{ site_logo() }}" alt="Logo {{ site_name() }}" width="38" height="38" class="drive-brand__logo">
                <div>
                    <p class="drive-brand__title">{{ site_name() }}</p>
                    <p class="drive-brand__subtitle">Drive Theme</p>
                </div>
            </a>
        </div>

        <nav class="drive-nav">
            @foreach($navbar as $element)
                @php($icon = $resolveIcon($element->value))
                @if(! $element->isDropdown())
                    <a class="drive-nav__link @if($element->isCurrent()) is-active @endif"
                       href="{{ $element->getLink() }}"
                       @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                        <span class="drive-nav__icon">
                            <i class="bi {{ $icon }}"></i>
                        </span>
                        <span class="drive-nav__label">{{ $element->name }}</span>
                    </a>
                @else
                    @php($collapseId = 'drive-menu-'.$element->id)
                    <div class="drive-nav__group">
                        <button class="drive-nav__link @if($element->isCurrent()) is-active @endif"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#{{ $collapseId }}"
                                aria-expanded="{{ $element->isCurrent() ? 'true' : 'false' }}"
                                aria-controls="{{ $collapseId }}">
                            <span class="drive-nav__icon">
                                <i class="bi {{ $icon }}"></i>
                            </span>
                            <span class="drive-nav__label">{{ $element->name }}</span>
                            <i class="bi bi-chevron-down drive-nav__chevron"></i>
                        </button>

                        <div id="{{ $collapseId }}" class="collapse @if($element->isCurrent()) show @endif">
                            <div class="drive-nav__submenu">
                                @foreach($element->elements as $childElement)
                                    <a class="drive-nav__sublink @if($childElement->isCurrent()) is-active @endif"
                                       href="{{ $childElement->getLink() }}"
                                       @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                        <span class="drive-nav__label">{{ $childElement->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </nav>

        <div class="drive-sidebar__footer">
            @auth
                <a href="{{ route('profile.index') }}" class="drive-account-link">
                    <img src="{{ auth()->user()->getAvatar(64) }}" alt="Avatar" width="34" height="34" class="rounded-2">
                    <span>{{ auth()->user()->name }}</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-box-arrow-in-right"></i> <span class="drive-sidebar__footer-label">{{ trans('auth.login') }}</span>
                </a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-person-plus"></i> <span class="drive-sidebar__footer-label">{{ trans('auth.register') }}</span>
                    </a>
                @endif
            @endauth
        </div>
    </div>
</aside>
