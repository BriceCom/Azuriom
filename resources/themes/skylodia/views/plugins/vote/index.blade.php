@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <h1 class="fw-light">Gagne des <b class="fw-bold">récompenses<br/> gratuitement</b> en soutenant le serveur</h1>
    <div class="minecraft-steps pb-4 ps-5 pt-4">
        <ul class="list-unstyled d-flex flex-column gap-2">
            <li>
                Votes en quelques étapes :
            </li>
            <li class="d-flex align-items-center gap-2 py-1">
                <span class="minecraft-steps__number">1</span>
                <p class="m-0">Clique sur un <b>site de vote disponible</b></p>
            </li>
            <li class="d-flex align-items-center gap-2 py-1">
                <span class="minecraft-steps__number">2</span>
                <p class="m-0">Vote sur le site et <b>récupère ta récompense en jeu</b>.</p>
            </li>
        </ul>
    </div>

    <div class="my-10 mt-4">
        <div class="card-body text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                    <div class="col-md-6 col-lg-4">
                        <div class="mb-3">
                            <input type="text" id="stepNameInput" name="name" class="form-control"
                                   value="{{ $name }}"
                                   placeholder="{{ trans('messages.fields.name') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ trans('messages.actions.continue') }}
                            <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="@guest d-none @endguest h-100 d-flex align-items-center flex-wrap gap-5" data-vote-step="2">
                @forelse($sites as $site)
                    @php
                        $hours = intdiv($site->vote_delay, 60); // Récupère le nombre d'heures entières
                        $minutes = $site->vote_delay % 60;
                    @endphp

                    <a
                        href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                        data-vote-id="{{ $site->id }}"
                        data-vote-url="{{ route('vote.vote', $site) }}"
                        @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth
                        class="vote-site card card-bottom-shadow p-1 text-decoration-none">
                        <div class="card card-gradient-from-bottom">
                            <div class="d-flex align-items-center justify-content-between py-2 p-3">
                                <div class="d-flex flex-column">
                                    <span class="h5 text-uppercase text-white mb-1">{{$site->name}}</span>
                                    <span class="opacity-75 vote-timer w-fit">{{Carbon\CarbonInterval::hours($hours)->minutes($minutes)->format('%hh%Im')}}</span>
                                </div>
                                <i class="ps-4 p-2"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_d_3_115)">
                                            <path d="M1.98568 15L10 7.5L1.98568 0L0 1.85824L6.02865 7.5L0 13.1418L1.98568 15Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_3_115" x="0" y="0" width="10" height="18" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                <feOffset dy="3"/>
                                                <feComposite in2="hardAlpha" operator="out"/>
                                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.17 0"/>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3_115"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3_115" result="shape"/>
                                            </filter>
                                        </defs>
                                    </svg>
                                </i>
                            </div>
                        </div>
                    </a>

                @empty
                    <div class="alert alert-warning" role="alert">
                        {{ trans('vote::messages.errors.site') }}
                    </div>
                @endforelse
            </div>

            <div class="d-none" data-vote-step="3">
                <p id="vote-result"></p>
            </div>
        </div>
    </div>

    @auth
        <p class="py-5 vote-amount h3 text-white text-center">Vous avez voté <b class="mx-1 vote-count">{{ $userVotes }}</b> fois ce mois-ci !</p>
    @endauth

    <div class="card card-bottom-shadow p-2">
        <div class="card card-gradient-from-bottom">
            <div class="">
                <div class="d-flex justify-content-between align-items-center py-3 px-3">
                    <h3 class="text-white text-uppercase h5">Classement des votes du mois</h3>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">Classement</th>
                            <th scope="col">Joueur</th>
                            <th scope="col">Récompense</th>
                            <th scope="col">Nombre de vote</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($votes as $id => $vote)
                            <tr class="align-middle">
                                <th scope="row">
                                    <div class="vote-id w-fit p-1">
                                        {{ $id }}
                                    </div>
                                </th>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="vote-avatar">
                                            <img src="https://mc-heads.net/body/{{$vote->user->name}}" class="object-fit-cover" width="28" height="40" alt="{{ $vote->user->name }}">
                                        </div> {{ $vote->user->name }}
                                    </div>
                                </td>
                                <td>{!! theme_config('vote.reward.'.$id) !!}</td>
                                <td><b>{{ $vote->votes }}</b></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($displayRewards)
    <div class="card card-bottom-shadow p-2 mt-10">
        <div class="card card-gradient-from-bottom">
            <div>
                <div class="d-flex justify-content-between align-items-center py-3 px-3">
                    <h3 class="text-uppercase h5 text-white">Récompenses</h3>
                </div>

                <table class="table mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        <th scope="col">{{ trans('vote::messages.fields.chances') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($rewards as $reward)
                        <tr>
                            <th scope="row">
                                @if($reward->image)
                                    <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="45">
                                @endif
                                {{ $reward->name }}
                            </th>
                            <td>{{ $reward->chances }} %</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

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
