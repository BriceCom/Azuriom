@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div class="row">
        <div class="col-md-7">

            <div class="bg-gray-900 pb-2">
                <h1 class="mb-0 pt-2">{{ trans('vote::messages.sections.vote') }}</h1>
            </div>
            <div class="card bg-purple-900 mb-4">
                <div class="card-body text-center position-relative" id="vote-card">
                    <div class="spinner-parent h-100">
                        <div class="spinner-border text-white" role="status"></div>
                    </div>

                    <div class="text-center @auth d-none @endauth" data-vote-step="1">
                        <p class="mb-0">Vous devez vous <a href="{{route('login')}}">connecter</a> pour pouvoir voter.</p>
                    </div>

                    <div
                        class="d-flex flex-wrap gap-3 justify-content-start align-items-center @guest d-none @endguest h-100"
                        data-vote-step="2">
                        @forelse($sites as $site)
                            <a class="btn btn-primary mx-0" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                               data-vote-id="{{ $site->id }}"
                               data-vote-url="{{ route('vote.vote', $site) }}"
                               @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                                <span class="badge bg-secondary text-white vote-timer"></span> {{ $site->name }}
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

            <div class="card bg-purple-900">
                <div class="card-body">
                    <h2 class="text-uppercase text-purple-200 fs-5 text-start">{{theme_config('vote.classement.title')}}</h2>
                    <p class="fs-7 text-purple-200">{!! nl2br(theme_config('vote.classement.description')) !!}</p>

                    <div class="text-end">
                        <div
                            class="d-flex align-items-end justify-content-center gap-5 px-4 m-5"
                            style="height: auto;">
                            @foreach($votes->take(3) as $id => $vote)
                                <div
                                    class="top-vote d-flex align-items-center flex-column justify-content-center {{ $loop->iteration == 1 ? 'order-2' : ($loop->iteration == 3 ? 'order-3' : '') }}">
                                    <canvas data-rank="{{ $id }}"
                                            data-skin-url="{{ 'https://mineskin.eu/skin/'.$vote->user->name }}"></canvas>
                                    <span class="top-vote__podium fw-semibold text-xs"
                                          style="height: {{ $loop->iteration == 1 ? '80px' : ($loop->iteration == 3 ? '60px' : '50px') }};                                        "
                                    >
                                        <small class="d-block text-center text-white-50">{{ $vote->votes }}</small>
                                      {{ $vote->user->name }}


                                      <i
                                          style="color: {{ $loop->iteration == 1 ? '#FFD700' : ($loop->iteration == 3 ? '#808080' : '#B08D57') }}"
                                          class=" d-block bi bi-trophy-fill text-center fs-5"></i>
                                  </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="table-responsive pt-3">
                        <table class="table mb-0">
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">Rang</th>
                                <th scope="col">Joueur</th>
                                <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                                <th>Multiplicateur</th>
                                <th>Récompense</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($votes as $id => $vote)
                                <tr>
                                    <th scope="row">#{{ $id }}</th>
                                    <td>{{ $vote->user->name }}</td>
                                    <td>{{ $vote->votes }}</td>
                                    <td class="text-yellow-500">
                                        @if(isset(theme_config('vote.multiplicateur.index')[$loop->index]))
                                            {{theme_config('vote.multiplicateur.index')[$loop->index]['name']}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset(theme_config('vote.classement.index')[$loop->index]))
                                            {{theme_config('vote.classement.index')[$loop->index]['name']}}
                                            <span class="fs-7 text-purple-200">points boutique</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            @if($displayRewards)
                <div class="card bg-purple-900 mt-4 mt-md-0">
                    <div class="card-body">
                        <h2 class="text-uppercase text-purple-200 fs-5 text-start">RÉCOMPENSES POSSIBLES</h2>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-dark">
                                <tr>
                                    <th scope="col">Récompense</th>
                                    <th scope="col">{{ trans('vote::messages.fields.chances') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rewards as $reward)
                                    <tr>
                                        <th scope="row">
                                            @if($reward->image)
                                                <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}"
                                                     width="45">
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
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>
    <script>console.log('dzd')</script>

    @if($ipv6compatibility)
        <script src="https://cdn.ipv6-adapter.com/v1/api.js" async defer></script>
    @endif

    <script src="{{ plugin_asset('vote', 'js/vote.js') }}" defer></script>
    @auth
        <script>
            window.username = '{{ $user->name }}'
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
