@props([
    "login" => true
])

@if(plugins()->isEnabled('discord-auth'))
    @guest
        <hr class="oauth-spacer my-4" data-content="{{$login ? trans('theme::theme.or_connect_with') : trans('theme::theme.or_register_with')}}">

        <ul class="list-unstyled d-flex align-items-center justify-content-center">
            <li class="nav-item">
                <a href="{{ route('discord-auth.login') }}" data-bs-toggle="tooltip" target="_blank" rel="noopener noreferrer" title="Discord"
                   class="social d-inline-flex align-items-center justify-content-center text-decoration-none" style="background: #5865F2;">
                    <i aria-hidden="true" class="d-flex bi bi-discord  align-items-center"></i>
                </a>
            </li>
        </ul>
    @endguest
@endif
