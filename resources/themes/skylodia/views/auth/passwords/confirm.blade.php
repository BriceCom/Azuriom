@extends('layouts.app')

@section('title', trans('auth.passwords.confirm'))

@section('content')

    <div class="row justify-content-center">
$        <div class=" card card-bottom-shadow p-2">
            <div class="px-4 py-3 gradient-left-100-dark">
                <h1 class="text-uppercase fs-3 m-0">{{ trans('auth.passwords.confirm') }}</h1>
            </div>

            <div class="card card-gradient-from-bottom">
                <div class="p-3">
                    <div class="row align-items-md-center">
                        <div>
                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="password">{{ trans('auth.password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('auth.passwords.confirm') }}
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('password.request') }}">
                                        {{ trans('auth.forgot_password') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
