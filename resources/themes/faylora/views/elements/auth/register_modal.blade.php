<div id="register_modal"
    class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[9999] overflow-x-hidden overflow-y-auto justify-center items-center flex">
    <div
        class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-5xl m:w-max w-full sm:mx-auto md:h-max h-full flex items-center md:p-8 p-0">
        <div class="relative w-full h-full justify-center items-center flex">
            <img class="z-10 absolute md:h-96 h-64 md:-top-72 -top-44" src="{{ theme_asset('/img/anvil.png') }}">
            <div class="z-0 absolute md:h-96 md:h-96 h-64 w-64 md:-top-32 -top-44 bg-steel-50 blur-2xl"></div>
            <div
                class="relative z-[9999] bg-steel-300 h-full w-full md:p-16 p-8 md:rounded-2xl grid md:grid-cols-2 grid-cols-1 md:gap-16 gap-8 overflow-y-scroll md:overflow-hidden">
                <div class="order-2">
                    <div class="flex flex-col gap-4 flex justify-center items-center h-full text-white">
                        <img class="md:h-56 h-40 hover:scale-105 transition duration-200"
                            src="{{ image_url(setting('logo')) }}" alt="Logo" width="auto">
                        <div class="bg-steel-200 p-4 rounded-xl w-full">
                            <p class="text-white text-xs font-medium">
                                Rejoignez l'aventure Deyzia et recevez des récompenses lors de votre première
                                connexion.
                            </p>
                            <div class="flex flex-raw gap-2 mt-4 justify-center items-center">
                                <span class="text-white text-lg font-medium my-auto">+</span>
                                <div class="flex flex-col justify-center items-center">
                                    <img class="lg:h-16 h-12" src="{{ theme_asset('img/kit.png') }}" alt="">
                                    <span class="text-[#67C965] text-xs font-medium text-center">1x Kit
                                        Guerrier</span>
                                </div>
                                <span class="text-white text-lg font-medium my-auto">+</span>
                                <div class="flex flex-col justify-center items-center">
                                    <img class="lg:h-16 h-12" src="{{ theme_asset('img/coins.png') }}" alt="">
                                    <span class="text-[#F9A62B] text-xs font-medium text-center">50$</span>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)"
                            class="mt-8 bg-steel-200 h-14 rounded-xl text-white w-64 truncate text-sm text-center justify-center items-center flex cursor-pointer"
                            data-ripple-dark="true" data-hs-overlay="#login_modal">
                            Déja Inscrit ?
                        </a>
                    </div>
                </div>
                <div class="order-1 flex flex-col gap-8 justify-center">
                    <div class="flex flex-col">
                        <h1 class="text-white font-semibold text-xl">{{ trans('auth.register') }}</h1>
                        <div class="h-1 w-16 bg-steel-200 rounded-full mt-1"></div>
                    </div>
                    <form action="{{ route('register') }}" method="post" class="bg-steel-300 flex flex-col gap-8"
                        id="captcha-form">
                        @csrf

                        <div class="relative bg-inherit">
                            <input type="text" id="username" name="name" minlength="1" maxlength="32" placeholder="{{
                                trans('auth.name') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-200 focus:border-steel-50/50 focus:outline-none font-display font-medium text-sm border transition duration-300 @error('name') is-invalid @enderror"
                                required="" value="{{ old('name') }}" autocomplete="name" autofocus>
                            <label for="name"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50/50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50/50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-steel-50/50 peer-focus:text-sm transition-all font-display font-medium @error('name') is-invalid @enderror">{{
                                trans('auth.name') }}</label>
                            <img id="avatar" alt="" class="absolute right-3 top-3 h-8 w-8 rounded-lg">
                            @error('name')
                            <span class="text-danger text-sm" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="relative bg-inherit">
                            <input type="email" id="email" name="email" minlength="1" maxlength="128"
                                placeholder="{{ trans('auth.email') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-200 focus:border-steel-50/50 focus:outline-none font-display font-medium text-sm border transition duration-300 @error('email') is-invalid @enderror"
                                required="" value="{{ old('email') }}" autocomplete="email">
                            <label for="email"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50/50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50/50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-steel-50/50 peer-focus:text-sm transition-all font-display font-medium @error('email') is-invalid @enderror">{{
                                trans('auth.email') }}</label>
                            @error('email')
                            <span class="text-danger text-sm" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="relative bg-inherit">
                            <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" id="password"
                                name="password" minlength="1" maxlength="128" placeholder="{{ trans('auth.password') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-200 focus:border-steel-50/50 focus:outline-none font-display font-medium text-sm border transition duration-300 @error('password') is-invalid @enderror"
                                required="" autocomplete="new-password">
                            <label for="password"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50/50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50/50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-steel-50/50 peer-focus:text-sm transition-all font-display font-medium @error('password') is-invalid @enderror">{{
                                trans('auth.password') }}</label>
                            @error('password')
                            <span class="text-danger text-sm" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="relative bg-inherit">
                            <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"
                                id="password-confirm" name="password_confirmation" minlength="1" maxlength="128"
                                placeholder="{{ trans('auth.confirm_password') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-steel-200 focus:border-steel-50/50 focus:outline-none font-display font-medium text-sm border transition duration-300"
                                required="" autocomplete="new-password">
                            <label for="password-confirm"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-steel-50/50 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-steel-50/50 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-steel-50/50 peer-focus:text-sm transition-all font-display font-medium">{{
                                trans('auth.confirm_password') }}</label>
                        </div>
                        @if(setting('captcha.type'))
                        <div class="border border-steel-200 rounded-xl p-2 text-white text-xs">
                            @include('elements.captcha', ['center' => true])
                        </div>
                        @endif
                        <div class="grid grid-cols-2 gap-8">
                            <button type="submit" class="bg-steel-200 px-3 py-4 rounded-xl text-white h-14 text-sm"
                                data-ripple-dark="true">
                                {{ trans('auth.register') }}
                            </button>
                            <button type="button"
                                class="hs-dropdown-toggle border border-steel-200 px-3 py-4 rounded-xl text-white h-14 text-sm"
                                data-ripple-dark="true" data-hs-overlay="#register_modal">
                                Annuler
                            </button>
                        </div>
                        <a href="https://discord.skyhills.fr/" target="_blank"
                            class="text-steel-50 hover:text-white font-medium text-sm justify-center items-center flex transition duration-300">Vous
                            rencontrez un problème ?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>