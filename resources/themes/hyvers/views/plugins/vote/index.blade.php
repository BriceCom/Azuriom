@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <hgroup>
        <h1 class="mb-2">
            {{ theme_config('vote.title') ?? trans('vote::messages.sections.vote') . " pour ". site_name() }}
        </h1>
        @if(theme_config('vote.rewardText'))
            <p class="col-lg-8 mb-0">{{ theme_config('vote.text') }}</p>
        @endif
    </hgroup>

    <div>
        <div class="position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-start" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                    @include('vote::_components.session-user')
                </form>
            </div>

            <div class="@guest d-none @endguest h-100" data-vote-step="2">
                @php
                    $hasKnownVoteName = isset($sessionVoteName) && $sessionVoteName !== '';
                @endphp

                @include('vote::_components.known-session-user', [
                    'containerId' => 'vote-session-known-step2',
                    'containerClass' => 'mb-3',
                    'knownVoteName' => $sessionVoteName ?? null,
                    'isVisible' => $hasKnownVoteName,
                    'avatarId' => 'vote-session-avatar-step2',
                    'nameId' => 'vote-session-name-step2'
                ])

                <p class="mb-1">{{theme_config('vote.chooseSiteText') ?? "Choisissez sur quel site voter"}}</p>
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

    @include("plugins.vote._components.rewards")
    @include("plugins.vote._components.top")
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
