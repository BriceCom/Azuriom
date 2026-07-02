@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div class="text-center mb-5">
        <h2>{{theme_config('vote.content.title') ? theme_config('vote.content.title'):'Votez pour notre serveur'}}</h2>
        <p>{{theme_config('vote.content.paragraph') ? theme_config('vote.content.paragraph'):'Soutenez le serveur et remporter de nombreux cadeaux'}}</p>
    </div>

    <div class="text-center position-relative mb-5 pb-md-5" id="vote-card">
        <div class="spinner-parent h-100">
            <div class="spinner-border text-primary" role="status"></div>
        </div>

        <div class="@auth d-none @endauth" data-vote-step="1">
            <form class="row justify-content-center" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <input type="text" id="stepNameInput" name="name" class="form-control"
                               value="{{ $name }}"
                               placeholder="{{ trans('messages.fields.name') }}" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('messages.actions.continue') }} <i class="bi bi-arrow-right ms-2"></i>
                            <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="@guest d-none @endguest row justify-content-between gy-2 h-100 mb-5" data-vote-step="2">
            @forelse($sites as $site)
                @php
                    $hours = intdiv($site->vote_delay, 60); // Récupère le nombre d'heures entières
                    $minutes = $site->vote_delay % 60;
                @endphp
                <div class="col-md-6 vote-link-wrapper">
                    <a class="vote-link py-2 px-4 text-uppercase btn position-relative d-flex align-items-center justify-content-center" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                       data-vote-id="{{ $site->id }}"
                       data-vote-url="{{ route('vote.vote', $site) }}"
                       @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                        <i class="bi bi-heart"></i>
                        <div class="vote-link-name">
                            <span class="ms-3 me-5">VOTER SUR {{ $site->name }}</span>
                        </div>
                        <small aria-hidden="true" tabindex="1">{{Carbon\CarbonInterval::hours($hours)->minutes($minutes)->format('%hh%I')}}</small>
                        <div class="d-none dungeons-loader position-absolute">
                            <svg width="30" height="45" viewBox="0 0 30 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15 0L0 30L15 45L30 30L15 0ZM15 36.1919L7.5783 28.7702L15 13.9268L22.4217 28.7702L15 36.1919Z" fill="#9E3EFF"/>
                            </svg>
                        </div>
                        <span class="badge bg-secondary text-white vote-timer"></span>
                    </a>
                </div>
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

    <div class="text-center pt-5 mt-5">
        <h2>{{theme_config('vote.classement.title') ? theme_config('vote.classement.title'):trans('vote::messages.sections.top')}}</h2>
        <p>{{theme_config('vote.classement.paragraph') ? theme_config('vote.classement.paragraph'):'Soutenez le serveur et remporter de nombreux cadeaux'}}</p>
    </div>

    <div class="my-5 pb-4">
        @auth
        <div class="table-responsive mb-5 container px-0">
            <table class="vote-classement table table-striped mb-0">
                <tbody>
                    @foreach($votes->where('user.id', Auth::id()) as $id => $vote)
                        <tr></tr>
                        <tr class="d-flex align-items-center">
                            <th scope="row" class="col-2 ps-4 pe-2">
                                <span>#{{ $id }}</span>
                            </th>
                            <td class="username col-7 px-2 d-flex align-items-center" >
                                <div class="position-relative">
                                    <img class="rounded rounded-3 me-3 position-absolute top-50 start-0 avatar" src="{{ $vote->user->getAvatar() }}" height="45" alt="Votre avatar Minecraft">
                                    <span>{{ $vote->user->name }}</span>
                                </div>
                            </td>
                            <td class="col-3 d-flex align-items-center justify-content-end text-end text-nowrap px-4 flex-grow-1">
                                <span>
                                    <b>{{ $vote->votes }}</b> votes
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endauth

        <div class="table-responsive container px-0">
            <table class="vote-classement table table-striped mb-0">
                <tbody>
                    @php $i=0 @endphp
                    @foreach($votes as $id => $vote)
                        <tr class="d-flex align-items-center">
                            <th scope="row" class="col-2 ps-4 pe-2 align-middle align-text-bottom">
                                <span>#{{ $id }}</span>
                            </th>
                            <td class="username col-2 px-2 align-middle">
                                <div class="position-relative">
                                    <img class="rounded rounded-3 me-3 position-absolute top-50 start-0 avatar" src="{{ $vote->user->getAvatar() }}" height="45" alt="Avatar de {{ $vote->user->name }}">
                                    <span>{{ $vote->user->name }}</span>
                                </div>
                            </td>
                            <th @if (theme_config('vote.top-vote-reward.'.$loop->iteration) != '') scope="row" @endif class="col-4 px-2 text-center text-nowrap flex-grow-1">
                                @if($loop->iteration <= 4)
                                    <span class="px-4 py-2 text-uppercase">{{theme_config('vote.top-vote-reward.'.$loop->iteration) ? theme_config('vote.top-vote-reward.'.$loop->iteration):''}}</span>
                                @endif
                            </th>
                            <td class="col-4 text-end text-nowrap px-4">
                                <span>
                                    <b>{{ $vote->votes }}</b> votes
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(display_rewards())
        <div class="text-center mb-4">
            <h2 class="mt-4">
                {{ trans('vote::messages.sections.rewards') }}
            </h2>
        </div>

                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
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
            background: rgba(26, 28, 30, 0.7);
            z-index: 10;
        }
    </style>
@endpush
