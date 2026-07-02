@extends('layouts.app')

@section('title', trans('messages.profile.2fa.title'))

@section('content')
    <div class="row justify-content-center">
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class=" card card-bottom-shadow p-2">
            <div class="px-4 py-3 gradient-left-100-dark">
                <h1 class="text-uppercase fs-3 m-0">AUTHENTIFICATION À DEUX FACTEURS</h1>
                <p class="text-white-50 opacity-50 fw-medium m-0">Clé secrète : {{ $secret }}</p>
            </div>

            <div class="card card-gradient-from-bottom">
                <div class="p-3">
                    <div class="row align-items-md-center">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('profile.2fa.enable') }}">
                                @csrf

                                <input type="hidden" name="2fa_key" value="{{ $secret }}">

                                <div class="mb-3">
                                    <label class="form-label" for="codeInput">{{ trans('messages.profile.2fa.code') }}</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror " id="codeInput" name="code" placeholder="123 456">

                                    @error('code')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <a class="d-block text-center text-decoration-none" href="{{ route('profile.index') }}">
                                    {{ trans('messages.actions.cancel') }}
                                </a>

                                <button type="submit" class="w-100 btn btn-primary">
                                   {{ trans('messages.actions.enable') }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 text-center ">
                            <div>
                                {{ $qrCode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
