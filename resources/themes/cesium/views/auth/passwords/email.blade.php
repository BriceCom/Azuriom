@extends('layouts.app')

@section('title', trans('auth.passwords.reset'))

@section('content')
    <div class="container flex flex-col w-full col-span-12 mx-auto">
        <div
            class="relative z-50 w-full h-full gap-8 p-8 overflow-y-scroll border border-steel-200 md:p-16 rounded-2xl md:gap-16 md:overflow-hidden">
            <div class="flex flex-col justify-center gap-8">
                <div class="flex flex-col">
                    <h1 class="text-xl font-semibold text-white">{{ trans('auth.passwords.reset') }}</h1>
                </div>
                <form action="{{ route('password.email') }}" id="captcha-form" method="POST"
                    class="flex flex-col gap-8 bg-steel-300">
                    @csrf

                    <label for="email"
                        class="relative flex w-full py-4 border h-14 border-steel-200 hover:border-white rounded-xl">
                        <input type="email" name="email" required id="email"
                            class="block w-full h-full px-5 font-medium text-white truncate bg-transparent border-0 outline-none placeholder-steel-100 focus:ring-0 focus:outline-none focus:border-0 whitespace-nowrap overflow-ellipsis"
                            placeholder="{{ trans('auth.email') }}" value="{{ old('email') }}">

                        <span
                            class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.email') }}</span>
                    </label>
                    @error('email')
                        <span class="text-xs font-semibold text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    @include('elements.captcha', ['center' => true])

                    <button type="submit"
                        class="px-3 py-4 text-sm text-white bg-steel-400 hover:bg-steel-200 rounded-xl h-14">
                        {{ trans('auth.passwords.send') }}
                    </button>


                </form>
            </div>
        </div>
    </div>
@endsection
