@extends('layouts.base')
@section('title', trans('messages.home'))
@section('app')
    <main class="h-full px-8 pt-10 overflow-x-hidden">
        @if ($message)
            <div class="container px-4 py-3.5 mx-auto mb-10 border rounded-2xl border-steel-200">
                <div class="flex">
                    <div class="flex-shrink-0 my-auto">
                        <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33"
                            viewBox="0 0 33 33" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between flex-1 ml-4">
                        <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">

                            {{ $message }}

                        </p>
                        <p class="my-auto text-sm md:mt-0 md:ml-6">
                            <a class="flex px-4 py-2.5 text-xs font-medium text-white rounded-xl bg-steel-200 hover:bg-steel-100 transition duration-200"
                                href="{{ route('login') }}">
                                <svg class="w-5 h-5 my-auto mr-2 fill-white" width="21" height="21"
                                    viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.25 7.25676C19.25 10.298 16.7744 12.7635 13.7206 12.7635C13.1634 12.7635 11.8947 12.6354 11.2774 12.1232L10.5059 12.8916C10.0523 13.3434 10.1748 13.4764 10.3765 13.6955C10.4607 13.7869 10.5588 13.8933 10.6345 14.0442C10.6345 14.0442 11.2774 14.9406 10.6345 15.8371C10.2487 16.3493 9.16851 17.0664 7.9341 15.8371L7.67692 16.0932C7.67692 16.0932 8.44846 16.9896 7.80551 17.8861C7.41974 18.3984 6.39103 18.9106 5.4909 18.0142L4.59078 18.9106C3.97354 19.5253 3.21917 19.1667 2.91914 18.9106L2.14761 18.1422C1.4275 17.425 1.84756 16.6481 2.14761 16.3493L8.83426 9.69001C8.83426 9.69001 8.19131 8.66546 8.19131 7.25676C8.19131 4.21546 10.6669 1.75 13.7206 1.75C16.7744 1.75 19.25 4.21546 19.25 7.25676ZM13.7209 9.17779C14.7861 9.17779 15.6496 8.31776 15.6496 7.25684C15.6496 6.19592 14.7861 5.33587 13.7209 5.33587C12.6556 5.33587 11.792 6.19592 11.792 7.25684C11.792 8.31776 12.6556 9.17779 13.7209 9.17779Z">
                                    </path>
                                </svg>
                                <span class="my-auto tracking-wide">Connexion</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="container grid grid-cols-12 mx-auto">
            <?php
            
            use Azuriom\Models\User;
            use Azuriom\Plugin\Vote\Models\Vote;
            use Carbon\Carbon;
            
            $users = User::count();
            
            if (class_exists('Azuriom\Plugin\Vote\Models\Vote')) {
                $votes = Vote::getTopVoters(Carbon::now()->subMonth(), Carbon::now());
            }
            
            ?>
            <div class="grid col-span-12 gap-10 xl:col-span-3">
                @if (!class_exists('Azuriom\Plugin\Vote\Models\Vote'))
                    <div class="pb-8 border rounded-2xl border-steel-200">
                        <div class="flex justify-center px-8 pt-8 pb-2 text-white">
                            <svg class="mr-2 w-7 h-7 fill-white" width="30" height="30" viewBox="0 0 30 30"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.0112 16.952L27.2977 13.9079C27.5227 11.5171 27.6353 10.3217 27.2262 9.82759C27.005 9.56029 26.7041 9.3965 26.3825 9.36825C25.7879 9.31602 25.0411 10.1661 23.5476 11.8663C22.7752 12.7456 22.3891 13.1852 21.9583 13.2534C21.7196 13.291 21.4764 13.2522 21.2559 13.1414C20.8581 12.9411 20.5929 12.3976 20.0624 11.3106L17.2664 5.58106C16.264 3.52702 15.7627 2.5 15 2.5C14.2372 2.5 13.736 3.52702 12.7336 5.58107L9.93758 11.3106C9.40712 12.3976 9.14188 12.9411 8.74407 13.1414C8.52365 13.2522 8.28042 13.291 8.04171 13.2534C7.6109 13.1852 7.22471 12.7456 6.45233 11.8663C4.95885 10.1661 4.2121 9.31602 3.61748 9.36825C3.29582 9.3965 2.99497 9.56029 2.77373 9.82759C2.36475 10.3217 2.47725 11.5171 2.70226 13.9079L2.98875 16.952C3.46081 21.9677 3.69685 24.4756 5.17511 25.9877C6.65339 27.5 8.86896 27.5 13.3001 27.5H16.6999C21.131 27.5 23.3466 27.5 24.8249 25.9877C26.3031 24.4756 26.5391 21.9677 27.0112 16.952Z">
                                </path>
                            </svg>
                            <span class="my-auto text-lg font-medium">Classement du mois</span>
                        </div>
                        <div class="flex items-end justify-center mx-auto my-auto flex-raw">
                            <div class="ml-3 mr-3 truncate text-ellipsis ">
                                <p class="flex items-center justify-center mx-auto mb-2 text-lg font-semibold text-white">1
                                </p>
                                <div class="flex items-start w-16 overflow-hidden h-36 bg-steel-100/20 rounded-t-xl">
                                    <div class="w-12 mx-auto mt-4">
                                        <div class="relative flex items-center justify-center h-full">
                                            <img class="absolute z-50 h-8 mx-auto text-transparent rounded-md shadow-xl"
                                                src="https://minotar.net/avatar/{{ $votes[1]->user->name ?? 'connor4312' }}/150.png">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-steel-300">
                                                <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-center text-white truncate text-ellipsis">
                                            {{ $votes[1]->user->name ?? '?' }}</p>
                                        <div
                                            class="flex items-center justify-center w-10 h-6 px-1 mx-auto mt-3 text-white rounded-md bg-steel-400">
                                            <p class="ml-0.5 text-[0.6rem] font-semibold text-white mr-0.5 truncate">
                                                {{ theme_config('vote_award_1') }}</p>
                                            <img src="{{ theme_asset('static/coin.png') }}" class="h-3.5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="truncate text-ellipsis -order-1 ">
                                <p class="flex items-center justify-center mx-auto mb-2 text-lg font-semibold text-white">2
                                </p>
                                <div class="flex items-start w-16 overflow-hidden h-28 bg-steel-100/20 rounded-t-xl">
                                    <div class="w-12 mx-auto mt-4">
                                        <div class="relative flex items-center justify-center h-full">
                                            <img class="absolute z-50 h-8 mx-auto text-transparent rounded-md shadow-xl"
                                                src="https://minotar.net/avatar/{{ $votes[2]->user->name ?? 'connor4312' }}/150.png">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-steel-300">
                                                <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-center text-white truncate text-ellipsis">
                                            {{ $votes[2]->user->name ?? '?' }}</p>
                                        <div
                                            class="flex items-center justify-center w-10 h-6 px-1 mx-auto mt-3 text-white rounded-md bg-steel-400">
                                            <p class="ml-0.5 text-[0.6rem] font-semibold text-white mr-0.5 truncate">
                                                {{ theme_config('vote_award_2') }}</p>
                                            <img src="{{ theme_asset('static/coin.png') }}" class="h-3.5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="truncate text-ellipsis ">
                                <p class="flex items-center justify-center mx-auto mb-2 text-lg font-semibold text-white">3
                                </p>
                                <div class="flex items-start w-16 h-24 overflow-hidden bg-steel-100/20 rounded-t-xl">
                                    <div class="w-12 mx-auto mt-4">
                                        <div class="relative flex items-center justify-center h-full">
                                            <img class="absolute z-50 h-8 mx-auto text-transparent rounded-md shadow-xl"
                                                src="https://minotar.net/avatar/{{ $votes[3]->user->name ?? 'connor4312' }}/150.png">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-steel-300">
                                                <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-center text-white truncate text-ellipsis">
                                            {{ $votes[3]->user->name ?? '?' }}</p>
                                        <div
                                            class="flex items-center justify-center w-10 h-6 px-1 mx-auto mt-3 text-white rounded-md bg-steel-400">
                                            <p class="ml-0.5 text-[0.6rem] font-semibold text-white mr-0.5 truncate">
                                                {{ theme_config('vote_award_3') }}</p>
                                            <img src="{{ theme_asset('static/coin.png') }}" class="h-3.5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="/vote"
                            class="flex items-center justify-center py-5 mx-8 font-medium text-white transition duration-200 text-md rounded-xl bg-steel-400 hover:bg-steel-200">
                            <svg class="w-6 h-6 mr-1.5 fill-white" width="23" height="23" viewBox="0 0 23 23"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.616 10.2436C13.6705 9.11228 13.1976 8.54662 12.6541 8.63375C12.1108 8.72087 11.8565 9.4031 11.348 10.7675L11.2165 11.1205C11.0719 11.5082 10.9997 11.7021 10.8591 11.8449C10.7186 11.9878 10.5256 12.0633 10.1396 12.2145L9.78825 12.3521C8.42998 12.8841 7.75086 13.1501 7.67341 13.6937C7.59596 14.2374 8.17147 14.6987 9.32247 15.6212L9.62026 15.8599C9.94733 16.1221 10.1109 16.2532 10.2055 16.4326C10.3002 16.612 10.3152 16.8195 10.3454 17.2344L10.3728 17.6122C10.4789 19.0723 10.532 19.8023 11.0276 20.0512C11.5232 20.3001 12.1331 19.903 13.353 19.1087L13.6685 18.9032C14.0152 18.6775 14.1885 18.5646 14.3876 18.5327C14.5867 18.5008 14.789 18.5534 15.1935 18.6587L15.5619 18.7546C16.9857 19.125 17.6977 19.3102 18.0814 18.9204C18.4651 18.5305 18.2666 17.8238 17.8695 16.4103L17.7668 16.0446C17.6539 15.643 17.5975 15.4421 17.6259 15.243C17.6543 15.0438 17.7642 14.8689 17.9841 14.519L18.1843 14.2006C18.9582 12.9693 19.3451 12.3538 19.0867 11.864C18.8282 11.3742 18.0957 11.3345 16.6304 11.2552L16.2513 11.2346C15.8349 11.2121 15.6267 11.2009 15.4451 11.1097C15.2636 11.0185 15.1292 10.8578 14.8605 10.5363L14.616 10.2436Z">
                                </path>
                                <path
                                    d="M14.2581 4.95201L14.4335 5.45209C14.6262 6.00137 14.7226 6.27602 14.91 6.47833C15.0975 6.68064 15.3548 6.78772 15.8693 7.00187L16.3378 7.19685C18.1489 7.95046 19.0543 8.32728 19.1576 9.09746C19.2006 9.41806 19.0927 9.71845 18.8415 10.0542C18.7566 10.0311 18.6748 10.0125 18.598 9.99675C18.0937 9.8943 17.4524 9.8597 16.7987 9.82453L16.3294 9.79914C16.2391 9.79425 16.169 9.79042 16.1089 9.78649C16.069 9.73991 16.0231 9.685 15.964 9.61427L15.6615 9.25236C15.2395 8.74716 14.8266 8.25287 14.4426 7.90972C14.0331 7.54377 13.3486 7.06647 12.4271 7.2142C11.4958 7.36349 10.999 8.04109 10.7311 8.52474C10.4828 8.97282 10.2595 9.57252 10.0333 10.1797L9.86994 10.6184C9.84224 10.6925 9.82011 10.7519 9.80065 10.8029C9.74948 10.8234 9.69006 10.8468 9.61579 10.8758L9.17932 11.0468C8.57472 11.2834 7.97821 11.5169 7.53405 11.7724C7.05609 12.0474 6.38399 12.5554 6.25073 13.4908C6.11872 14.4173 6.61219 15.0937 6.98573 15.4949C7.26413 15.7939 7.63817 16.1092 8.03755 16.4324C6.53434 16.8402 5.73475 16.9924 5.28031 16.5018C4.76865 15.9495 5.03339 14.9484 5.56285 12.9459L5.69984 12.4279C5.8503 11.8589 5.92553 11.5744 5.8877 11.2922C5.84987 11.0101 5.70326 10.7623 5.41005 10.2667L5.1431 9.81543C4.11127 8.07126 3.59536 7.19919 3.93993 6.50529C4.28449 5.81139 5.26133 5.75521 7.21504 5.64286L7.72048 5.6138C8.27567 5.58188 8.55326 5.56591 8.79532 5.43676C9.03738 5.3076 9.2165 5.07988 9.57475 4.62444L9.90089 4.20979C11.1616 2.60708 11.792 1.80571 12.5166 1.92914C13.2412 2.05257 13.5802 3.01905 14.2581 4.95201Z">
                                </path>
                            </svg>
                            Voter et Gagner
                        </a>
                    </div>
                @endif
                <div class="relative border rounded-2xl border-steel-200">
                    <div class="flex justify-center px-8 pt-8 pb-4 text-white">
                        <svg class="mr-2 w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="30"
                            height="30" viewBox="0 0 30 30">
                            <path
                                d="M7.77762 5.75119C8.33332 5.37988 8.9168 5.05783 9.52138 4.78708C11.2362 4.01911 12.0936 3.63513 13.2344 4.37413C14.375 5.11314 14.375 6.32539 14.375 8.74989V10.6249C14.375 12.9819 14.375 14.1604 15.1073 14.8926C15.8395 15.6249 17.018 15.6249 19.375 15.6249H21.25C23.6745 15.6249 24.8868 15.6249 25.6258 16.7655C26.3648 17.9062 25.9808 18.7636 25.2128 20.4785C24.942 21.0831 24.62 21.6666 24.2488 22.2222C22.9439 24.1751 21.0893 25.6971 18.9194 26.596C16.7495 27.4947 14.3619 27.7299 12.0583 27.2717C9.75479 26.8135 7.63887 25.6825 5.97812 24.0217C4.31737 22.361 3.18638 20.2451 2.72818 17.9416C2.26998 15.638 2.50515 13.2504 3.40394 11.0805C4.30273 8.91064 5.82478 7.05603 7.77762 5.75119Z">
                            </path>
                            <path
                                d="M26.8075 8.83602C25.7927 6.26014 23.7396 4.20699 21.1637 3.19223C19.2369 2.43312 17.5 4.17871 17.5 6.24978V11.2498C17.5 11.9401 18.0596 12.4998 18.75 12.4998H23.75C25.8211 12.4998 27.5666 10.7629 26.8075 8.83602Z">
                            </path>
                        </svg>
                        <span class="my-auto text-lg font-medium">Statistiques</span>
                    </div>
                    <div class="px-8 pt-4">
                        <h1 class="text-4xl font-semibold text-steel-100">
                            {{ $users }}
                        </h1>
                        <h2 class="text-lg font-semibold text-white">
                            Joueurs inscrits
                        </h2>
                    </div>
                    <div class="px-8 py-8">
                        <h1 class="text-4xl font-semibold text-steel-100">
                            {{ theme_config('record_connection') }}
                        </h1>
                        <h2 class="text-lg font-semibold text-white">
                            Record de connectés
                        </h2>
                    </div>
                </div>
                @if (theme_config('mount_offer_enable') === 'true')
                    <a href="{{ theme_config('mount_offer_link') }}"
                        target="{{ theme_config('mount_offer_link_type') }}">
                        <div class="relative border rounded-2xl border-steel-200">
                            <div class="flex justify-center px-8 pt-8 pb-4 text-white">
                                <svg class="mr-2 w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="34"
                                    height="34" viewBox="0 0 34 34">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M20.7747 3.2999C21.2996 3.03748 21.9378 3.25022 22.2002 3.77507L25.3185 10.0117C27.2354 10.1589 28.4383 10.5349 29.2145 11.495C30.4902 13.0731 29.9814 15.4481 28.9635 20.1979L28.3564 23.0312C27.6665 26.2506 27.3216 27.8604 26.1527 28.8053C24.9838 29.7502 23.3376 29.7502 20.045 29.7502H13.9548C10.6623 29.7502 9.016 29.7502 7.84715 28.8053C6.6783 27.8604 6.33336 26.2506 5.64348 23.0312L5.03633 20.1979C4.01851 15.4481 3.5096 13.0731 4.78538 11.495C5.5615 10.535 6.76438 10.159 8.68124 10.0117L11.7995 3.77507C12.062 3.25022 12.7002 3.03748 13.225 3.2999C13.7499 3.56233 13.9626 4.20055 13.7002 4.72539L11.1007 9.92436C11.7853 9.9169 12.5322 9.9169 13.3477 9.9169H20.6522C21.4676 9.9169 22.2145 9.9169 22.899 9.92436L20.2996 4.72539C20.0371 4.20055 20.2499 3.56233 20.7747 3.2999ZM10.2707 17.0002C10.2707 16.4134 10.7464 15.9377 11.3332 15.9377H22.6665C23.2533 15.9377 23.729 16.4134 23.729 17.0002C23.729 17.587 23.2533 18.0627 22.6665 18.0627H11.3332C10.7464 18.0627 10.2707 17.587 10.2707 17.0002ZM14.1665 20.1877C13.5797 20.1877 13.104 20.6634 13.104 21.2502C13.104 21.837 13.5797 22.3127 14.1665 22.3127H19.8332C20.42 22.3127 20.8957 21.837 20.8957 21.2502C20.8957 20.6634 20.42 20.1877 19.8332 20.1877H14.1665Z">
                                    </path>
                                </svg>

                                <span class="my-auto text-lg font-medium">Offre du moment</span>
                            </div>
                            <div class="px-8 pb-8">
                                <p class="font-medium text-white">{{ theme_config('mount_offer_name') }}</p>
                                <div class="flex gap-3 mt-2">
                                    <p
                                        class="text-[1.8rem] leading-none text-purple font-semibold line-through decoration-2">
                                        {{ theme_config('mount_offer_price_reduction') }}</p>
                                    <p class="text-[1.8rem] leading-none text-white font-semibold">
                                        {{ theme_config('mount_offer_price') }}</p>
                                    <p
                                        class="flex justify-end items-end text-[1.2rem] leading-none text-white font-semibold">
                                        EUR</p>
                                </div>
                                <div class="flex gap-3 mt-4">
                                    <svg class="my-auto fill-purple" xmlns="http://www.w3.org/2000/svg" width="15"
                                        height="21" viewBox="0 0 15 21">
                                        <path
                                            d="M0.414519 1.43632C1.04182 0.0830078 3.19444 0.0830078 7.49968 0.0830078C11.8049 0.0830078 13.9575 0.0830078 14.5848 1.43632C14.6387 1.55265 14.6843 1.67349 14.7208 1.7977C15.147 3.2427 13.6249 4.9175 10.5806 8.26711L8.54134 10.4997L10.5806 12.7323C13.6249 16.0819 15.147 17.7567 14.7208 19.2017C14.6843 19.3258 14.6387 19.4467 14.5848 19.563C13.9575 20.9163 11.8049 20.9163 7.49968 20.9163C3.19444 20.9163 1.04182 20.9163 0.414519 19.563C0.360602 19.4467 0.315113 19.3258 0.278478 19.2017C-0.147647 17.7567 1.37448 16.0819 4.41874 12.7323L6.45801 10.4997L4.41874 8.26711C1.37448 4.9175 -0.147647 3.2427 0.278478 1.7977C0.315113 1.67349 0.360602 1.55265 0.414519 1.43632Z"
                                            fill="#C190FF"></path>
                                    </svg>
                                    <p class="my-auto text-sm font-bold text-purple" id="offer_countdown"
                                        data-expiredate="{{ theme_config('mount_offer_end_date') }}T00:00">Chargement ...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
                @if (theme_config('discord_embed_enable') === 'true')
                    <div id="discord_embed" data-discordguild="{{ theme_config('discord_embed_id') }}"
                        class="relative overflow-hidden border rounded-2xl border-steel-200">
                        <div class="flex justify-between px-8 pt-8">
                            <svg class="flex-none w-10 h-10 transition fill-white group-hover:fill-steel-50"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.14 96.36">
                                <path
                                    d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,46,96.12,53,91.08,65.69,84.69,65.69Z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1 px-8">
                            <h1 class="mt-4 text-sm font-semibold tracking-wide text-white">Rejoignez nos</h1>
                            <h1 class="flex text-xl font-semibold tracking-wide text-white">
                                <span id="discord_count" class="flex mr-1.5">
                                    <svg class="my-auto animate-spin h-3.5 w-3.5 text-white" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                                Joueurs
                            </h1>
                            <p class="mt-2 text-sm font-medium leading-6 tracking-wide text-steel-100">Discutez et partagez
                                votre expérience de jeu avec d'autres joueurs sur notre Discord.</p>
                        </div>
                        <div class="mt-8 scale-105 swiper-container discord-1 -rotate-6">
                            <div class="swiper-wrapper">
                            </div>
                        </div>
                        <div class="mt-4 swiper-container discord-2 -rotate-6">
                            <div class="swiper-wrapper">
                            </div>
                        </div>
                        <div class="flex items-end justify-end px-8 pb-8 mt-6">

                            @php
                                $discordLink = null;
                                foreach (social_links() as $link) {
                                    if ($link->title == 'Discord') {
                                        $discordLink = $link;
                                    }
                                }
                            @endphp



                            <a @if (!$discordLink) disabled @else target="_blank" @endif
                                class="@if (!$discordLink) cursor-not-allowed @endif flex px-4 py-3 text-xs font-medium text-white transition duration-200 rounded-xl bg-steel-400 hover:bg-steel-200"
                                @if ($discordLink) href="{{ $discordLink->value ?? '' }}" @endif>
                                <svg class="w-4 h-4 my-auto mr-2 fill-white" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 127.14 96.36">
                                    <path
                                        d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,46,96.12,53,91.08,65.69,84.69,65.69Z">
                                    </path>
                                </svg>
                                <span class="my-auto tracking-wide">
                                    @if ($discordLink)
                                        Rejoindre
                                    @else
                                        Non disponible
                                    @endif
                                </span>
                            </a>

                        </div>
                    </div>
                @endif
            </div>

            <div class="flex flex-col w-full col-span-12 gap-10 mt-10 xl:col-span-9 xl:pl-10 xl:mt-0">
                @if ($posts->isEmpty())
                    <div class="px-4 py-5 border rounded-2xl bg-steel-400 border-steel-200">
                        <div class="flex">
                            <div class="flex-shrink-0 my-auto">
                                <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33"
                                    height="33" viewBox="0 0 33 33" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex items-center justify-between flex-1 ml-4">
                                <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
                                    Aucun article n'a été publié pour le moment.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach ($posts->sortByDesc('is_pinned')->take(3) as $post)
                    <div class="relative w-full border rounded-2xl border-steel-200">







                        @if ($post->is_pinned)
                            <svg class="absolute w-12 h-12 p-1 rounded-full fill-white -top-4 -left-4 bg-steel-300"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM14.1096 8.41878L15.592 9.90258C16.598 10.9095 17.1009 11.413 16.9836 11.9557C16.8662 12.4985 16.2003 12.7487 14.8684 13.2491L13.9463 13.5955C13.5896 13.7295 13.4113 13.7965 13.2736 13.9157C13.2134 13.9679 13.1594 14.027 13.1129 14.0918C13.0068 14.2397 12.9562 14.4236 12.855 14.7913C12.6249 15.6276 12.5099 16.0457 12.2359 16.202C12.1205 16.2679 11.9898 16.3025 11.8569 16.3023C11.5416 16.3018 11.2352 15.9951 10.6225 15.3818L10.1497 14.9086L8.531 16.5299C8.23835 16.823 7.76348 16.8234 7.47034 16.5308C7.17721 16.2381 7.17683 15.7632 7.46948 15.4701L9.08892 13.848C9.08871 13.8482 9.08914 13.8478 9.08892 13.848L8.64262 13.4C8.03373 12.7905 7.72929 12.4858 7.72731 12.1723C7.72645 12.0368 7.76164 11.9035 7.82926 11.786C7.98568 11.5145 8.40079 11.4 9.23097 11.1711C9.5993 11.0696 9.78346 11.0188 9.9315 10.9123C9.99792 10.8644 10.0583 10.8088 10.1114 10.7465C10.2298 10.6076 10.2956 10.4281 10.4271 10.069L10.7611 9.15753C11.2545 7.81078 11.5013 7.1374 12.0455 7.01734C12.5896 6.89728 13.0963 7.40445 14.1096 8.41878Z" />
                            </svg>
                        @endif





















                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex w-full sm:items-center gap-x-5">
                                    <div class="relative flex-shrink-0">
                                        <img class="absolute z-10 h-10 mx-auto text-transparent rounded-lg shadow-xl"
                                            src="{{ $post->author->getAvatar() }}" alt="{{ $post->author->name }}">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-steel-300">
                                            <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4">
                                                </circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="grow">
                                        <div class="flex items-center justify-between gap-2">
                                            <div>
                                                <div
                                                    class="hs-tooltip inline-block [--prevent-popper:*] [--trigger:hover] [--placement:bottom]">
                                                    <div class="block text-left cursor-pointer hs-tooltip-toggle">
                                                        <span class="font-semibold text-white">
                                                            {{ $post->author->name }}
                                                        </span>
                                                        <div class="absolute z-10 invisible inline-block max-w-xs transition-opacity shadow-lg opacity-0 cursor-default hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible bg-steel-200 rounded-xl"
                                                            role="tooltip">
                                                            <div class="p-4 sm:p-5">
                                                                <div
                                                                    class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                                                                    <div class="flex-shrink-0">
                                                                        <img class="absolute z-50 h-6 mx-auto text-transparent rounded-full shadow-xl"
                                                                            src="{{ $post->author->getAvatar() }}"
                                                                            alt="{{ $post->author->name }}">
                                                                        <div
                                                                            class="flex items-center justify-center w-6 h-6 rounded-full bg-steel-300">
                                                                            <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24">
                                                                                <circle class="opacity-25" cx="12"
                                                                                    cy="12" r="10"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="4">
                                                                                </circle>
                                                                                <path class="opacity-75"
                                                                                    fill="currentColor"
                                                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                                </path>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex grow">
                                                                        <p
                                                                            class="my-auto text-sm font-semibold text-white">
                                                                            {{ $post->author->name }}
                                                                        </p>
                                                                        <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold"
                                                                            style="{{ $post->author->role->getBadgeStyle() }};">
                                                                            {{ $post->author->role->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="text-xs text-steel-100">
                                                    <li
                                                        class="relative inline-block pr-6 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-100 before:rounded-full">
                                                        {{ $post->created_at->format('d/m/Y' . ' à ' . 'H:i') }}
                                                    </li>
                                                    <li
                                                        class="relative inline-block pr-6 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-100 before:rounded-full">
                                                        @php
                                                            $contenu_article = $post->content; // Récupérez le contenu de $post->content
                                                            // Supprimez toutes les balises HTML
                                                            $texte_sans_balises = strip_tags($contenu_article);
                                                            // Compter le nombre de caractères
                                                            $nombre_de_caracteres = strlen($texte_sans_balises);
                                                            // Estimation du temps de lecture moyen (supposons 200 mots par minute)
                                                            $temps_de_lecture_minutes = ceil($nombre_de_caracteres / 1000);
                                                        @endphp
                                                        {{ $temps_de_lecture_minutes }} minutes
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div type="button"
                                                    class="py-1.5 px-3.5 sm:py-2 sm:px-4 inline-flex justify-center items-center gap-x-1.5 sm:gap-x-2 font-medium align-middle focus:outline-none text-xs sm:text-sm text-white rounded-lg bg-steel-400">
                                                    {{ $post->created_at->format('d/m/Y') }}
                                                </div>
                                            </diV>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6 space-y-3">
                                <h2 class="text-xl font-bold text-white break-all md:text-2xl line-clamp-2">
                                    {{ $post->title }}</h2>
                                <p class="text-lg font-medium break-all text-steel-100 line-clamp-2">
                                    {{ $post->description }}</p>
                            </div>
                            @if ($post->hasImage())
                                <div class="mb-8 aspect-w-12 aspect-h-7">
                                    <img class="object-cover rounded-2xl bg-steel-200" src="{{ $post->imageUrl() }}">
                                </div>
                            @endif
                            <div class="hs-collapse w-full overflow-hidden transition-[height] duration-300 space-y-5 text-white text-sm break-all leading-5 article hidden mb-8"
                                id="readmore_{{ $post->slug }}">
                                {!! $post->content !!}
                            </div>

                            <div class="flex flex-wrap gap-4 leading-6">
                                <button id="like" type="button" @guest disabled @endguest
                                    data-like-url="{{ route('posts.like', $post) }}"
                                    class="p-4 flex-auto w-64 rounded-xl flex items-center justify-center shadow-sm @guest cursor-not-allowed @endguest btn bg-steel-400 hover:bg-steel-200 hs-tooltip-toggle font-medium @if ($post->isLiked()) active @endif align-middle transition duration-200 text-sm text-white">
                                    <svg class="w-4 h-4 mr-2 fill-white" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z">
                                        </path>
                                    </svg>
                                    <span class="likes-count">{{ $post->likes->count() }}</span>
                                    <span class="hidden d-none spinner-border spinner-border-sm load-spinner"
                                        role="status"></span>
                                </button>

                                <a href="http://{{ request()->getHost() }}/news/{{ $post->slug }}"
                                    class="flex items-center justify-center flex-auto w-64 p-4 text-sm font-medium text-white align-middle transition duration-200 shadow-sm hover:bg-steel-200 rounded-xl bg-steel-400">
                                    <svg class="w-4 h-4 mr-2 fill-white" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 11.094 21.8795 10.2162 21.6537 9.38161C21.5684 9.06633 21.1987 8.94083 20.9028 9.0791C20.3248 9.34916 19.68 9.5 19 9.5C16.5147 9.5 14.5 7.48528 14.5 5C14.5 4.31996 14.6508 3.67516 14.9209 3.09722C15.0592 2.80131 14.9337 2.4316 14.6184 2.3463C13.7838 2.12048 12.906 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22Z" />
                                        <circle cx="19" cy="5" r="3" />
                                    </svg>
                                    {{ $post->comments->count() }}
                                </a>

                                <div
                                    class="relative flex items-center justify-center flex-auto w-64 text-sm font-medium text-white align-middle transition-all rounded-lg hs-dropdown">
                                    <button type="button" id="blog-article-share-dropdown"
                                        class="inline-flex items-center justify-center w-full p-4 text-sm font-medium text-white transition duration-200 shadow-sm hover:bg-steel-200 hs-dropdown-toggle rounded-xl bg-steel-400 ">
                                        <svg class="w-4 h-4 mr-2 fill-white" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z" />
                                        </svg>
                                        Partager
                                    </button>
                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mb-1 z-50 bg-steel-200 shadow-2xl rounded-xl p-2"
                                        aria-labelledby="blog-article-share-dropdown">
                                        <input id="link_share_{{ $post->slug }}" class="hidden"
                                            value="{{ request()->getHost() }}/news/{{ $post->slug }}">
                                        <button
                                            onclick="document.getElementById('link_share_{{ $post->slug }}').select();document.getElementById('link_share_{{ $post->slug }}').setSelectionRange(0, 99999);document.execCommand('copy');navigator.clipboard.writeText(document.getElementById('link_share_{{ $post->slug }}').value);"
                                            class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100">
                                            <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.25 9C1.25 5.27208 4.27208 2.25 8 2.25H12C15.7279 2.25 18.75 5.27208 18.75 9C18.75 12.7279 15.7279 15.75 12 15.75H10C9.58579 15.75 9.25 15.4142 9.25 15C9.25 14.5858 9.58579 14.25 10 14.25H12C14.8995 14.25 17.25 11.8995 17.25 9C17.25 6.10051 14.8995 3.75 12 3.75H8C5.10051 3.75 2.75 6.10051 2.75 9C2.75 10.3451 3.25487 11.5705 4.08664 12.4998C4.36288 12.8085 4.33662 13.2826 4.02797 13.5589C3.71933 13.8351 3.24518 13.8088 2.96894 13.5002C1.90054 12.3065 1.25 10.7283 1.25 9ZM12 9.75C9.10051 9.75 6.75 12.1005 6.75 15C6.75 17.8995 9.10051 20.25 12 20.25H16C18.8995 20.25 21.25 17.8995 21.25 15C21.25 13.6549 20.7451 12.4295 19.9134 11.5002C19.6371 11.1915 19.6634 10.7174 19.972 10.4411C20.2807 10.1649 20.7548 10.1912 21.0311 10.4998C22.0995 11.6935 22.75 13.2717 22.75 15C22.75 18.7279 19.7279 21.75 16 21.75H12C8.27208 21.75 5.25 18.7279 5.25 15C5.25 11.2721 8.27208 8.25 12 8.25H14C14.4142 8.25 14.75 8.58579 14.75 9C14.75 9.41421 14.4142 9.75 14 9.75H12Z" />
                                            </svg>
                                            Copier le lien
                                        </button>
                                        <a target="_blank"
                                            class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100"
                                            href="http://twitter.com/share?text={{ theme_config('twitter_share_message') }}&url=https://{{ request()->getHost() }}/news/{{ $post->slug }}&hashtags={{ site_name() }}">
                                            <svg class="w-4 h-4 fill-white hover:fill-steel-50"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="flex-none w-4 h-4 transition fill-white group-hover:fill-steel-50"
                                                viewBox="0 0 512 512">
                                                <path
                                                    d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z">
                                                </path>
                                            </svg>
                                            Partager sur X
                                        </a>
                                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100"
                                            href="mailto:[Adresse e-mail]?subject={{ $post->title }}&body=https://{{ request()->getHost() }}/news/{{ $post->slug }}">
                                            <svg class="w-4 h-4 fill-white hover:fill-steel-50" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M22 6C22 7.65685 20.6569 9 19 9C17.3431 9 16 7.65685 16 6C16 4.34315 17.3431 3 19 3C20.6569 3 22 4.34315 22 6Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M14 5H10C6.22876 5 4.34315 5 3.17157 6.17157C2 7.34315 2 9.22876 2 13C2 16.7712 2 18.6569 3.17157 19.8284C4.34315 21 6.22876 21 10 21H14C17.7712 21 19.6569 21 20.8284 19.8284C22 18.6569 22 16.7712 22 13C22 11.5466 22 10.3733 21.9329 9.413C21.1453 10.0905 20.1205 10.5 19 10.5C18.5213 10.5 18.0601 10.4253 17.6274 10.2868L16.2837 11.4066C15.3973 12.1452 14.6789 12.7439 14.0448 13.1517C13.3843 13.5765 12.7411 13.8449 12 13.8449C11.2589 13.8449 10.6157 13.5765 9.95518 13.1517C9.32112 12.7439 8.60271 12.1452 7.71636 11.4066L5.51986 9.57617C5.20165 9.31099 5.15866 8.83807 5.42383 8.51986C5.68901 8.20165 6.16193 8.15866 6.48014 8.42383L8.63903 10.2229C9.57199 11.0004 10.2197 11.5384 10.7666 11.8901C11.2959 12.2306 11.6549 12.3449 12 12.3449C12.3451 12.3449 12.7041 12.2306 13.2334 11.8901C13.7803 11.5384 14.428 11.0004 15.361 10.2229L16.2004 9.52335C15.1643 8.69893 14.5 7.42704 14.5 6C14.5 5.65638 14.5385 5.32175 14.6115 5.0002C14.4133 5 14.2096 5 14 5Z" />
                                            </svg>
                                            Envoyer par Mail
                                        </a>
                                    </div>
                                </div>
                                <button id="hs-unstyled-collapse" data-hs-collapse="#readmore_{{ $post->slug }}"
                                    class="flex items-center justify-center flex-auto w-64 p-4 text-sm font-medium text-white align-middle transition duration-200 shadow-sm hover:bg-steel-200 hs-collapse-toggle hs-collapse-open:hidden rounded-xl bg-steel-400">
                                    <svg class="w-4 h-4 my-auto mr-2 fill-white" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2 12C2 13.6394 2.42496 14.1915 3.27489 15.2957C4.97196 17.5004 7.81811 20 12 20C16.1819 20 19.028 17.5004 20.7251 15.2957C21.575 14.1915 22 13.6394 22 12C22 10.3606 21.575 9.80853 20.7251 8.70433C19.028 6.49956 16.1819 4 12 4C7.81811 4 4.97196 6.49956 3.27489 8.70433C2.42496 9.80853 2 10.3606 2 12ZM12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25Z" />
                                    </svg>
                                    <span class="my-auto tracking-wide">Afficher plus</span>
                                </button>

                            </div>






                        </div>
                    </div>
                @endforeach
                <a class="flex items-center justify-center w-full p-4 text-sm font-medium text-white align-middle transition duration-200 shadow-sm hover:bg-steel-200 rounded-xl bg-steel-400"
                    href="/news">
                    <svg class="w-4 h-4 mr-2 fill-white hover:fill-steel-50" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M1.25 21C1.25 20.5858 1.58579 20.25 2 20.25L22 20.25C22.4142 20.25 22.75 20.5858 22.75 21C22.75 21.4142 22.4142 21.75 22 21.75L2 21.75C1.58579 21.75 1.25 21.4142 1.25 21ZM1.25 3C1.25 2.58579 1.58579 2.25 2 2.25L22 2.25C22.4142 2.25 22.75 2.58579 22.75 3C22.75 3.41421 22.4142 3.75 22 3.75L2 3.75C1.58579 3.75 1.25 3.41421 1.25 3Z" />
                        <path
                            d="M4 12C4 13.8856 4 14.8284 4.58579 15.4142C5.17157 16 6.11438 16 8 16L16 16C17.8856 16 18.8284 16 19.4142 15.4142C20 14.8284 20 13.8856 20 12C20 10.1144 20 9.17157 19.4142 8.58579C18.8284 8 17.8856 8 16 8H8C6.11438 8 5.17157 8 4.58579 8.58579C4 9.17158 4 10.1144 4 12Z" />
                    </svg>
                    Lire plus d'articles
                </a>
            </div>
        </div>
    </main>
@endsection
