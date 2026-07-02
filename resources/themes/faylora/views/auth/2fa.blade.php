@extends('layouts.base')

@section('title', trans('auth.login'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        <div class="col-span-12">
            <div class="mx-auto max-w-2xl bg-steel-200 rounded-2xl">
                <div
                    class="flex flex-raw items-center justify-between py-6 px-6 bg-steel-100 rounded-t-2xl overflow-hidden">
                    <div class="flex justify-center items-center w-auto overflow-hidden gap-2">
                        <svg class="fill-white h-6 w-6" width="50" height="50" viewBox="0 0 50 50" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M42.1 33.9219H34.9C34.4029 33.9219 34 34.3239 34 34.8198V42.0034C34 42.4993 34.4029 42.9013 34.9 42.9013H42.1C42.5971 42.9013 43 42.4993 43 42.0034V34.8198C43 34.3239 42.5971 33.9219 42.1 33.9219Z"
                                fill="white" />
                            <path
                                d="M33.125 26.9375H27.875C27.3918 26.9375 27 27.3284 27 27.8105V33.0485C27 33.5307 27.3918 33.9215 27.875 33.9215H33.125C33.6082 33.9215 34 33.5307 34 33.0485V27.8105C34 27.3284 33.6082 26.9375 33.125 26.9375Z"
                                fill="white" />
                            <path
                                d="M49.125 41.9043H43.875C43.3918 41.9043 43 42.2952 43 42.7773V48.0153C43 48.4975 43.3918 48.8883 43.875 48.8883H49.125C49.6082 48.8883 50 48.4975 50 48.0153V42.7773C50 42.2952 49.6082 41.9043 49.125 41.9043Z"
                                fill="white" />
                            <path
                                d="M48.8333 26.9375H44.1667C43.5223 26.9375 43 27.4586 43 28.1015V32.7575C43 33.4004 43.5223 33.9215 44.1667 33.9215H48.8333C49.4777 33.9215 50 33.4004 50 32.7575V28.1015C50 27.4586 49.4777 26.9375 48.8333 26.9375Z"
                                fill="white" />
                            <path
                                d="M32.8333 41.9043H28.1667C27.5223 41.9043 27 42.4254 27 43.0683V47.7243C27 48.3672 27.5223 48.8883 28.1667 48.8883H32.8333C33.4777 48.8883 34 48.3672 34 47.7243V43.0683C34 42.4254 33.4777 41.9043 32.8333 41.9043Z"
                                fill="white" />
                            <path
                                d="M46.4286 0H30.3571C29.4099 0 28.5015 0.375415 27.8318 1.04366C27.162 1.7119 26.7857 2.61824 26.7857 3.56327V19.598C26.7857 20.5431 27.162 21.4494 27.8318 22.1176C28.5015 22.7859 29.4099 23.1613 30.3571 23.1613H46.4286C47.3758 23.1613 48.2842 22.7859 48.954 22.1176C49.6237 21.4494 50 20.5431 50 19.598V3.56327C50 2.61824 49.6237 1.7119 48.954 1.04366C48.2842 0.375415 47.3758 0 46.4286 0ZM42.8571 15.1439C42.8571 15.3802 42.7631 15.6068 42.5956 15.7738C42.4282 15.9409 42.2011 16.0347 41.9643 16.0347H34.8214C34.5846 16.0347 34.3575 15.9409 34.1901 15.7738C34.0226 15.6068 33.9286 15.3802 33.9286 15.1439V8.01737C33.9286 7.78111 34.0226 7.55453 34.1901 7.38746C34.3575 7.2204 34.5846 7.12655 34.8214 7.12655H41.9643C42.2011 7.12655 42.4282 7.2204 42.5956 7.38746C42.7631 7.55453 42.8571 7.78111 42.8571 8.01737V15.1439ZM19.6429 0H3.57143C2.62423 0 1.71582 0.375415 1.04605 1.04366C0.376274 1.7119 0 2.61824 0 3.56327V19.598C0 20.5431 0.376274 21.4494 1.04605 22.1176C1.71582 22.7859 2.62423 23.1613 3.57143 23.1613H19.6429C20.5901 23.1613 21.4985 22.7859 22.1682 22.1176C22.838 21.4494 23.2143 20.5431 23.2143 19.598V3.56327C23.2143 2.61824 22.838 1.7119 22.1682 1.04366C21.4985 0.375415 20.5901 0 19.6429 0ZM16.0714 15.1439C16.0714 15.3802 15.9774 15.6068 15.8099 15.7738C15.6425 15.9409 15.4154 16.0347 15.1786 16.0347H8.03571C7.79891 16.0347 7.57181 15.9409 7.40437 15.7738C7.23693 15.6068 7.14286 15.3802 7.14286 15.1439V8.01737C7.14286 7.78111 7.23693 7.55453 7.40437 7.38746C7.57181 7.2204 7.79891 7.12655 8.03571 7.12655H15.1786C15.4154 7.12655 15.6425 7.2204 15.8099 7.38746C15.9774 7.55453 16.0714 7.78111 16.0714 8.01737V15.1439ZM19.6429 26.7246H3.57143C2.62423 26.7246 1.71582 27.1 1.04605 27.7682C0.376274 28.4365 0 29.3428 0 30.2878V46.3226C0 47.2676 0.376274 48.1739 1.04605 48.8422C1.71582 49.5104 2.62423 49.8858 3.57143 49.8858H19.6429C20.5901 49.8858 21.4985 49.5104 22.1682 48.8422C22.838 48.1739 23.2143 47.2676 23.2143 46.3226V30.2878C23.2143 29.3428 22.838 28.4365 22.1682 27.7682C21.4985 27.1 20.5901 26.7246 19.6429 26.7246ZM16.0714 41.8685C16.0714 42.1047 15.9774 42.3313 15.8099 42.4984C15.6425 42.6654 15.4154 42.7593 15.1786 42.7593H8.03571C7.79891 42.7593 7.57181 42.6654 7.40437 42.4984C7.23693 42.3313 7.14286 42.1047 7.14286 41.8685V34.7419C7.14286 34.5057 7.23693 34.2791 7.40437 34.112C7.57181 33.945 7.79891 33.8511 8.03571 33.8511H15.1786C15.4154 33.8511 15.6425 33.945 15.8099 34.112C15.9774 34.2791 16.0714 34.5057 16.0714 34.7419V41.8685Z"
                                fill="white" />
                        </svg>
                        <div class="w-full text-ellipsis truncate">
                            <h4 class="text-white font-medium truncate md:text-sm text-xs">{{ trans('auth.login') }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="p-8 flex flex-col text-white text-center">
                    <form method="POST" action="{{ route('login.2fa') }}" class="bg-steel-200 flex flex-col gap-8">
                        @csrf

                        <div class="relative bg-inherit">
                            <input type="text" id="code" name="code" autocomplete="one-time-code" autofocus
                                placeholder="{{ trans('auth.2fa.code') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-100 focus:border-steel-50/50 focus:outline-none font-display font-medium text-sm border transition duration-300 @error('code') is-invalid @enderror">
                            <label for="code"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50/50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50/50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-steel-50/50 peer-focus:text-sm transition-all font-display font-medium">{{
                                trans('auth.2fa.code') }}</label>

                            @error('code')
                            <span class="text-danger text-sm" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-primary px-3 py-4 rounded-xl text-white h-14 text-sm truncate"
                            data-ripple-dark="true">
                            {{ trans('auth.login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
</main>
@endsection