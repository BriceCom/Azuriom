@php
$userscount = \Azuriom\Models\User::count();
@endphp

@plugin('vote')
@php
$votes = \Azuriom\Plugin\Vote\Models\Vote::getTopVoters(now()->startOfMonth())
@endphp
@endplugin

<div class="col-span-12 xl:col-span-3">
    <div class="rounded-2xl bg-steel-100 border-tertiary border-4">
        <div class="p-8">
            <div class="grid grid-cols-2 relative">
                <div>
                    <img class="z-10 absolute h-24 w-24 -top-12 animate-float"
                        src="{{ theme_asset('img/crystal_orb.png') }}">
                    <div class="z-0 absolute h-14 w-14 left-5 -top-5 bg-[#d88c00] blur-2xl"></div>
                </div>
                <div class="pl-3 ml-auto">
                    <a class="py-2 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-sm truncate"
                        href="#" data-ripple-dark="true" data-hs-overlay="#minecraft_ip_adress">
                        Jouer
                    </a>
                </div>
                <div id="copy_modal"
                    class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[9999] overflow-x-hidden overflow-y-auto">
                    <div
                        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                        <div class="relative w-full h-full justify-center items-center flex">
                            <img class="z-10 absolute md:h-96 h-64 md:-top-72 -top-44"
                                src="{{ theme_asset('img/anvil.png') }}">
                            <div class="z-0 absolute md:h-96 md:h-96 h-64 w-64 md:-top-32 -top-44 bg-steel-50 blur-2xl">
                            </div>
                            <div
                                class="relative z-[9999] bg-steel-300 rounded-2xl w-full p-8 flex flex-col justify-center items-center h-72">
                                <h1
                                    class="flex justify-center items-center uppercase text-2xl text-white font-bold text-center">
                                    Adresse copié</h1>
                                <p
                                    class="mt-2 flex justify-center items-center uppercase text-sm text-steel-50 font-bold text-center">
                                    Crée ta propre histoire dès maintenant !</p>
                                <button data-ripple-dark="true"
                                    class="hs-dropdown-toggle mt-8 py-3 px-7 inline-flex justify-center items-center gap-2 rounded-xl bg-primary font-semibold transition-all text-xl text-white"
                                    data-hs-overlay="#copy_modal">
                                    OK
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="minecraft_ip_adress"
                class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[9999] overflow-x-hidden overflow-y-auto">
                <div
                    class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-7xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] items-center justify-center flex flex-col">
                    <div class="w-full flex flex-col justify-center items-center p-8 gap-4 h-full h-full rounded-md">
                        <p class="minecraft-font text-white text-xs">
                            Rejoignez
                            <span class="inline-flex justify-center items-center my-auto">
                                @if($server && $server->isOnline()){{ $server->getOnlinePlayers() }}@else 0 @endif
                            </span>
                            joueurs connectés
                        </p>
                        <div class="minecraft-input mx-auto md:w-96 w-full text-start text-white truncate px-2 py-2">
                            @if($server){{ $server->fullAddress() }}@endif</div>
                        <input class="hidden" value="@if($server){{ $server->fullAddress() }}@endif" id="ip">
                        <button
                            class="hs-dropdown-toggle minecraft-btn mx-auto md:w-96 w-full text-center text-white truncate p-1 border-2 border-b-4 hover:text-yellow-200"
                            data-hs-overlay="#copy_modal" onclick="copyIP()">Rejoindre l'aventure</button>
                    </div>
                </div>
            </div>
            <div class="text-white mt-6 font-semibold text-xs leading-5">
                Crée ta propre histoire sur notre serveur et entre dans la légende avec
                <span class="mx-1 my-auto bg-steel-50 px-1.5 rounded-md justify-center items-center text-gray-100 py-0.5">
                    <p id="player-count" class="inline-flex justify-center items-center my-auto">
                        @if($server && $server->isOnline()){{ $server->getOnlinePlayers() }}@else 0 @endif
                    </p>
                    Joueurs
                </span>
                connectés.
            </div>
        </div>
        <div class="px-8 pb-8 relative ">
            <div class="z-30 relative space-y-6">
                <div class="flex flex-col">
                    <div class="text-steel-50 text-sm font-medium">Joueurs Inscrits</div>
                    <span class="text-white font-bold text-3xl">{{ $userscount }}</span>
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
                <div class="flex flex-col">
                    <div class="text-steel-50 text-sm font-medium">Record de connectés</div>
                    @if(config('theme.record'))
                    <span class="text-white font-bold text-3xl">{{ config('theme.record') }}</span>
                    @endif
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
            </div>
            <img class="z-10 absolute h-64 -top-10 md:-right-20 -right-28 " src="{{ theme_asset('img/anvil.png') }}">
            <div class="z-0 absolute h-28 w-28 right-0 -bottom-10 bg-steel-50 blur-2xl"></div>
        </div>
    </div>
    @plugin('vote')
    <div class="rounded-2xl bg-steel-100 mt-10">
        <div class="flex justify-between px-8 pt-8 pb-6">
            <p class="text-white my-auto text-sm font-semibold truncate mr-4 ">
                Classement du mois
            </p>
            <a class="py-2 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold transition-all text-sm truncate"
                href="/vote" data-ripple-dark="true">
                Voir plus
            </a>
        </div>
        <div class="flex flex-raw h-full justify-center items-end my-auto mx-auto pb-8">
            @foreach ($votes->slice(0, 3) as $id => $vote)
            <div class="text-ellipsis truncate @if($id === 2) -order-1 @elseif($id === 1) ml-6 mr-6 @endif">
                <p class="flex mx-auto text-lg text-white justify-center items-center font-semibold">{{ $id }}</p>
                <img class="h-8 w-8 mx-auto -mb-1" src="{{ theme_asset('img/cup' . $id . '.png' ) }}">
                <div
                    class="flex w-16 bg-steel-200 @if($id === 1) h-40 @elseif($id === 2) h-32 @else h-20 @endif rounded-xl items-start overflow-hidden">
                    <div class="mx-auto w-12 mt-4">
                        <div class="flex relative justify-center items-center h-full">
                            <img class="absolute h-8 rounded-md shadow-xl mx-auto z-50" src={{
                                $vote->user->getAvatar(150) }}">
                            <div class="h-8 w-8 bg-steel-300 flex justify-center items-center rounded-lg">
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
                        <p class="text-white text-xs text-center mt-1 text-ellipsis truncate">{{ $vote->user->name }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endplugin
    <div class="mt-10 bg-steel-100 rounded-2xl">
        <div class="relative rounded-xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            <div class="bg-steel-200 text-white flex md:flex-col flex-row md:justify-between justify-start items-start">
                <h2 class="text-xs font-semibold p-4 h-full my-auto truncate">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="md:mb-2 my-auto md:h-4 md:w-4 w-5 h-5 fill-white group-hover:fill-primary transition ease-in-out duration-400 mr-2"
                        viewBox="0 0 35 27">
                        <path
                            d="M29.629 2.40439C27.3982 1.38507 25.006 0.634077 22.5049 0.203953C22.4593 0.195651 22.4138 0.216397 22.3903 0.257888C22.0827 0.802803 21.7419 1.51369 21.5033 2.07244C18.8131 1.67137 16.1367 1.67137 13.5017 2.07244C13.263 1.50127 12.9099 0.802803 12.6008 0.257888C12.5774 0.217781 12.5319 0.197036 12.4863 0.203953C9.98654 0.632703 7.59436 1.3837 5.3622 2.40439C5.34287 2.41269 5.32631 2.42653 5.31532 2.4445C0.777863 9.19519 -0.465136 15.7799 0.144638 22.2831C0.147397 22.3149 0.165331 22.3453 0.190164 22.3647C3.18385 24.554 6.08374 25.8832 8.92978 26.7641C8.97533 26.778 9.02359 26.7614 9.05258 26.724C9.72581 25.8085 10.3259 24.8431 10.8405 23.8279C10.8709 23.7685 10.8419 23.6979 10.7798 23.6744C9.8279 23.3148 8.9215 22.8764 8.04961 22.3785C7.98064 22.3384 7.97512 22.2402 8.03856 22.1931C8.22204 22.0562 8.40557 21.9138 8.58077 21.7699C8.61246 21.7437 8.65663 21.7381 8.6939 21.7547C14.4219 24.359 20.6231 24.359 26.2835 21.7547C26.3207 21.7367 26.3649 21.7423 26.398 21.7685C26.5732 21.9124 26.7567 22.0562 26.9416 22.1931C27.005 22.2402 27.0009 22.3384 26.9319 22.3785C26.06 22.8861 25.1536 23.3148 24.2003 23.673C24.1383 23.6965 24.1107 23.7685 24.141 23.8279C24.6666 24.8417 25.2667 25.8071 25.9276 26.7227C25.9552 26.7614 26.0048 26.778 26.0504 26.7641C28.9102 25.8832 31.8101 24.554 34.8038 22.3647C34.83 22.3453 34.8465 22.3163 34.8493 22.2844C35.5791 14.7661 33.627 8.23536 29.6745 2.44588C29.6648 2.42653 29.6483 2.41269 29.629 2.40439ZM11.6959 18.3233C9.97135 18.3233 8.5504 16.7467 8.5504 14.8104C8.5504 12.8741 9.9438 11.2975 11.6959 11.2975C13.4617 11.2975 14.8689 12.888 14.8413 14.8104C14.8413 16.7467 13.4479 18.3233 11.6959 18.3233ZM23.3257 18.3233C21.6012 18.3233 20.1803 16.7467 20.1803 14.8104C20.1803 12.8741 21.5736 11.2975 23.3257 11.2975C25.0915 11.2975 26.4987 12.888 26.4711 14.8104C26.4711 16.7467 25.0915 18.3233 23.3257 18.3233Z">
                        </path>
                    </svg>
                    <span class="md:flex hidden">Discord Officiel</span>
                </h2>
                <div class="mt-auto p-4 flex w-full justify-end items-end">
                    <a class="bg-steel-100 py-2 px-3 rounded-lg text-xs md:w-full cursor-pointer text-center"
                        data-ripple-dark="true" href="https://discord.gg/Kg83hEpx7u" target="_blank">Rejoindre</a>
                </div>
            </div>
            <div class="h-64 overflow-y-scroll py-8 w-full brm-discordWidget">
                <div
                    class="absolute px-2 py-1.5 bg-steel-300/80 rounded-md bottom-5 right-5 z-50 text-white text-xs font-medium">
                    <span class="brm-presenceCount"></span> Membres actifs
                </div>
                <div class="w-full flex flex-col gap-2 px-8 brm-usersDiscord">
                </div>
            </div>
        </div>
    </div>
    {{-- <a class="cursor-pointer" href="/boutique">
        <div class="bg-steel-100 rounded-2xl mt-10" data-ripple-dark="true">
            <div class="flex justify-between px-8 pt-8">
                <p class="text-white my-auto text-sm font-semibold truncate mr-4 ">
                    Offre du moment
                </p>
            </div>
            <div class="flex flex-raw justify-center items-end my-auto mx-auto">
                <img class="h-48" src="{{ theme_asset('/img/coins.png') }}">
            </div>
            <div class="grid md:grid-cols-2 grid-cols-1 gap-8 px-8 pb-8">
                <div class="flex text-white font-medium tracking-tighter overflow-hidden my-auto">
                    <span class="text-2xl font-bold truncate">500 Coins</span>
                </div>
                <div
                    class="py-2 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-200 text-white font-semibold transition-all text-xs truncate">
                    <p class="text-white text-sm font-semibold mr-2 ml-3">5000</p>
                    <img src="{{ theme_asset('/img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
                </div>
            </div>
        </div>
    </a> --}}
</div>

{{-- @plugin('shop')
@push('scripts')
<script>
    function getCurrentOffer() {
    fetch("{{ route('home') }}/shop/categories/coins")
        .then((response) =>
            response.text()
        ).then((text) => {

            const widget = text.getElementById('widget_current_offer')
            console.log(widget)
        })
    }

    getCurrentOffer()
</script>
@endpush
@endplugin --}}
