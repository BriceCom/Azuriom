@extends('layouts.app')

@section('title', trans('messages.profile.title'))

@section('content')
    <div class="row justify-content-center px-3 px-md-0">
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card card-bottom-shadow p-2">
            <div class="card card-gradient-from-bottom pb-4">
                <div>
                    <div class="row align-items-md-center">
                        <div class="container-fluid">
                            <div class="row mx-1">
                                <div class="profile-header d-flex justify-content-between align-items-center mb-3 p-0 py-3 mx-0">
                                    <div class="d-flex align-items-center gap-4 px-6">
                                        <div class="profil-img-small">
                                            <img src="https://mc-heads.net/player/{{$user->name}}" height="100" alt="Avatar de {{$user->name}}">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-row align-items-center gap-2">
                                                <span class="h3 mb-0 text-white fw-semibold h4">{{$user->name}}</span>
                                                <span class="badge fw-light text-uppercase" style="{{ $user->role->getBadgeStyle() }}; vertical-align: middle">{{ $user->role->name }}</span>
                                            </div>
                                            <p class="mb-0">{{$user->email}}</p>
                                        </div>
                                    </div>

                                    <span class="px-4">
                                        {{ format_money($user->money)}}
                                    </span>
                                </div>

                                <div class="col-md-3">
                                    <div class="profil-img text-center">
                                        <img src="https://mc-heads.net/body/{{ $user->name }}" class="rounded mb-3 img-fluid" alt="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="username">Pseudonyme</label>
                                            <input type="text" class="form-control" name="username" value="{{ $user->name }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="username">Mail</label>
                                            <input type="text" class="form-control" name="username" value="{{ $user->email }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="username">Date</label>
                                            <input type="text" class="form-control" name="username" value="la date" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="username">Argent</label>
                                            <input type="text" class="form-control" name="username" value="{{$user->money}}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="username">Grade</label>
                                            <input type="text" class="form-control" name="username" value="{{$user->role->name}}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="username">Langue</label>
                                            <input type="text" class="form-control" name="username" value="Français" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5 mt-2"/>
                        <div>
                            <div class="row align-items-center justify-content-between px-5">
                                <div class="col-md-3">
                                    <h3 class="text-uppercase fw-normal">Changer mon <b class="fw-semibold">adresse email</b></h3>
                                    <p class="m-0">Modifez votre adresse email actuelle et remplacez la facilement par une nouvelle.</p>
                                </div>
                                <div class="col-md-8">
                                        <form action="{{ route('profile.email') }}" method="POST">
                                            @csrf

                                            <div class="d-flex gap-4 align-items-center">
                                                <div class="w-100 mb-3">
                                                    <label class="form-label" for="emailInput">{{ trans('auth.email') }}</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" name="email" value="{{ old('email', $user->email ?? '') }}" required>

                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>

                                                @if(! oauth_login())
                                                    <div class="w-100 mb-3">
                                                        <label class="form-label" for="emailConfirmPassInput">{{ trans('auth.current_password') }}</label>
                                                        <input type="password" class="form-control @error('email_confirm_pass') is-invalid @enderror" id="emailConfirmPassInput" name="email_confirm_pass" required>

                                                        @error('email_confirm_pass')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                @endif
                                            </div>

                                            <button type="submit" class="w-100 btn btn-primary text-uppercase">
                                                Changer l'adresse mail
                                            </button>
                                        </form>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5"/>
                        @if(! oauth_login())
                        <div>
                            <div class="row align-items-center justify-content-between px-5">
                                <div class="col-md-3">
                                    <h3 class="text-uppercase fw-normal">Changer mon <b class="fw-semibold">mot de passe</b></h3>
                                    <p class="m-0">Modifiez facilement votre mot de passe actuel et remplacez le par un nouveau plus sécurisé.</p>
                                </div>
                                <div class="col-md-8">
                                    <form action="{{ route('profile.password') }}" method="POST" class="row align-items-center justify-content-between px-3">
                                        @csrf

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="passwordConfirmPassInput">{{ trans('auth.current_password') }}</label>
                                            <input type="password" class="form-control @error('password_confirm_pass') is-invalid @enderror" id="passwordConfirmPassInput" name="password_confirm_pass" required>

                                            @error('password_confirm_pass')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="passwordInput">{{ trans('auth.password') }}</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="passwordInput" name="password" required>

                                            @error('password')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="confirmPasswordInput">{{ trans('auth.confirm_password') }}</label>
                                            <input type="password" class="form-control" id="confirmPasswordInput" name="password_confirmation" required>
                                        </div>

                                        <div class="col-md-6 ">
                                            <button type="submit" class="w-100 btn btn-primary">
                                                Mettre à jour
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <hr class="my-5"/>

                        @if(! oauth_login())
                            <div class="row align-items-center justify-content-between px-6">
                                <div class="col-md-3">
                                    <h3 class="fw-normal">Authentification à <b class="fw-semibold">deux facteurs</b></h3>
                                    <p class="m-0">Activez l’authentification à deux facteurs pour sécuriser votre compte.</p>
                                    <span>Actif: {{trans_bool($user->hasTwoFactorAuth())}}</span>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        @if(! oauth_login())
                                            @if($user->hasTwoFactorAuth())
                                                <a class="d-block btn btn-primary" href="{{ route('profile.2fa.index') }}">
                                                    {{ trans('messages.profile.2fa.manage') }}
                                                </a>
                                            @else
                                                <a class="d-block btn btn-primary" href="{{ route('profile.2fa.index') }}">
                                                    {{ trans('messages.profile.2fa.enable') }}
                                                </a>
                                            @endif

                                            @if($canDelete)
                                                <a class="d-block btn btn-danger mt-4" href="{{ route('profile.delete.index') }}">
                                                    {{ trans('messages.profile.delete.btn') }}
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($canVerifyEmail)
                            <hr class="my-5"/>
                            <div class="row align-items-center justify-content-between px-6">
                                <div class="col-md-3">
                                    <h3>Verification e-mail</h3>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        @if(session('resent'))
                                            <div class="alert alert-success mb-4" role="alert">
                                                {{ trans('auth.verification.sent') }}
                                            </div>
                                        @endif

                                        <p>{{ trans('messages.profile.email_verification') }}</p>
                                        <p>{{ trans('auth.verification.request') }}</p>

                                        <form method="POST" action="{{ route('verification.resend') }}">
                                            @csrf
                                            <button type="submit" class="w-100 btn btn-primary">
                                                <i class="bi bi-send"></i> {{ trans('auth.verification.resend') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($canChangeName)
                            <hr class="my-5"/>
                            <div class="row align-items-center justify-content-between px-6">
                                <div class="col-md-3">
                                    <h3>Changement de pseudo</h3>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <form action="{{ route('profile.name') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label" for="nameInput">{{ trans('auth.name') }}</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $user->name ?? '') }}" required>

                                                @error('name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="w-100 btn btn-primary">
                                                <i class="bi bi-check-lg"></i> {{ trans('messages.actions.update') }}
                                            </button>
                                        </form>
                                </div>
                            </div>
                        @endif

                        @if(setting('users.money_transfer'))
                            <hr class="my-5"/>
                            <div class="row align-items-center justify-content-between px-6">
                                <div class="col-md-3">
                                    <h3>Transfert d'argent</h3>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <form action="{{ route('profile.transfer-money') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label" for="nameInput">{{ game()->userPrimaryAttributeName() }}</label>
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
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

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
