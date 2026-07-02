@extends('layouts.app')

@section('title', trans('auth.passwords.reset'))

@section('content')
    <div class="container flex flex-col w-full col-span-12 mx-auto">
        <div
            class="relative z-50 grid w-full h-full grid-cols-1 gap-8 p-8 overflow-y-scroll border border-steel-200 md:p-16 rounded-2xl md:grid-cols-2 md:gap-16 md:overflow-hidden">
            <div class="order-2">
                <div class="flex flex-col items-center justify-center h-full">
                    <img class="h-40 transition duration-200 md:h-56 hover:scale-105"
                        src="{{ setting('logo') ? image_url(setting('logo')) : theme_asset('static/logo.png') }}"
                        alt="Logo" width="auto">
                </div>
            </div>
            <div class="flex flex-col justify-center order-1 gap-8">
                <div class="flex flex-col">
                    <h1 class="text-xl font-semibold text-white">{{ trans('auth.passwords.reset') }}</h1>
                </div>
                <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-8 bg-steel-300">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <label for="email"
                        class="relative flex w-full py-4 border h-14 border-steel-200 hover:border-white rounded-xl">
                        <input name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            id="email"
                            class="block w-full h-full px-5 font-medium text-white truncate bg-transparent border-0 outline-none placeholder-steel-100 focus:ring-0 focus:outline-none focus:border-0 whitespace-nowrap overflow-ellipsis"
                            placeholder="{{ trans('auth.email') }}">
                        <span
                            class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.email') }}</span>
                    </label>
                    @error('email')
                        <span class="text-xs font-semibold text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label for="password"
                        class="relative flex w-full py-4 border h-14 border-steel-200 hover:border-white rounded-xl">
                        <input type="password" name="password" required id="password"
                            class="block w-full h-full px-5 font-medium text-white truncate bg-transparent border-0 outline-none placeholder-steel-100 focus:ring-0 focus:outline-none focus:border-0 whitespace-nowrap overflow-ellipsis"
                            autocomplete="new-password" placeholder="{{ trans('auth.password') }}">
                        <span
                            class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.password') }}</span>
                    </label>
                    @error('password')
                        <span class="text-xs font-semibold text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="password"
                        class="relative flex w-full py-4 border h-14 border-steel-200 hover:border-white rounded-xl">
                        <input type="password" name="password" required id="password"
                            class="block w-full h-full px-5 font-medium text-white truncate bg-transparent border-0 outline-none placeholder-steel-100 focus:ring-0 focus:outline-none focus:border-0 whitespace-nowrap overflow-ellipsis"
                            autocomplete="new-password" placeholder="{{ trans('auth.confirm_password') }}">
                        <span
                            class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.confirm_password') }}</span>
                    </label>



                    <button type="submit"
                        class="px-3 py-4 text-sm text-white bg-steel-400 hover:bg-steel-200 rounded-xl h-14">
                        {{ trans('auth.passwords.reset') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
