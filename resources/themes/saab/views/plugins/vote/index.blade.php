@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div class="mb-4">
        <h1>
            {{theme_config('vote.title') ?? trans('vote::messages.sections.vote')}}
        </h1>
        <p class="fs-5">
            {{theme_config('vote.subtitle') ?? "Sous-titre"}}
        </p>
    </div>

    <div class="card mb-8">
        <div class="card-body text-center position-relative py-5" id="vote-card">
            <div class="d-flex justify-content-center flex-wrap gap-5 mb-4">
                <h3 class="m-0 h6 fw-semibold d-flex align-items-center gap-2">
                    <span
                        class="stepper login-step bg-danger d-flex justify-content-center align-items-center text-white rounded-pill">1</span>
                    S'identifier
                </h3>
                <h3 class="m-0 h6 fw-semibold d-flex align-items-center gap-2">
                    <span
                        class="stepper voting-step bg-danger d-flex justify-content-center align-items-center text-white rounded-pill">2</span>
                    Voter
                </h3>
                <h3 class="m-0 h6 fw-semibold d-flex align-items-center gap-2">
                    <span
                        class="stepper reward-step d-flex justify-content-center align-items-center text-white rounded-pill">3</span>
                    Récupérer la récompense
                </h3>
            </div>

            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                    <div class="col-md-7 d-flex gap-4 align-items-center">
                        <div class="flex-grow-1">
                            <input type="text" id="stepNameInput" name="name" class="form-control"
                                   value="{{ $name }}"
                                   placeholder="Votre pseudonyme Minecraft" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ trans('messages.actions.continue') }}
                            <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="@guest d-none @endguest h-100" data-vote-step="2">
                @forelse($sites as $site)
                    <a class="btn btn-primary mx-2" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
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

    <div class="row flex-column-reverse flex-lg-row justify-content-between">
        @if($displayRewards)
            <div class="col-lg-4 mt-8 mt-lg-0">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">
                            {{ trans('vote::messages.sections.rewards') }}
                        </h2>

                        <ul class="list-unstyled d-flex flex-column gap-3">
                            @foreach($rewards as $reward)
                                <li>
                                    @if($reward->image)
                                        <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" height="45">
                                    @endif
                                    {{ $reward->name }}
                                    <span
                                        class="d-inline-flex mb-3 px-1 text-xs fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2">{{ $reward->chances }} %</span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        {{theme_config('vote.classement.title') ?? trans('vote::messages.sections.top') }}
                    </h2>
                    <p>{{theme_config('vote.classement.subtitle') ?? "Sous-titre"}}</p>

                    <div class="text-end">
                        <div
                            class="d-flex align-items-end justify-content-end gap-3 px-4"
                            style="height: auto;">
                            @foreach($votes->take(3) as $id => $vote)
                                <div
                                    class="top-vote d-flex align-items-center flex-column justify-content-md-end {{ $loop->iteration == 1 ? 'order-2' : ($loop->iteration == 3 ? 'order-3' : '') }}">
                                    <canvas data-rank="{{ $id }}"
                                            data-skin-url="{{ 'https://mineskin.eu/skin/'.$vote->user->name }}"></canvas>
                                    <span class="top-vote__podium fw-semibold text-xs"
                                          style="height: {{ $loop->iteration == 1 ? '80px' : ($loop->iteration == 3 ? '60px' : '50px') }};                                        "
                                    >
                                      {{ $vote->user->name }}

                                      <i
                                          style="color: {{ $loop->iteration == 1 ? '#FFD700' : ($loop->iteration == 3 ? '#808080' : '#B08D57') }}"
                                          class=" d-block bi bi-trophy-fill text-center fs-5"></i>
                                  </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="classement">
                        <table class="table mb-0">
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ trans('messages.fields.name') }}</th>
                                <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($votes as $id => $vote)
                                <tr class="align-middle">
                                    <th scope="row">#{{ $id }}</th>
                                    <td><img class="rounded-2 me-2" src="{{$vote->user->getAvatar(24)}}"
                                             alt=""> {{ $vote->user->name }}</td>
                                    <td>{{ $vote->votes }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    @auth
                        <p class="mt-3 text-end text-xs fw-semibold">{{ trans_choice('vote::messages.votes', $userVotes) }}</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>

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
        .stepper {
            width: 24px;
            height: 24px;
        }

        .reward-step{
            background-color: var(--bs-danger);
        }

        #vote:has(.voting) .voting-step {
            background-color: rgb(46, 175, 96) !important;
        }

        #vote:has(.alert-success) .reward-step {
            background: rgb(46, 175, 96);
            animation: vote-temp 0.2s 3.5s ease-in forwards;
        }


        #vote:has([data-vote-step="1"].d-none) .login-step {
            background-color: rgb(46, 175, 96) !important;
        }

        #vote-card .spinner-parent {
            display: none;
        }

        @keyframes vote-temp {
            from {
                background: rgb(46, 175, 96);
            }
            to {
                background: var(--bs-secondary);
            }
        }

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
