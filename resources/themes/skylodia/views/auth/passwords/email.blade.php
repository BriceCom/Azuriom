@extends('layouts.app')

@section('title', trans('auth.passwords.reset'))

@section('content')
    <div class="row justify-content-center">
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class=" card card-bottom-shadow p-2">
            <div class="px-4 py-3 gradient-left-100-dark">
                <h1 class="text-uppercase fs-3 m-0">Réinitialiser votre mot de passe</h1>
            </div>

            <div class="card card-gradient-from-bottom">
                <div class="p-3">
                    <div class="row align-items-md-center">
                        <div>
                            <form method="POST" action="{{ route('password.email') }}" id="captcha-form">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ trans('auth.email') }}</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>

                                @include('elements.captcha', ['center' => true])

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('auth.passwords.send') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
