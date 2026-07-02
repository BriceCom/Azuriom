<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                    <div class="row gy-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>

                                <label class="form-check-label" for="remember">
                                    {{ trans('auth.remember') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if (Route::has('password.request'))
                                <a class="float-md-end" href="{{ route('password.request') }}">
                                    {{ trans('auth.forgot_password') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary d-block">
                            {{ trans('auth.login') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@push('footer-scripts')
<script>
    @if(isset($errors->messages()['email']) || isset($errors->messages()['password']))
        document.addEventListener('DOMContentLoaded', function() {new bootstrap.Modal(document.querySelector('#exampleModal')).show()});
    @endif
</script>
@endpush
