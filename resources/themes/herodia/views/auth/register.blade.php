@extends('layouts.app')

@section('title', trans('auth.register'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-6">
        <h1>{{ trans('auth.register') }}</h1>
        <br>
        <form method="POST" action="{{ route('register') }}" id="captcha-form">
            @csrf

            <div class="mb-3">
                <div class="input-block">
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder=" " required autocomplete="name" autofocus>
                    <span class="placeholder">
                        {{ trans('auth.name') }}
                    </span>
                </div>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="input-block">
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" placeholder=" " value="{{ old('email') }}" required autocomplete="email">
                    <span class="placeholder">
                        {{ trans('auth.email') }}
                    </span>
                </div>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="input-block">
                <input id="password" type="password" class="@error('password') is-invalid @enderror" placeholder=" " name="password" required autocomplete="new-password">
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

            <div class="mb-3">
                <div class="input-block">
                <input id="password-confirm" type="password" name="password_confirmation" placeholder=" " required autocomplete="new-password">
                    <span class="placeholder">
                        {{ trans('auth.confirm_password') }}
                    </span>
                </div>
            </div>

            @if($conditions !== null)
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input @error('conditions') is-invalid @enderror" type="checkbox" name="conditions" id="conditions" @checked(old('conditions'))>

                        <label class="form-check-label" for="conditions">
                            @lang('auth.conditions', ['url' => $conditions])
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
                    {{ trans('auth.register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
