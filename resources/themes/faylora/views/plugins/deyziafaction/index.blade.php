@extends('layouts.base')

@section('title', trans('vote::messages.title'))

@php
$totalVotes = \Azuriom\Plugin\Vote\Models\Vote::where('created_at', '>', now()->startOfMonth())->count()
@endphp

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        @include('elements.widgets.home_widget')
        <div class="w-full col-span-12 xl:col-span-9 mt-10 xl:mt-0 xl:pl-10">
            <div class="bg-steel-100 rounded-2xl">
                <div class="flex flex-raw items-center justify-start py-6 px-8 bg-steel-200 rounded-t-2xl">
                    <div class="flex justify-center items-center w-auto">
                        <img class="-mt-10 rounded-lg mx-auto z-50 w-24" src="{{ theme_asset('img/fish.png') }}">
                        <div class="ml-6 w-full mr-4 text-ellipsis truncate">
                            <h1 class="text-white font-semibold text-2xl">Voter & Gagner</h1>
                            <p class="text-xs text-steel-50 font-medium">Votez dès maintenant et gagnez des récompenses
                                en jeu !</p>
                        </div>
                    </div>
                </div>
                <div class="p-8 space-y-6 relative" id="vote-card">
                    <div class="bg-steel-300 md:p-16 p-8 rounded-2xl grid lg:grid-cols-2 grid-cols-1 md:gap-16 gap-8">
                        <div>
                            <h1 class="text-white md:text-6xl text-3xl font-semibold">Vote & Gagne <span
                                    class="text-primary">1
                                    Clé Vote</span></h1>
                        </div>
                        <div class="flex flex-raw gap-8 justify-center items-center">
                            <div class="flex flex-col justify-center items-center lg:h-40 lg:w-40 h-32 w-32">
                                <img class="w-full " src="{{ theme_asset('img/key.png') }}" alt="">
                                <span class="mt-2 text-danger text-xs font-medium text-center">1x Clef de vote</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-steel-300 md:p-16 p-8 rounded-2xl">
                        <div class="grid lg:grid-cols-2 grid-cols-1 md:gap-16 gap-8 w-full">
                            <div class="flex flex-col gap-4">
                                <h1 class="text-white text-xl font-semibold">
                                    Classement du mois
                                </h1>
                                <span class="text-white font-bold text-3xl">Toi aussi vote pour Deyzia et gagne</span>
                                <div class="h-1 w-16 bg-steel-50 rounded-full"></div>
                                <span class="text-white font-bold text-2xl">Déja <span class="text-primary">5555</span>
                                    votes ce
                                    mois</span>
                            </div>
                            <div
                                class="flex flex-raw h-full justify-center items-end my-auto mx-auto md:scale-100 md:mb-0 -mb-7 scale-75">
                                @foreach ($factionsTop->slice(0, 3) as $faction)
                                <div
                                    class="text-ellipsis relative @if($loop->iteration === 2) -order-1 @elseif($loop->iteration === 1) ml-6 mr-6 @endif">
                                    <img src="{{ 'https://minotar.net/armor/body/' . $faction->leaderName }}"
                                        class="w-11 flex mx-auto justify-center items-center shadow-2xl">
                                    <div
                                        class="flex w-16 bg-steel-200 @if($loop->iteration === 1) h-40 @elseif($loop->iteration === 2) h-32 @else h-28 @endif rounded-t-xl items-start">
                                        <div class="mx-auto w-12 mt-4">
                                            <div class="flex relative justify-center items-center h-full">
                                                <img class="absolute h-8 rounded-md shadow-xl mx-auto z-50"
                                                    src="https://mc-heads.net/avatar/{{ $faction->leaderName }}/150.png">
                                                <div
                                                    class="h-8 w-8 bg-steel-300 flex justify-center items-center rounded-lg">
                                                    <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="text-white text-xs text-center mt-1 text-ellipsis truncate">
                                                {{ $faction->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex absolute justify-center items-center -bottom-1 -right-2">
                                        <div class="flex space-x-2">
                                            <p
                                                class="absolute right-7 bottom-4 text-white @if($loop->iteration === 1) text-lg @elseif($loop->iteration === 2) text-sm @else text-xs @endif font-semibold z-[999] shadow-2xl">
                                                #{{ $loop->iteration }}</p>
                                            <img class="@if($loop->iteration === 1) h-14 w-14 @elseif($loop->iteration === 2) h-11 w-11 @else h-10 w-10 @endif mx-auto flex"
                                                src="{{ theme_asset('img/cup' . $loop->iteration . '.png' ) }}">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-steel-100 rounded-2xl p-8">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left">
                                        <th class="p-0">
                                            <div class="flex items-center h-11 py-3 px-6 rounded-l-xl bg-steel-200">
                                                <label class="ml-2 text-xs text-white  font-semibold">ID</label>
                                            </div>
                                        </th>
                                        <th class="p-0">
                                            <div class="flex items-center h-11 py-3 px-6 bg-steel-200">
                                                <span class="text-xs text-white  font-semibold">Pseudo</span>
                                            </div>
                                        </th>
                                        <th class="p-0">
                                            <div class="flex items-center h-11 py-3 px-6 rounded-r-xl bg-steel-200">
                                                <span class="text-xs text-white font-semibold">Vote</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factionsTop->slice(0, 10) as $id => $faction)
                                    <tr>
                                        <td class="p-0">
                                            <p class="text-steel-50 md:text-sm text-xs font-medium pl-9">{{ $id }}</p>
                                        </td>
                                        <td class="p-0">
                                            <div class="flex items-center h-16 px-6">
                                                <span class="md:text-sm text-xs font-medium text-steel-50">{{
                                                    $faction->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-0">
                                            <div class="flex items-center h-16 px-6">
                                                <span class="md:text-sm text-xs font-medium text-steel-50">{{
                                                    $faction->leaderName }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
