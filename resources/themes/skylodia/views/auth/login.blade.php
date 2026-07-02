@extends('layouts.app')

@section('title', trans('auth.login'))

@section('content')
<div class="row justify-content-center">
    <div class="auth-form p-md-0">
        <div class=" card card-bottom-shadow p-2">
            <div class="px-4 py-3 gradient-left-100-dark">
                <h1 class="text-uppercase fs-3 m-0">Se connecter</h1>
            </div>

            <div class="card card-gradient-from-bottom">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('login') }}">
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
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>

                                            <label class="form-check-label" for="remember">
                                                {{ trans('auth.remember') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Se connecter
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    @if(Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none text-white-50">
                                            {{ trans('auth.forgot_password') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 text-center">
                                <img class="w-100" src="{{site_logo()}}" alt="Logo du serveur {{site_name()}}">
                                <span class="d-block mb-2 mt-4">Vous n’avez pas encore de compte ?</span>
                                <a href="/user/register" class="text-warning fw-medium text-decoration-none">INSCRIVEZ-VOUS</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
