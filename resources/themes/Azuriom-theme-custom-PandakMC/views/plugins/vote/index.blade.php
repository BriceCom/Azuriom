@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <h1 class="d-none">{{ trans('vote::messages.sections.vote') }} pour {{site_name()}}</h1>

    <div class="row gx-9 gy-3">
        <div class="@if($displayRewards) col-md-9 @else col-md-12 @endif">
            <div class="card mb-4">
                <div class="card-body text-center position-relative p-2 px-4" id="vote-card">
                    <div class="spinner-parent h-100">
                        <div class="spinner-border text-white" role="status"></div>
                    </div>

                    <div class="@auth d-none @endauth text-start py-3 px-4" data-vote-step="1">
                        <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm"></form>
                        <span class="h5 fw-bold">Connexion requise</span>
                        <p class="m-0 mt-1 text-sm">Vous devez être connecté à votre compte pour pouvoir voter</p>
                    </div>

                    <div class="@guest d-none @endguest h-100 text-start" data-vote-step="2">
                        @forelse($sites as $site)
                            <a class="btn btn-primary rounded-4 m-1 text-dark text-xs text-uppercase" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                               data-vote-id="{{ $site->id }}"
                               data-vote-url="{{ route('vote.vote', $site) }}"
                               @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                                <span class="badge bg-secondary text-dark vote-timer"></span> {{ $site->name }}
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

        </div>


        @if($displayRewards)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title reward__title fw-bold text-center mb-5">
                            {{ trans('vote::messages.sections.rewards') }}
                        </h2>


                        <ul class="list-unstyled text-center ms-4">
                            @foreach($rewards as $reward)
                                <li class="mt-1">
                                    @if($reward->image)
                                        <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}"
                                             width="45">
                                    @endif
                                    <span class="ms-2">{{ $reward->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="card mt-6">
        <div class="card-body py-6">
            <h2 class="card-title d-none">
                {{ trans('vote::messages.sections.top') }} de vote de {{site_name()}}
            </h2>

            @if($votes->count() > 0)
            <div class="vote__topboard d-flex align-items-end justify-content-center gap-5 mb-4 mt-4">
                @foreach($votes->take(3) as $id => $vote)
                    <div class="vote__topboard-item">
                            <div class="vote__topboard-item__podium top-{{$id}}">
                            <div><span>{{$id}}</span></div>
                            <div><img src="https://mc-heads.net/head/{{$vote->user->name}}/100" alt="Avatar de {{$vote->user->name}}"></div>
                        </div>
                        <span class="vote__topboard-name">{{$vote->user->name}}</span>
                    </div>
                @endforeach
            </div>
            @endif

            <div class="table-responsive">
                <table class="table vote__top mb-0">
                    <thead class="table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" width="20">#</th>
                        <th scope="col">Récompense</th>
                        <th scope="col">PSEUDO</th>
                        <th scope="col">VOTES</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($votes->count() > 0)
                        @foreach($votes as $id => $vote)
                            <tr>
                                <th scope="row" width="20">{{ $id }}</th>
                                <th><div class="vote__reward top-{{ $id }}">
                                        {{theme_config("vote.index.reward.".$id) ?? "500 TORINS"}}
                                    </div></th>
                                <td>{{ $vote->user->name }}</td>
                                <td>{{ $vote->votes }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th scope="row" width="20">1</th>
                            <th><div class="vote__reward">
                                    {{theme_config("vote.index.reward.1") ?? "500 TORINS"}}
                                </div></th>
                            <td>{{site_name()}}</td>
                            <td>∞</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($ipv6compatibility)
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
