<nav class="navbar navbar-expand-lg hero-nav shadow-sm">

    {{-- Burger mobile --}}
    <button class="navbar-toggler hero-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="hero-toggler-icon"></span>
        <span class="hero-toggler-icon"></span>
        <span class="hero-toggler-icon"></span>
    </button>

    {{-- Liens + actions dans le collapse --}}
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="hero-nav-links">
            <ul class="navbar-nav">
                @foreach ($navbar as $element)
                    @if (!$element->isDropdown())
                        <li class="nav-item">
                            <a class="nav-link @if ($element->isCurrent()) active @endif"
                               href="{{ $element->getLink() }}"
                               @if ($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                {{ $element->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if ($element->isCurrent()) active @endif"
                               href="#" role="button" data-bs-toggle="dropdown">
                                {{ $element->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($element->elements as $childElement)
                                    <li>
                                        <a class="dropdown-item @if ($childElement->isCurrent()) active @endif"
                                           href="{{ $childElement->getLink() }}"
                                           @if ($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $childElement->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="hero-actions">
            <a href="https://discord.gg/pokecube" class="hero-action-btn discord-btn" title="Discord">
                <i class="fa-brands fa-discord" style="font-size: 18px; color: white;"></i>
            </a>

            <div class="hero-action-btn connexion-btn dropdown">
                @guest
                <div class="connexion-inner" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://mc-heads.net/avatar/steve/32" alt="Steve" class="steve-head">
                    <span>CONNEXION</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                        <path d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <ul class="dropdown-menu connexion-dropdown">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">SE CONNECTER</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">S'INSCRIRE</a></li>
                </ul>
                @else
                <div class="connexion-inner" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://mc-heads.net/avatar/{{ auth()->user()->name }}/32" alt="Steve" class="steve-head">
                    <span>{{ auth()->user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                        <path d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <ul class="dropdown-menu connexion-dropdown">
                    <li><a class="dropdown-item" href="https://store.pokecube.fr">BOUTIQUE</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">DECONNEXION</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @if(Auth::user()->hasAdminAccess())
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">PANEL ADMIN</a></li>
                    @endif
                </ul>
                @endguest
            </div>

            <a href="https://store.pokecube.fr" class="hero-action-btn shop-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7h13L17 13M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" stroke="white" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>BOUTIQUE</span>
            </a>
        </div>
    </div>
</nav>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal">

            <div class="modal-header border-0">
                <h5 class="modal-title">Connexion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form method="POST" action="{{ route('login') }}" id="captcha-form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">Pseudo ou Email</label>
                        <input type="text" name="email" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control modal-input" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 modal-submit-login">
                        Se connecter
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal">

            <div class="modal-header border-0">
                <h5 class="modal-title">Inscription</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form method="POST" action="{{ route('register') }}" id="captcha-form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">Pseudo</label>
                        <input type="text" name="name" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control modal-input" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control modal-input" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 modal-submit-login">
                        S'inscrire
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>