@extends('layouts.app')
@section('title', trans('vote::messages.title'))
@section('content')
    <div class="container flex flex-col w-full col-span-12 mx-auto">
        <div class="relative w-full px-10 py-10 text-white border bg-steel-300 border-steel-200 rounded-2xl">
            <div class="grid w-full grid-cols-1 gap-8 lg:grid-cols-2 md:gap-16">
                <div class="flex flex-col gap-4 mb-40 lg:mb-8">
                    <div class="mt-5 sm:mt-10 lg:mt-0 lg:col-span-5">
                        <div class="space-y-2 md:space-y-4">
                            <h2 class="text-4xl font-bold text-white lg:text-5xl">
                                Gagne des récompenses en soutenant le serveur
                            </h2>
                            <p class="text-steel-50">
                                Vote en quelques étapes simples
                            </p>
                        </div>
                        <ul role="list" class="mt-4 space-y-2 sm:space-y-4">
                            <li class="flex space-x-3">
                                <div class="relative h-full my-auto">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 my-auto text-xs font-semibold text-center text-white rounded-full bg-steel-50">
                                        1
                                    </div>
                                </div>
                                <span class="text-sm sm:text-base text-steel-50">
                                    Clique sur <span class="font-bold text-white">un site de vote disponible</span>
                                </span>
                            </li>
                            <li class="flex space-x-3">
                                <div class="relative h-full my-auto">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 my-auto text-xs font-semibold text-center text-white rounded-full bg-steel-50">
                                        2
                                    </div>
                                </div>
                                <span class="text-sm sm:text-base text-steel-50">
                                    Vote sur le site et <span class="font-bold text-white">récupère ta récompense en
                                        jeu</span>
                                </span>
                            </li>
                        </ul>

                        <div class="@auth d-none @endauth" data-vote-step="1">
                            <form class="mt-8" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                                <div class="flex items-end gap-2">
                                    <div class="form-input">
                                        <label for="name" class="form-label">
                                            Votre pseudonyme Minecraft
                                        </label>
                                        <input type="text" id="stepNameInput" name="name" class="form-control"
                                               value="{{ $name }}"
                                               placeholder="{{ trans('messages.fields.name') }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('messages.actions.continue') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="@guest d-none @endguest h-100" data-vote-step="2">
                            <div id="vote-card"
                                 class="relative grid grid-cols-1 gap-3 mt-8 md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 sm:grid-cols-1 sm:gap-6">
                                <div class="grid place-items-center spinner-parent h-100 rounded-2xl">
                                    <svg class="size-10 animate-spin text-white"  role="status"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                @forelse($sites as $site)
                                    <a target="_blank"
                                       data-vote-url="{{ route('vote.vote', $site) }}"
                                       data-vote-id="{{ $site->id }}"
                                       @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}"
                                       @endauth
                                       class="flex transition duration-200 border shadow-sm group flex-co border-steel-200 rounded-xl hover:shadow-md hover:bg-steel-400 disablde:bg-red-500"
                                       href="{{ $site->url }}" rel="noopener noreferrer">
                                        <div class="w-full p-4 md:p-5">
                                            <div class="flex items-center justify-between">
                                                <div class="truncate">
                                                    <h3 class="text-sm font-medium group-hover:text-white text-steel-50">
                                                        {{ $site->name }}
                                                    </h3>
                                                    <p class="text-xs text-steel-100">
                                                            <?php
                                                            $voteDelay = $site->vote_delay; // Suppose que $site->vote_delay contient la valeur en minutes

                                                            if ($voteDelay < 60) {
                                                                // Si la valeur est inférieure à 60 minutes, affiche le nombre de minutes
                                                                echo $voteDelay . ' minutes';
                                                            } else {
                                                                // Si la valeur est de 60 minutes ou plus, calcule les heures et minutes
                                                                $hours = floor($voteDelay / 60);
                                                                $minutes = $voteDelay % 60;

                                                                echo $hours . 'h' . $minutes . 'm';
                                                            }
                                                            ?>
                                                    </p>
                                                </div>
                                                <div class="flex space-x-3 ps-3">
                                                    <div
                                                        class="my-auto text-sm bg-steel-200 px-3 rounded-2xl vote-timer"></div>
                                                    <svg class="flex-shrink-0 w-5 h-5 my-auto"
                                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path d="m9 18 6-6-6-6"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div
                                        class="flex items-center px-5 text-xs text-white alert bg-steel-200 rounded-xl text-start h-14"
                                        role="alert">
                                        {{ trans('vote::messages.errors.site') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="d-none" data-vote-step="3">
                            <p id="vote-result"></p>
                        </div>

                        <div class="d-none" data-vote-step="server">
                            <div class="flex space-x-3">
                                <div class="relative h-full my-auto">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 my-auto text-xs font-semibold text-center text-white rounded-full bg-steel-50">
                                        +
                                    </div>
                                </div>
                                <p class="text-sm sm:text-base text-steel-50 my-4 text-white font-bold">{{ trans('vote::messages.server') }}</p>
                            </div>

                            <div id="server-select" class="flex flex-wrap items-center gap-4"></div>
                        </div>
                    </div>
                    <h1 class="mt-4 text-xl font-bold text-white lg:text-2xl">
                        Votez régulièrement et hissez-vous au sommet du classement pour remporter des récompenses
                        exceptionnelles.
                    </h1>
                </div>
                <div class="flex items-end justify-center h-full mx-auto my-auto flex-raw">
                    <div class="relative ml-6 mr-6 text-ellipsis ">
                        <canvas id="skin_vote_1" data-name="{{ $votes[1]->user->name ?? '?' }}"
                                class="-top-[8rem] -left-[1rem] absolute flex mx-auto justify-center items-center"></canvas>
                        <div class="flex items-start w-16 h-40 bg-steel-200 rounded-t-xl">
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
                                    class="flex items-center justify-center w-12 h-6 px-1 mx-auto mt-3 text-white rounded-md bg-steel-400">
                                    <p class="ml-0.5 text-[0.6rem] font-semibold text-white mr-0.5 truncate">
                                        {{ theme_config('vote_award_1') }}</p>
                                    <img src="{{ theme_asset('static/coin.png') }}" class="h-3.5">
                                </div>
                            </div>
                        </div>
                        <div class="flex absolute justify-center items-center bottom-[19rem] w-full font-semibold">
                            #1
                        </div>
                    </div>
                    <div class="relative text-ellipsis -order-1 ">
                        <canvas id="skin_vote_2" data-name="{{ $votes[2]->user->name ?? '?' }}"
                                class="-top-[8rem] -left-[1rem] absolute flex mx-auto justify-center items-center"></canvas>
                        <div class="flex items-start w-16 h-32 bg-steel-200 rounded-t-xl">
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
                                    class="flex items-center justify-center w-12 h-6 px-1 mx-auto mt-3 text-white rounded-md bg-steel-400">
                                    <p class="ml-0.5 text-[0.6rem] font-semibold text-white mr-0.5 truncate">
                                        {{ theme_config('vote_award_2') }}</p>
                                    <img src="{{ theme_asset('static/coin.png') }}" class="h-3.5">
                                </div>
                            </div>
                        </div>
                        <div class="flex absolute justify-center items-center bottom-[17rem] w-full font-semibold">
                            #2
                        </div>
                    </div>
                    <div class="relative text-ellipsis ">
                        <canvas id="skin_vote_3" data-name="{{ $votes[3]->user->name ?? '?' }}"
                                class="-top-[8rem] -left-[1rem] absolute flex mx-auto justify-center items-center"></canvas>
                        <div class="flex items-start w-16 bg-steel-200 h-28 rounded-t-xl">
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
                                    class="flex items-center justify-center w-12 h-6 px-1 mx-auto mt-3 text-white rounded-md bg-steel-400">
                                    <p class="ml-0.5 text-[0.6rem] font-semibold text-white mr-0.5 truncate">
                                        {{ theme_config('vote_award_3') }}</p>
                                    <img src="{{ theme_asset('static/coin.png') }}" class="h-3.5">
                                </div>
                            </div>
                        </div>
                        <div class="flex absolute justify-center items-center bottom-[16rem] w-full font-semibold">
                            #3
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden border shadow-sm border-steel-100 rounded-xl ">
                            <div class="flex items-center justify-between gap-3 px-6 py-4 border-b border-steel-100">
                                <div class="flex gap-4">
                                    <svg class="flex-shrink-0 w-8 h-8 my-auto fill-white" viewBox="0 0 24 24"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.9999 8.16234L21.9999 8.23487C21.9999 9.09561 21.9999 9.52598 21.7927 9.8781C21.5855 10.2302 21.2093 10.4392 20.4569 10.8572L19.6636 11.298C20.2102 9.44984 20.3926 7.46414 20.4601 5.76597C20.4629 5.69316 20.4662 5.61945 20.4695 5.54497L20.4718 5.49279C21.1231 5.71896 21.4887 5.88758 21.7168 6.20408C22 6.59692 22 7.11873 21.9999 8.16234Z"/>
                                        <path
                                            d="M2 8.16234L2 8.23487C2.00003 9.09561 2.00004 9.52598 2.20723 9.8781C2.41442 10.2302 2.79063 10.4392 3.54305 10.8572L4.33681 11.2982C3.79007 9.45001 3.60767 7.46422 3.54025 5.76597C3.53736 5.69316 3.5341 5.61945 3.53081 5.54497L3.5285 5.49266C2.87701 5.7189 2.51126 5.88752 2.2831 6.20408C1.99996 6.59692 1.99997 7.11873 2 8.16234Z"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M16.3771 2.34674C15.2531 2.15709 13.7837 2 12.0002 2C10.2166 2 8.74724 2.15709 7.62318 2.34674C6.48445 2.53887 5.91508 2.63494 5.43937 3.22083C4.96365 3.80673 4.98879 4.43998 5.03907 5.70647C5.21169 10.0544 6.14996 15.4851 11.25 15.9657V19.5H9.8198C9.34312 19.5 8.93271 19.8365 8.83922 20.3039L8.65 21.25H6C5.58579 21.25 5.25 21.5858 5.25 22C5.25 22.4142 5.58579 22.75 6 22.75H18C18.4142 22.75 18.75 22.4142 18.75 22C18.75 21.5858 18.4142 21.25 18 21.25H15.35L15.1608 20.3039C15.0673 19.8365 14.6569 19.5 14.1802 19.5H12.75V15.9657C17.8503 15.4853 18.7886 10.0545 18.9612 5.70647C19.0115 4.43998 19.0367 3.80673 18.5609 3.22083C18.0852 2.63494 17.5159 2.53887 16.3771 2.34674Z"/>
                                    </svg>
                                    <div>
                                        <h2 class="w-64 text-xl font-semibold text-white truncate md:w-full">
                                            Classement des votes du mois
                                        </h2>
                                        <p class="text-sm text-steel-50">
                                            Gagne des récompenses en votant
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <div
                                            class="flex items-center px-3 py-2 text-sm font-medium text-white truncate border rounded-lg shadow-sm gap-x-2 border-steel-100 bg-steel-400">
                                            <span id="mount_countdown"></span>
                                            <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M12 22C16.9706 22 21 17.9706 21 13C21 8.02944 16.9706 4 12 4C7.02944 4 3 8.02944 3 13C3 17.9706 7.02944 22 12 22ZM12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V9C11.25 8.58579 11.5858 8.25 12 8.25Z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M9.25 2C9.25 1.58579 9.58579 1.25 10 1.25H14C14.4142 1.25 14.75 1.58579 14.75 2C14.75 2.41421 14.4142 2.75 14 2.75H10C9.58579 2.75 9.25 2.41421 9.25 2Z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="min-w-full divide-y divide-steel-100">
                                <thead class="bg-steel-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                                <span class="text-xs font-semibold tracking-wide text-white uppercase">
                                                    Classement
                                                </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                                <span class="text-xs font-semibold tracking-wide text-white uppercase">
                                                    Joueur
                                                </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                                <span class="text-xs font-semibold tracking-wide text-white uppercase">
                                                    Récompenses Mensuel
                                                </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                                <span class="text-xs font-semibold tracking-wide text-white uppercase">
                                                    Nombre de vote
                                                </span>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-steel-50">
                                @foreach ($votes as $id => $vote)
                                    <tr>
                                        <td class="w-10 h-px whitespace-nowrap">
                                            <div class="w-10 px-6 py-3">
                                                <div
                                                    class="flex items-center text-xs font-semibold tracking-wide text-white uppercase border rounded-lg h-7 w-7 justify-cenetr border-steel-100">
                                                        <span
                                                            class="flex items-center justify-center mx-auto text-center">
                                                            {{ $id }}
                                                        </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-px h-px whitespace-nowrap">
                                            <div>
                                                <div class="flex items-center gap-x-3">
                                                    <div
                                                        class="relative flex items-center justify-center w-8 h-8 overflow-hidden rounded-full shadow bg-steel-200">
                                                        <img class="flex object-contain mx-auto mt-2 shadow-xl w-7"
                                                             src="https://minotar.net/bust/{{ $vote->user->name }}/100.png"
                                                             alt="avatar">
                                                    </div>
                                                    <div class="grow">
                                                            <span
                                                                class="block text-sm font-semibold text-white">{{ $vote->user->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-px h-px whitespace-nowrap">
                                            <div class="px-6 py-3 w-max">
                                                <div
                                                    class="text-xs text-white font-semibold bg-steel-200 rounded-lg py-2 flex justify-center items-center gap-2 px-3.5 truncate">
                                                        <span class="my-auto">
                                                            @if ($id == 1)
                                                                {{ theme_config('vote_award_1') }}
                                                            @elseif ($id == 2)
                                                                {{ theme_config('vote_award_2') }}
                                                            @elseif ($id == 3)
                                                                {{ theme_config('vote_award_3') }}
                                                            @elseif ($id == 4)
                                                                {{ theme_config('vote_award_4') }}
                                                            @elseif ($id == 5)
                                                                {{ theme_config('vote_award_5') }}
                                                            @else
                                                                {{ theme_config('vote_award_all') }}
                                                            @endif
                                                        </span>
                                                    <img src="{{ theme_asset('static/coin.png') }}"
                                                         class="inline-block w-4 h-4">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-px h-px whitespace-nowrap">
                                            <div>
                                                <span class="text-sm text-white">{{ $vote->votes }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div
                                class="grid gap-3 px-6 py-4 border-t border-gray-200 md:flex md:justify-between md:items-center dark:border-gray-700">
                                <div>
                                    <p class="text-sm text-steel-50">
                                        <span class="font-semibold text-white"> {{ $votes->count() }} </span> joueur(s)
                                        ont voté ce mois-ci
                                    </p>
                                </div>
                            </div>
                        </div>
                        @if ($displayRewards)
                            <div class="mt-8 overflow-hidden border shadow-sm border-steel-100 rounded-xl ">
                                <div class="flex gap-4 px-6 py-4">
                                    <svg class="flex-shrink-0 w-8 h-8 my-auto fill-white" viewBox="0 0 24 24"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.5777 4.43152L15.5777 3.38197C13.8221 2.46066 12.9443 2 12 2C11.0557 2 10.1779 2.46066 8.42229 3.38197L8.10057 3.5508L17.0236 8.64967L21.0403 6.64132C20.3941 5.90949 19.3515 5.36234 17.5777 4.43152Z"/>
                                        <path
                                            d="M21.7484 7.96434L17.75 9.96353V13C17.75 13.4142 17.4142 13.75 17 13.75C16.5858 13.75 16.25 13.4142 16.25 13V10.7135L12.75 12.4635V21.904C13.4679 21.7252 14.2848 21.2965 15.5777 20.618L17.5777 19.5685C19.7294 18.4393 20.8052 17.8748 21.4026 16.8603C22 15.8458 22 14.5833 22 12.0585V11.9415C22 10.0489 22 8.86557 21.7484 7.96434Z"/>
                                        <path
                                            d="M11.25 21.904V12.4635L2.25164 7.96434C2 8.86557 2 10.0489 2 11.9415V12.0585C2 14.5833 2 15.8458 2.5974 16.8603C3.19479 17.8748 4.27062 18.4393 6.42228 19.5685L8.42229 20.618C9.71524 21.2965 10.5321 21.7252 11.25 21.904Z"/>
                                        <path
                                            d="M2.95969 6.64132L12 11.1615L15.4112 9.4559L6.52456 4.37785L6.42229 4.43152C4.64855 5.36234 3.6059 5.90949 2.95969 6.64132Z"/>
                                    </svg>
                                    <div>
                                        <h2 class="w-64 text-xl font-semibold text-white truncate md:w-full">
                                            Récompenses possibles
                                        </h2>
                                    </div>
                                </div>
                                <table class="min-w-full divide-y divide-steel-100">
                                    <thead class="bg-steel-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                    <span
                                                        class="text-xs font-semibold tracking-wide text-white uppercase">
                                                        {{ trans('messages.fields.name') }}
                                                    </span>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                    <span
                                                        class="text-xs font-semibold tracking-wide text-white uppercase">
                                                        {{ trans('vote::messages.fields.chances') }}
                                                    </span>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-steel-100">
                                    @foreach ($rewards as $reward)
                                        <tr>
                                            <td class="w-px h-px whitespace-nowrap">
                                                <div>
                                                    <div class="flex items-center gap-x-3">
                                                        @if ($reward->image)
                                                            <img class="flex w-5 shadow-xl object-contain mr-0.5"
                                                                 src="{{ $reward->imageUrl() }}"
                                                                 alt="{{ $reward->name }}">
                                                        @endif
                                                        <div class="grow">
                                                                <span
                                                                    class="block text-sm font-semibold text-white">{{ $reward->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="w-px h-px whitespace-nowrap">
                                                <div>
                                                    <span class="text-sm text-white">{{ $reward->chances }} %</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @if ($ipv6compatibility)
        <script src="https://cdn.ipv6-adapter.com/v1/api.js" async defer></script>
    @endif
    <script src="{{ plugin_asset('vote', 'js/vote.js') }}" defer></script>
    @auth
        <script>
            window.username = '{{ $user->name }}';
        </script>
    @endauth
@endpush
@push('styles')
    <style>
        #vote-card .spinner-parent {
            display: none;
        }

        #vote-card.voting .spinner-parent {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(70, 70, 70, 0.6);
            z-index: 10;
        }
    </style>
@endpush
