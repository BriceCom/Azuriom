@extends('layouts.app')

@section('title', trans('messages.profile.title'))

@section('content')
    <div class="text-center">
        <h2>{{theme_config('profile.content.title') ? theme_config('profile.content.title'):trans('messages.profile.title')}}</h2>
        <p>{{theme_config('profile.content.paragraph') ? theme_config('profile.content.paragraph'):'Paramétrez votre compte'}}</p>
    </div>

    <div class="card mb-4 p-4">
        <div class="card-body">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-2 col-md-3 text-center">
                    <img src="{{ $user->getAvatar(150) }}" height="150" width="150" class="img-fluid" alt="Avatar de {{ $user->name }}">
                </div>

                <div class="col-xl-7 col-md-9">
                    <h2>{{ $user->name }}</h2>

                    <ul>
                        <li>{{ trans('messages.profile.info.register', ['date' => format_date($user->created_at, true)]) }}</li>
                        <li>Grade: {{ $user->role->name }}</li>
                        <li>{{ trans('messages.profile.info.money', ['money' => format_money($user->money)]) }}</li>
                        @if($user->game_id)
                            <li>{{ game()->trans('id') }}: {{ $user->game_id }}</li>
                        @endif
                        @if(! oauth_login())
                            <li>{{ trans('messages.profile.info.2fa', ['2fa' => trans_bool($user->hasTwoFactorAuth())]) }}</li>
                        @endif
                    </ul>

                    @if(! oauth_login())
                        @if($user->hasTwoFactorAuth())
                            <a class="btn btn-primary" href="{{ route('profile.2fa.index') }}">
                                <i class="bi bi-shield-lock"></i> {{ trans('messages.profile.2fa.manage') }}
                            </a>
                        @else
                            <a class="btn btn-primary" href="{{ route('profile.2fa.index') }}">
                                <i class="bi bi-shield-lock"></i> {{ trans('messages.profile.2fa.enable') }}
                            </a>
                        @endif

                        @if($canDelete)
                            <a class="btn btn-danger" href="{{ route('profile.delete.index') }}">
                                <i class="bi bi-x-lg"></i> {{ trans('messages.profile.delete.btn') }}
                            </a>
                        @endif
                    @endif
                </div>
                @if(plugins()->isEnabled('shop'))
                    <div class="col-xl-3 col-md-12 text-center mt-2 mt-md-0">
                        <a href="{{route('shop.profile')}}" class="btn btn-primary py-3 px-4">
                            <i class="me-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 15C13.8954 15 13 15.8954 13 17C13 18.1046 13.8954 19 15 19C16.1046 19 17 18.1046 17 17C17 15.8954 16.1046 15 15 15ZM15 15H7.29395C6.83269 15 6.60197 15 6.41211 14.918C6.24466 14.8456 6.09934 14.7288 5.99349 14.5802C5.87348 14.4118 5.82609 14.1863 5.72945 13.7353L3.27148 2.26477C3.17484 1.81376 3.12587 1.58825 3.00586 1.4198C2.90002 1.27123 2.75525 1.15441 2.5878 1.08205C2.39794 1 2.16779 1 1.70653 1H1M4 4H16.8732C17.595 4 17.9557 4 18.1979 4.15036C18.4101 4.28206 18.5652 4.48838 18.6329 4.72876C18.7102 5.00319 18.611 5.34996 18.411 6.04346L17.0264 10.8435C16.9068 11.2581 16.8469 11.4655 16.7256 11.6193C16.6185 11.7551 16.4772 11.8608 16.3171 11.926C16.1356 12 15.9199 12 15.4883 12H5.73047M6 19C4.89543 19 4 18.1046 4 17C4 15.8954 4.89543 15 6 15C7.10457 15 8 15.8954 8 17C8 18.1046 7.10457 19 6 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </i>Voir mes achats</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($user->email !== null && ! $user->hasVerifiedEmail())
        @if (session('resent'))
            <div class="alert alert-success mb-4" role="alert">
                {{ trans('auth.verification.sent') }}
            </div>
        @endif

        <div class="alert alert-warning mb-4" role="alert">
            <p>{{ trans('messages.profile.email_verification') }}</p>
            <p>{{ trans('auth.verification.request') }}</p>

            <form method="POST" action="{{ route('verification.resend') }}" class="text-end">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> {{ trans('auth.verification.resend') }}
                </button>
            </form>
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card p-4">
                <div class="card-body">
                    <h2 class="card-title">
                        {{ trans('messages.profile.change_email') }}
                    </h2>

                    <form action="{{ route('profile.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="emailInput">{{ trans('auth.email') }}</label>
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
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        @endif

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary py-3 px-5 d-inline-flex align-items-center">
                                <i class="bi bi-check-lg"></i>
                                <span class="ms-2">{{ trans('messages.actions.update') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(! oauth_login())
            <div class="col-md-12">
                <div class="card p-4">
                    <div class="card-body">
                        <h2 class="card-title">
                            {{ trans('messages.profile.change_password') }}
                        </h2>

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

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary py-3 px-5 d-inline-flex align-items-center">
                                    <i class="bi bi-check-lg"></i>
                                    <span class="ms-2">{{ trans('messages.actions.update') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if($canChangeName)
                <div class="col-md-12">
                    <div class="card mb-4 p-4">
                        <div class="card-body">
                            <h2 class="card-title">
                                {{ trans('messages.profile.change_name') }}
                            </h2>

                            <form action="{{ route('profile.name') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="nameInput">{{ trans('auth.name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $user->name ?? '') }}" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary py-3 px-5 d-inline-flex align-items-center">
                                        <i class="bi bi-check-lg"></i>
                                        <span class="ms-2">{{ trans('messages.actions.update') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if(setting('users.money_transfer'))
                <div class="col-md-12">
                    <div class="card p-4">
                        <div class="card-body">
                            <h2 class="card-title">
                                {{ trans('messages.profile.money_transfer.title') }}
                            </h2>

                            <form action="{{ route('profile.transfer-money') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="nameInput">{{ trans('auth.name') }}</label>
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

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary py-3 px-5 d-inline-flex align-items-center">
                                        <i class="bi bi-send"></i>
                                        <span class="ms-2">{{ trans('messages.actions.send') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @foreach($cards ?? [] as $card)
            <div class="col-md-12">
                <div class="card p-4">
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
