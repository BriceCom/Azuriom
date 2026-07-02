@extends('layouts.app')

@section('title', trans('messages.profile.title'))

@section('content')
    <div class="pageTitle">
        <h1>VOTRE PROFIL</h1>
        <p class="fw-normal text-light">Accédez à vos informations à partir de cette page.</p>
    </div>


    <div class="card pb-0 mb-4 mb-md-8">
        <div class="card-body pb-0 pt-5">
            <div class="row align-items-end">
                <div class="col-xl-2 col-md-3 text-center overflow-hidden" style="height: 176px;">
                    <img src="https://mc-heads.net/body/{{$user->name}}.png" class="rounded mb-3" alt="{{ $user->name }}" height="274">
                </div>

                <div class="d-flex flex-column flex-lg-row align-items-center align-items-md-end flex-grow-1 col-lx-10 col-md-9 pb-4 gap-5 mt-4 mt-md-0">
                    <div>
                        <h2 class="text-capitalize profile-name">{{ $user->name }} <span class="badge fw-normal text-capitalize" style="{{ $user->role->getBadgeStyle() }}; vertical-align: middle">{{ $user->role->name }}</span></h2>

                        <ul class="list-unstyled text-light">
                            <li><span class="fw-bold">Date d'inscription :</span> {{format_date($user->created_at)}}</li>
                            <li><span class="fw-bold">Points boutique :</span> {{format_money($user->money)}}s</li>
                            @if($user->game_id)
                                <li><span class="fw-bold">UUID :</span>{{ $user->game_id }}</li>
                            @endif
                            @if(! oauth_login())
                                <li><span class="fw-bold">Authentification à double facteur : </span> {{ trans_bool($user->hasTwoFactorAuth())  }}</li>
                            @endif
                        </ul>
                    </div>

                    <div class="d-flex gap-1 flex-wrap justify-content-md-end justify-content-center text-end text-uppercase fw-light flex-grow-1 text-center text-lg-end">
                        @if(! oauth_login())
                            @if($user->hasTwoFactorAuth())
                                <a class="btn btn-primary" href="{{ route('profile.2fa.index') }}">
                                     {{ trans('messages.profile.2fa.manage') }}
                                </a>
                            @else
                                <a class="btn btn-primary" href="{{ route('profile.2fa.index') }}">
                                    ACTIVER LA DOUBLE AUTHENTIFICATION
                                </a>
                            @endif

                            @if($canDelete)
                                <a class="btn btn-danger" href="{{ route('profile.delete.index') }}">
                                   {{ trans('messages.profile.delete.btn') }}
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($user->email !== null && ! $user->hasVerifiedEmail())
        @if (session('resent'))
            <div class="alert alert-success mb-4" role="alert">
                {{ trans('auth.verification.sent') }}
            </div>
        @endif

        <div class="alert alert-warning mb-4 mb-md-8" role="alert">
            <p>{{ trans('messages.profile.email_verification') }}</p>
            <p>{{ trans('auth.verification.request') }}</p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> {{ trans('auth.verification.resend') }}
                </button>
            </form>
        </div>
    @endif

    <div class="row gy-4 gy-md-8 gx-5">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">
                        CHANGER L’ADRESSE E-MAIL
                    </h2>
                    <p class="fw-normal text-light">Vous pouvez modifier votre adresse e-mail ci-dessous</p>

                    <form action="{{ route('profile.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="emailInput">Adresse e-mail actuelle</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" name="email" value="{{ old('email', $user->email ?? '') }}" required>

                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        @if(! oauth_login())
                            <div class="mb-3">
                                <label class="form-label" for="emailConfirmPassInput">{{ trans('auth.current_password') }}</label>
                                <input type="password" class="form-control @error('email_confirm_pass') is-invalid @enderror" id="emailConfirmPassInput" name="email_confirm_pass" required>

                                @error('email_confirm_pass')
                                <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            Modifier mon adresse e-mail
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(! oauth_login())
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">
                            CHANGER DE MOT DE PASSE
                        </h2>
                        <p class="fw-normal text-light">Vous pouvez modifier votre mot de passe ci-dessous</p>

                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="passwordConfirmPassInput">{{ trans('auth.current_password') }}</label>
                                <input type="password" class="form-control @error('password_confirm_pass') is-invalid @enderror" id="passwordConfirmPassInput" name="password_confirm_pass" required>

                                @error('password_confirm_pass')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="passwordInput">{{ trans('auth.password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="passwordInput" name="password" required>

                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="confirmPasswordInput">{{ trans('auth.confirm_password') }}</label>
                                <input type="password" class="form-control" id="confirmPasswordInput" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Modifier mon mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if($canChangeName)
                <div class="col-md-6">
                    <div class="card h-100 mb-4">
                        <div class="card-body">
                            <h2 class="card-title">
                                CHANGER DE PSEUDONYME
                            </h2>
                            <p class="fw-normal text-light">Vous pouvez modifier votre pseudonyme ci-dessous</p>

                            <form action="{{ route('profile.name') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="nameInput">Nouveau pseudonyme</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $user->name ?? '') }}" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Modifier mon pseudonyme
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if(setting('users.money_transfer'))
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">
                                {{ trans('messages.profile.money_transfer.title') }}
                            </h2>

                            <form action="{{ route('profile.transfer-money') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="nameInput">Pseudonyme</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name') }}" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="moneyInput">{{ trans('messages.fields.money') }}</label>
                                    <input type="number" placeholder="0.00" min="0" step="0.01" class="form-control @error('money') is-invalid @enderror" id="moneyInput" name="money" value="{{ old('money') }}" required>

                                    @error('money')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> {{ trans('messages.actions.send') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @foreach($cards ?? [] as $card)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">
                            {{ $card['name'] }}
                        </h2>

                        @include($card['view'])
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
