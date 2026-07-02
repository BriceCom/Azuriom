<div class="modal fade" id="loginModal"  tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModal">Se connecter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="monFormulaire" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">{{ trans('auth.email') }}</label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">{{ trans('auth.password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>

                                <label class="form-check-label" for="remember">
                                    {{ trans('auth.remember') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 align-items-md-center text-start mt-4">
                        <button type="submit" class="d-block btn btn-primary">
                            Se connecter
                        </button>

                        <a href="{{theme_config('settings.discord.link') ?? "#"}}" class="text-sm" target="_blank">
                            {{ trans('auth.forgot_password') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>
        @if(isset($errors->messages()['email']) && !isset($errors->messages()['password']))
            document.addEventListener('DOMContentLoaded', function() {new bootstrap.Modal(document.querySelector('#loginModal')).show()});
        @endif
    </script>
@endpush
