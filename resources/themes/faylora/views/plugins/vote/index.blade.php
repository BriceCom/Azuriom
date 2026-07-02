@extends('layouts.base')

@section('title', trans('vote::messages.title'))

@php
$totalVotes = \Azuriom\Plugin\Vote\Models\Vote::where('created_at', '>', now()->startOfMonth())->count()
@endphp

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        @guest
        <div class="w-full col-span-12 flex flex-col mb-10">
            <div class="flex w-full py-4 px-5 bg-primary rounded-2xl text-white text-sm justify-between">
                <div class="text-sm font-medium my-auto truncate">
                    Connectez vous pour pouvoir voter
                </div>
                <button class="bg-white/30 rounded-lg py-2 px-4 truncate" data-ripple-dark="true"
                    data-hs-overlay="#login_modal" data-ng="link">
                    Je me connecte
                </button>
            </div>
        </div>
        @endguest
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
                    <div class="spinner-parent h-full">
                        <div class="spinner-border text-white" role="status"><svg
                                class="animate-spin h-16 w-16 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg></div>
                    </div>
                    <div id="status-message"></div>
                    <div class="hidden" data-vote-step="1">
                        <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}"
                            id="voteNameForm">
                            <div class="col-md-6 col-lg-4">
                                <div class="mb-3">
                                    <input type="text" id="stepNameInput" name="name" class="form-control"
                                        value="{{ $name }}" placeholder="{{ trans('messages.fields.name') }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ trans('messages.actions.continue') }}
                                    <span class="hidden spinner-border spinner-border-sm load-spinner"
                                        role="status"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-4 sm:gap-6 @guest hidden @endguest"
                        data-vote-step="2">
                        @forelse($sites as $id => $site)
                        <a class="group flex flex-col bg-steel-300 shadow-sm rounded-xl hover:shadow-md transition relative"
                            href="{{ $site->url }}" target="_blank" data-vote-id="{{ $site->id }}"
                            rel="noopener noreferrer" data-vote-url="{{ route('vote.vote', $site) }}" @auth
                            data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth
                            data-ripple-dark="true">
                            <span
                                class="badge text-white vote-timer absolute bg-danger rounded z-10 text-center"></span>
                            <div class="relative flex justify-between items-cente p-8 overflow-hidden">
                                <div>
                                    <p class="text-white md:text-lg text-sm font-semibold">Site de vote n°{{ $id + 1 }}
                                    </p>
                                    <p class="text-sm text-steel-50 font-medium">
                                        {{
                                        Carbon\CarbonInterval::minutes($site->vote_delay)->cascade()->forHumans(['short'
                                        => true])
                                        ??
                                        '' }}
                                    </p>
                                </div>
                                <img class="absolute h-40 top-0 right-10 group-hover:scale-125 transition duration-300"
                                    src="{{ theme_asset('img/anvil.png') }}">
                                <div
                                    class="flex justify-center items-center group-hover:translate-x-2 transition duration-300 mr-2">
                                    <svg class="w-4 h-4 text-steel-50 group-hover:text-white" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="bg-danger col-span-2 p-8 text-center rounded-xl text-white text-2xl font-bold">Aucun
                            site de
                            vote</div>
                        <div class="bg-steel-200"></div>
                        @endforelse
                    </div>
                    <div class="hidden" data-vote-step="3">
                        <p id="vote-result"></p>
                    </div>
                    <div class="bg-steel-300 md:p-16 p-8 rounded-2xl">
                        <div class="grid lg:grid-cols-2 grid-cols-1 md:gap-16 gap-8 w-full">
                            <div class="flex flex-col gap-4">
                                <h1 class="text-white text-xl font-semibold">
                                    Classement du mois
                                </h1>
                                <span class="text-white font-bold text-3xl">Toi aussi vote pour Deyzia et gagne</span>
                                <div class="h-1 w-16 bg-steel-50 rounded-full"></div>
                                <span class="text-white font-bold text-2xl">Déja <span class="text-primary">{{
                                        $totalVotes }}</span>
                                    votes ce
                                    mois</span>
                            </div>
                            <div
                                class="flex flex-raw h-full justify-center items-end my-auto mx-auto md:scale-100 md:mb-0 -mb-7 scale-75">
                                @foreach ($votes->slice(0, 3) as $id => $vote)
                                <div
                                    class="text-ellipsis relative @if($id === 2) -order-1 @elseif($id === 1) ml-6 mr-6 @endif">
                                    <img src="{{ 'https://minotar.net/armor/body/' . $vote->user->name }}"
                                        class="w-11 flex mx-auto justify-center items-center shadow-2xl">
                                    <div
                                        class="flex w-16 bg-steel-200 @if($id === 1) h-40 @elseif($id === 2) h-32 @else h-28 @endif rounded-t-xl items-start">
                                        <div class="mx-auto w-12 mt-4">
                                            <div class="flex relative justify-center items-center h-full">
                                                <img class="absolute h-8 rounded-md shadow-xl mx-auto z-50"
                                                    src="{{ $vote->user->getAvatar(150) }}">
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
                                                {{ $vote->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex absolute justify-center items-center -bottom-1 -right-2">
                                        <div class="flex space-x-2">
                                            <p
                                                class="absolute right-7 bottom-4 text-white @if($id === 1) text-lg @elseif($id === 2) text-sm @else text-xs @endif font-semibold z-[999] shadow-2xl">
                                                #{{ $id }}</p>
                                            <img class="@if($id === 1) h-14 w-14 @elseif($id === 2) h-11 w-11 @else h-10 w-10 @endif mx-auto flex"
                                                src="{{ theme_asset('img/cup' . $id . '.png' ) }}">
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
                                    @foreach ($votes->slice(0, 10) as $id => $vote)
                                    <tr>
                                        <td class="p-0">
                                            <p class="text-steel-50 md:text-sm text-xs font-medium pl-9">{{ $id }}</p>
                                        </td>
                                        <td class="p-0">
                                            <div class="flex items-center h-16 px-6">
                                                <span class="md:text-sm text-xs font-medium text-steel-50">{{
                                                    $vote->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-0">
                                            <div class="flex items-center h-16 px-6">
                                                <span class="md:text-sm text-xs font-medium text-steel-50">{{
                                                    $vote->votes }}</span>
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

@push('scripts')
@if($ipv6compatibility)
<script src="https://cdn.ipv6-adapter.com/v1/api.js" async defer></script>
@endif

<script src="{{ plugin_asset('vote', 'js/vote.js') }}" defer></script>
@auth
<script>
    window.username  = '{{ $user->name }}';
</script>
@endauth
@endpush

@push('styles')
<style>
    #vote-card .spinner-parent {
        display: none;
    }

    .d-none {
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
        background: rgba(8, 8, 8, 0.6);
        z-index: 10;
        margin: 0;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }

    .disabled .badge {
        padding: 0.3rem 0.5rem;
    }

    .badge {
        top: 15px;
        right: 15px;
    }
</style>
@endpush
