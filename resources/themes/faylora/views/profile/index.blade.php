@extends('layouts.base')

@section('title', trans('messages.profile.title'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto md:grid grid-cols-12 gap-8">
        <div class="w-full col-span-12 flex flex-col gap-6">
            @if(session('success'))
            <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="flex w-full py-4 px-5 bg-danger rounded-2xl text-white text-sm justify-between" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div id="status-message"></div>

            @if($user->email !== null && ! $user->hasVerifiedEmail())
            @if (session('resent'))
            <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between" role="alert">
                {{ trans('auth.verification.sent') }}
            </div>
            @endif
            <div class="flex w-full py-4 px-5 bg-primary rounded-2xl text-white text-sm justify-between">
                <div class="text-sm font-medium my-auto truncate">
                    {{ trans('messages.profile.email_verification') }}
                </div>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="bg-white/20 rounded-lg py-2 px-4 truncate" data-ripple-dark="true">
                        {{ trans('auth.verification.resend') }}
                    </button>
                </form>
            </div>
            @endif
            <div class="flex flex-raw items-center justify-between py-6 px-8 bg-steel-200 rounded-2xl overflow-hidden">
                <div class="flex justify-center items-center w-auto overflow-hidden">
                    <div>
                        <img class="absolute h-10 rounded-lg shadow-xl mx-auto z-50" src="{{ $user->getAvatar(150) }}">
                        <div class="h-10 w-10 bg-steel-300 flex justify-center items-center rounded-lg">
                            <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-full mr-4 text-ellipsis truncate">
                        <h4 class="text-white font-semibold text-xs">{{ $user->name }}</h4>
                        <p class="text-xs text-white font-medium py-1 px-1.5 rounded-md mt-0.5 truncate"
                            style="{{ $user->role->getBadgeStyle() }}; vertical-align: middle">
                            {{ $user->role->name }}</p>
                    </div>
                </div>
                <div>
                    <div
                        class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-12 pl-5 pr-3 text-white">
                        <p class="text-white text-sm font-semibold mr-2">{{ $user->money }}</p>
                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2">
                    </div>
                </div>
            </div>
            <div class="bg-steel-100 rounded-2xl">
                <div
                    class="flex flex-raw items-center justify-between py-6 px-6 bg-steel-200 rounded-t-2xl overflow-hidden">
                    <div class="flex justify-center items-center w-auto overflow-hidden gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white md:h-7 md:w-7 h-6 w-6"
                            viewBox="0 0 512 512">
                            <path
                                d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm-50.22 116.82C218.45 151.39 236.28 144 256 144s37.39 7.44 50.11 20.94c12.89 13.68 19.16 32.06 17.68 51.82C320.83 256 290.43 288 256 288s-64.89-32-67.79-71.25c-1.47-19.92 4.79-38.36 17.57-51.93zM256 432a175.49 175.49 0 01-126-53.22 122.91 122.91 0 0135.14-33.44C190.63 329 222.89 320 256 320s65.37 9 90.83 25.34A122.87 122.87 0 01382 378.78 175.45 175.45 0 01256 432z">
                            </path>
                        </svg>
                        <div class="w-full text-ellipsis truncate">
                            <h4 class="text-white font-medium truncate md:text-sm text-xs">Information du compte</h4>
                        </div>
                    </div>
                </div>
                <div class="p-16 gap-6 grid md:grid-cols-2 grid-cols-1">
                    <div class="flex flex-col justify-center items-center md:-mb-16">
                        <div>
                            <p
                                class="inline-flex text-xs text-white font-medium py-1 px-1.5 bg-steel-300 rounded-md mt-0.5 truncate">
                                {{ $user->name }}</p>
                            <p class="inline-flex text-xs text-white font-medium py-1 px-1.5 rounded-md mt-0.5 truncate"
                                style="{{ $user->role->getBadgeStyle() }}; vertical-align: middle">
                                {{ $user->role->name }}</p>
                        </div>
                        <img id="minecraft-skin" class="mt-4 h-44" alt=""
                            src="{{ theme_asset('img/player_skin.png') }}">
                        <div id="player-name" class="hidden">{{ $user->name }}</div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <ul class="list-disc text-white lg:text-sm text-xs space-y-3 ">
                            <li>{{ trans('messages.profile.info.register', ['date' => format_date($user->created_at,
                                true)]) }}</li>
                            <li>{{ trans('messages.profile.info.money', ['money' => format_money($user->money)]) }}</li>
                            @if($user->game_id)
                            <li>{{ game()->trans('id') }}: {{ $user->game_id }}</li>
                            @endif
                            @if(! oauth_login())
                            <li>{{ trans('messages.profile.info.2fa', ['2fa' => trans_bool($user->hasTwoFactorAuth())])
                                }}</li>
                            @endif
                        </ul>

                        @if(! oauth_login())
                        @if($user->hasTwoFactorAuth())
                        <a class="w-64 py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate mt-5"
                            data-ripple-dark="true" href="{{ route('profile.2fa.index') }}">
                            {{ trans('messages.profile.2fa.manage') }}
                        </a>
                        @else
                        <a class="w-64 py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-xs truncate mt-5"
                            data-ripple-dark="true" href="{{ route('profile.2fa.index') }}">
                            {{ trans('messages.profile.2fa.enable') }}
                        </a>
                        @endif

                        @if($canDelete)
                        <a class="btn btn-danger" href="{{ route('profile.delete.index') }}">
                            <i class="bi bi-x-lg"></i> {{ trans('messages.profile.delete.btn') }}
                        </a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                @if(! oauth_login())
                <div class="bg-steel-200 rounded-2xl">
                    <div
                        class="flex flex-raw items-center justify-between py-6 px-6 bg-steel-100 rounded-t-2xl overflow-hidden">
                        <div class="flex justify-center items-center w-auto overflow-hidden gap-2">
                            <svg class="fill-white h-6 w-6" width="61" height="48" viewBox="0 0 61 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M36 20.9434H34V11.4237C34 8.39391 32.7357 5.48826 30.4853 3.34591C28.2348 1.20356 25.1826 0 22 0C18.8174 0 15.7652 1.20356 13.5147 3.34591C11.2643 5.48826 10 8.39391 10 11.4237V20.9434H8C5.87898 20.9456 3.84549 21.7486 2.3457 23.1764C0.845915 24.6042 0.00231607 26.54 0 28.5591V49.5025C0.00231607 51.5216 0.845915 53.4575 2.3457 54.8852C3.84549 56.313 5.87898 57.1161 8 57.1183H36C38.121 57.1161 40.1545 56.313 41.6543 54.8852C43.1541 53.4575 43.9977 51.5216 44 49.5025V28.5591C43.9977 26.54 43.1541 24.6042 41.6543 23.1764C40.1545 21.7486 38.121 20.9456 36 20.9434ZM30 20.9434H14V11.4237C14 9.40382 14.8429 7.46672 16.3431 6.03849C17.8434 4.61026 19.8783 3.80788 22 3.80788C24.1217 3.80788 26.1566 4.61026 27.6569 6.03849C29.1571 7.46672 30 9.40382 30 11.4237V20.9434Z"
                                    fill="white" />
                            </svg>
                            <div class="w-full text-ellipsis truncate">
                                <h4 class="text-white font-medium truncate md:text-sm text-xs">{{
                                    trans('messages.profile.change_password') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <form action="{{ route('profile.password') }}" method="POST"
                            class="bg-steel-200 flex flex-col gap-8">
                            @csrf

                            <div class="relative bg-inherit">
                                <input type="password" id="passwordConfirmPassInput" name="password_confirm_pass"
                                    minlength="4" maxlength="128" placeholder="{{ trans('auth.current_password') }}"
                                    class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-white focus:outline-none font-display font-medium text-sm border transition duration-300 @error('password_confirm_pass') is-invalid @enderror"
                                    required="">
                                <label for="passwordConfirmPassInput"
                                    class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white peer-focus:text-sm transition-all font-display font-medium select-none">{{
                                    trans('auth.current_password') }}</label>

                                @error('password_confirm_pass')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative bg-inherit">
                                <input type="password" id="password" name="password" maxlength="128"
                                    placeholder="{{ trans('auth.password') }}"
                                    class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-white focus:outline-none font-display font-medium text-sm border transition duration-300 @error('password') is-invalid @enderror"
                                    required="">
                                <label for="password"
                                    class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white peer-focus:text-sm transition-all font-display font-medium select-none">{{
                                    trans('auth.password') }}</label>

                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="relative bg-inherit">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    maxlength="128" placeholder="{{ trans('auth.confirm_password') }}"
                                    class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-white focus:outline-none font-display font-medium text-sm border transition duration-300"
                                    required="">
                                <label for="password_confirmation"
                                    class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white peer-focus:text-sm transition-all font-display font-medium select-none">{{
                                    trans('auth.confirm_password') }}</label>
                            </div>
                            <button type="submit" class="bg-steel-100 px-3 py-4 rounded-xl text-white h-14 text-sm"
                                data-ripple-dark="true">
                                {{ trans('messages.actions.update') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                <div class="bg-steel-200 rounded-2xl">
                    <div
                        class="flex flex-raw items-center justify-between py-6 px-6 bg-steel-100 rounded-t-2xl overflow-hidden">
                        <div class="flex justify-center items-center w-auto overflow-hidden gap-2">
                            <svg class="fill-white h-6 w-6" width="61" height="48" viewBox="0 0 61 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M53.375 0H7.625C5.60339 0.00216082 3.6652 0.805561 2.2357 2.23392C0.806203 3.66228 0.00216254 5.59893 0 7.61893V40.2715C0.00216254 42.2915 0.806203 44.2281 2.2357 45.6565C3.6652 47.0849 5.60339 47.8883 7.625 47.8904H53.375C55.3966 47.8883 57.3348 47.0849 58.7643 45.6565C60.1938 44.2281 60.9978 42.2915 61 40.2715V7.61893C60.9978 5.59893 60.1938 3.66228 58.7643 2.23392C57.3348 0.805561 55.3966 0.00216082 53.375 0ZM51.4442 12.6025L31.8371 27.8404C31.4548 28.1374 30.9843 28.2986 30.5 28.2986C30.0157 28.2986 29.5452 28.1374 29.1629 27.8404L9.55576 12.6025C9.32539 12.4287 9.1319 12.2109 8.98652 11.9617C8.84114 11.7125 8.74677 11.4369 8.70891 11.1509C8.67104 10.865 8.69042 10.5744 8.76594 10.296C8.84145 10.0176 8.97158 9.75693 9.14877 9.52921C9.32596 9.3015 9.54668 9.11125 9.7981 8.9695C10.0495 8.82776 10.3266 8.73736 10.6133 8.70355C10.9 8.66974 11.1905 8.6932 11.4681 8.77256C11.7456 8.85192 12.0046 8.98561 12.23 9.16584L30.5 23.3643L48.77 9.16584C49.2269 8.82112 49.8012 8.66992 50.3687 8.74496C50.9363 8.82 51.4514 9.11523 51.8028 9.56682C52.1542 10.0184 52.3136 10.5901 52.2465 11.1581C52.1794 11.7262 51.8912 12.2451 51.4442 12.6025Z"
                                    fill="white" />
                            </svg>
                            <div class="w-full text-ellipsis truncate">
                                <h4 class="text-white font-medium truncate md:text-sm text-xs">{{
                                    trans('messages.profile.change_email') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <form action="{{ route('profile.email') }}" method="POST"
                            class="bg-steel-200 flex flex-col gap-8">
                            @csrf

                            <div class="relative bg-inherit">
                                <input type="email" id="emailInput" name="email" placeholder="{{ trans('auth.email') }}"
                                    class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-white focus:outline-none font-display font-medium text-sm border transition duration-300 @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email ?? '') }}" required="">
                                <label for="emailInput"
                                    class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white peer-focus:text-sm transition-all font-display font-medium select-none">{{
                                    trans('auth.email') }}</label>

                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            @if(! oauth_login())
                            <div class="relative bg-inherit">
                                <input type="password" id="emailConfirmPassInput" name="email_confirm_pass"
                                    placeholder="{{ trans('auth.current_password') }}"
                                    class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-white focus:outline-none font-display font-medium text-sm border transition duration-300 @error('email_confirm_pass') is-invalid @enderror"
                                    required="">
                                <label for="emailConfirmPassInput"
                                    class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white peer-focus:text-sm transition-all font-display font-medium select-none">{{
                                    trans('auth.current_password') }}</label>

                                @error('email_confirm_pass')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif
                            <button type="submit" class="bg-steel-100 px-3 py-4 rounded-xl text-white h-14 text-sm"
                                data-ripple-dark="true">
                                {{ trans('messages.actions.update') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection