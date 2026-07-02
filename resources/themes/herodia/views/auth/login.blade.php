@extends('layouts.app')

@section('title', trans('auth.login'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-6">
        <h1>{{ trans('auth.login') }}</h1>
        <br>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
                <div class="input-block">
                <input id="email" type="text" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder=" " required autocomplete="email" autofocus>
                    <span class="placeholder">
                        {{ trans('auth.email') }}
                    </span>
                </div>

                
            </div>

            <div class="mb-3">
                <div class="input-block">
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" placeholder=" " required autocomplete="current-password">
                    <span class="placeholder">
                        {{ trans('auth.password') }}
                    </span>
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row gy-3 mb-3">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" placeholder=" " @checked(old('remember'))>

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
</div>
@endsection
