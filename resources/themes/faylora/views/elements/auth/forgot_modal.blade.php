<div id="lost_password_modal"
    class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[9999] overflow-x-hidden overflow-y-auto justify-center items-center flex">
    <div
        class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-5xl m:w-max w-full sm:mx-auto md:h-max h-full flex items-center md:p-8 p-0">
        <div class="relative w-full h-full justify-center items-center flex">
            <img class="z-10 absolute md:h-96 h-64 md:-top-72 -top-44" src="{{ theme_asset('/img/anvil.png') }}">
            <div class="z-0 absolute md:h-96 md:h-96 h-64 w-64 md:-top-32 -top-44 bg-steel-50 blur-2xl"></div>
            <div
                class="relative z-[9999] bg-steel-300 h-full w-full md:p-16 p-8 md:rounded-2xl grid md:grid-cols-2 grid-cols-1 md:gap-16 gap-8 overflow-y-scroll md:overflow-hidden">
                <div class="order-2">
                    <div class="flex flex-col flex justify-center items-center h-full">
                        <img class="md:h-56 h-40 hover:scale-105 transition duration-200"
                            src="{{ image_url(setting('logo')) }}" alt="Logo" width="auto">
                        <a class="mt-8 bg-steel-200 h-14 rounded-xl text-white w-64 truncate text-sm text-center justify-center items-center flex cursor-pointer"
                            data-ripple-dark="true" data-hs-overlay="#register_modal">
                            Pas encore inscrit ?
                        </a>
                    </div>
                </div>
                <div class="order-1 flex flex-col gap-8 justify-center">
                    <div class="flex flex-col">
                        <h1 class="text-white font-semibold text-xl">{{ trans('auth.passwords.reset') }}</h1>
                        <div class="h-1 w-16 bg-steel-200 rounded-full mt-1"></div>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="post" class="bg-steel-300 flex flex-col gap-8"
                        id="captcha-form">
                        @csrf

                        <div class="relative bg-inherit">
                            <input type="email" id="email" name="email" minlength="1" maxlength="128"
                                placeholder="{{ trans('auth.email') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-200 focus:border-steel-50/50 focus:outline-none font-display font-medium text-sm border transition duration-300 @error('email') is-invalid @enderror"
                                required="" value="{{ old('email') }}" autocomplete="email" autofocus>
                            <label for="email"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50/50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50/50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-steel-50/50
                                peer-focus:text-sm transition-all font-display font-medium @error('email') is-invalid @enderror">{{
                                trans('auth.email')
                                }}</label>
                            @error('email')
                            <span class="text-danger text-sm" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        @if(setting('captcha.type'))
                        <div class="border border-steel-200 rounded-xl p-2 text-white text-xs">
                            @include('elements.captcha', ['center' => true])
                        </div>
                        @endif
                        <div class="grid grid-cols-2 gap-8">
                            <button type="submit" class="bg-steel-200 px-3 py-4 rounded-xl text-white h-14 text-sm"
                                data-ripple-dark="true">
                                {{ trans('auth.passwords.send') }}
                            </button>
                            <button type="button"
                                class="hs-dropdown-toggle border border-steel-200 px-3 py-4 rounded-xl text-white h-14 text-sm"
                                data-ripple-dark="true" data-hs-overlay="#lost_password_modal">
                                Annuler
                            </button>
                        </div>
                        <a href="/support"
                            class="text-steel-50 hover:text-white font-medium text-sm justify-center items-center flex transition duration-300">Vous
                            rencontrez un problème ?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>