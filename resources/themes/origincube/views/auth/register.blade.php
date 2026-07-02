@extends('layouts.app')

@section('title', trans('auth.register'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h1 class="text-start">BIENVENUE SUR {{site_name()}}</h1>
                <p class="fw-normal text-light">Créez un compte et accédez à 100% des fonctionnalités d’{{site_name()}}</p>

                <form method="POST" action="{{ route('register') }}" id="captcha-form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('auth.name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">{{ trans('auth.email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">{{ trans('auth.password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password-confirm">{{ trans('auth.confirm_password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    @if($registerConditions !== null)
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('conditions') is-invalid @enderror" type="checkbox" name="conditions" id="conditions" required @checked(old('conditions'))>

                                <label class="form-check-label" for="conditions">
                                    {{ $registerConditions }}
                                </label>

                                @error('conditions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @include('elements.captcha', ['center' => true])

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            S’inscrire sur {{site_name()}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
