@extends('layouts.base')

@section('title', trans('auth.passwords.confirm'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto md:grid grid-cols-12 gap-8">
        <div class="col-span-12">
            <div class="mx-auto max-w-2xl bg-steel-200 rounded-2xl">
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
                                trans('auth.passwords.confirm') }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <p class="text-sm font-medium my-auto truncate text-white mb-4">{{ trans('auth.confirmation') }}
                    </p>
                    <form method="POST" action="{{ route('password.confirm') }}"
                        class="bg-steel-200 flex flex-col gap-8">
                        @csrf

                        <div class="relative bg-inherit">
                            <input type="password" id="password" name="password"
                                placeholder="{{ trans('auth.password') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-white focus:outline-none font-display font-medium text-sm border transition duration-300 @error('password') is-invalid @enderror"
                                required="">
                            <label for="password"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white peer-focus:text-sm transition-all font-display font-medium select-none">{{
                                trans('auth.password') }}</label>

                            @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-steel-100 px-3 py-4 rounded-xl text-white h-14 text-sm"
                            data-ripple-dark="true">
                            {{ trans('auth.passwords.confirm') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection