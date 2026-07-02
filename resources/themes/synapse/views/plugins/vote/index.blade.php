@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <h1>{{ trans('vote::messages.sections.vote') }}</h1>

    <div class="mb-4">
        <div class="text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
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

            <div class="@guest d-none @endguest h-100" data-vote-step="2">
                @forelse($sites as $site)
                    <a class="btn btn-primary" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
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

            <div class="d-none" data-vote-step="server">
                <p>{{ trans('vote::messages.server') }}</p>

                <div id="server-select"></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">
                {{ trans('vote::messages.sections.top') }}
            </h2>

            <div class="w-25 mx-auto my-5">
                <div class="d-flex flex-column">
                    <div
                        class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-md-between"
                        style="height: auto;">
                        @forelse($votes->take(3) as $id => $vote)
                            <div
                                class="w-25 d-flex align-items-center flex-column {{ $loop->iteration == 1 ? 'order-sm-2' : ($loop->iteration == 3 ? 'order-sm-3 mt-md-4' : 'mt-md-3') }}">
                                @if(game()->name() === 'Minecraft')
                                    <canvas data-rank="{{ $id }}"
                                            data-skin-url="{{ 'https://mineskin.eu/skin/'.$vote->user->name }}"></canvas>
                                @else
                                    <img class="mb-2" src="{{$vote->user->getAvatar()}}" alt="Avatar {{$vote->user->name}}">
                                @endif
                                <span class="badge"
                                      style="background-color: {{ $loop->iteration == 1 ? '#FFD700' : ($loop->iteration == 3 ? '#808080' : '#B08D57') }}; color: {{ $loop->iteration == 1 ? '#000000' : ($loop->iteration == 3 ? '#ffffff' : '#000000') }}"
                                >{{ $vote->user->name }}</span>
                            </div>
                        @empty
                            {{trans('theme::theme.home.no_vote')}}
                        @endforelse
                    </div>
                </div>
            </div>

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
                    <tr>
                        <th scope="row">#{{ $id }}</th>
                        <td>{{ $vote->user->name ?? '' }}</td>
                        <td>{{ $vote->votes }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            @auth
                <p class="mt-3 mb-0">{{ trans_choice('vote::messages.votes', $userVotes) }}</p>
            @endauth
        </div>
    </div>

    @if($displayRewards)
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">
                    {{ trans('vote::messages.sections.rewards') }}
                </h2>

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
    @endif

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>

    @if($ipv6compatibility)
        <script src="https://cdn.ipv6-adapter.com/v1/api.js" async defer></script>
    @endif

    <script src="{{ plugin_asset('vote', 'js/vote.js?v12') }}" defer></script>
    @auth
        <script>
            window.username  = '{{ $user->name }}';
        </script>
    @endauth
@endpush

@push('styles')
    <style>
        #vote-card .btn:not(:last-child) {
            margin-right: 0.5rem;
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
