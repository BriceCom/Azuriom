@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <hgroup>
        <h1>{{ theme_config('vote.title') ?? trans('vote::messages.sections.vote') }}</h1>
        @if(theme_config('vote.text'))
            <p class="col-lg-6 text-muted">{{ theme_config('vote.text') }}</p>
        @endif
    </hgroup>

    <div class="card  mb-15">
        <div class="card-body position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-start" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                    @if(theme_config('vote.logout.text'))
                        <p>
                            {{ theme_config('vote.logout.text') }}
                        </h2>
                    @endif
                    <div class="col-lg-6 d-flex flex-column flex-md-row align-items-md-center gap-3">
                            <input type="text" id="stepNameInput" name="name" class="form-control w-100"
                                   value="{{ $name }}"
                                   placeholder="{{ trans('messages.fields.name') }}" required>

                        <button type="submit" class="w-fit btn btn-primary">
                            {{ trans('messages.actions.continue') }}
                            <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="@guest d-none @endguest h-100" data-vote-step="2">
                @forelse($sites as $site)
                    <a class="btn btn-primary m-1" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
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


    <h2 class="mb-3">
                {{ trans('vote::messages.sections.top') }}
        </h2>

    <div class="card mb-15">
        <div class="card-body">
            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Top</th>
                    <th scope="col">{{ trans('theme::theme.player') }}</th>
                    @if(theme_config('vote.rewards.on'))
                        <th scope="col">{{ theme_config('vote.rewards.text') ?? 'Lorem' }}</th>
                    @else
                        <th scope="col">
                            Reward
                        </th>
                    @endif
                    <th scope="col" class="text-end">{{ trans('vote::messages.fields.votes') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($votes as $id => $vote)
                    <tr>
                        <th scope="row">
                            <div>
                                #{{ $id }}
                            </div>
                        </th>
                        <td>
                            <span>
                                <img aria-hidden="true" class="rounded" src="{{$vote->user->getAvatar(32)}}" width="32" alt="{{$vote->user->name}}">
                            </span>
                            <span class="ms-2">{{ $vote->user->name }}</span>
                        </td>
                        @if(theme_config('vote.rewards.on'))
                            <td>
                                <span class="badge text-dark py-2.5 px-2.5" style="background-color: {{theme_config('vote.rewards.topColor.'.$id) ? theme_config('vote.rewards.topColor.'.$id) : '#282828'}};">
                                    {{theme_config('vote.rewards.top.'.$id) ? theme_config('vote.rewards.top.'.$id) : ''}}
                                </span>
                            </td>
                        @else
                            <td>
                                <span class="badge py-2.5 px-2.5 text-white" style="background-color: #282828">
                                    1000 gems
                                </span>
                            </td>
                        @endif
                        <td class="text-end">{{ $vote->votes }}</td>
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

    <h2 class="card-title">
        {{ trans('vote::messages.sections.rewards') }}
    </h2>
        <div class="card mt-4">
            <div class="card-body">

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
