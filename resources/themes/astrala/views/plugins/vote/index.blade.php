@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <h1>{{ theme_config('vote.hero.title') ?? trans('vote::messages.sections.vote') }}</h1>
    <p class="w-75 opacity-75 mx-auto text-center">{{theme_config('vote.hero.subtitle') ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation."}}</p>
    <div class="col-12 col-md-8 p-0 card mb-4 mt-md-6 no-margin mx-auto">
        <div class="card-body text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth container-fluid" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                    <h2 class="text-uppercase h6 mt-2 mb-3">Étape 1 sur 2 - <span class="opacity-50">entre ton pseudo</span> </h2>
                    <div class="col-md-6 col-lg-6 d-flex flex-column flex-md-row align-items-center gap-2 gap-md-0 custom-card">
                        <div>
                            <input type="text" id="stepNameInput"
                                   name="name"
                                   class="form-control"
                                   pattern="[^\s]+"
                                   maxlength="16"
                                   value="{{ $name }}"
                                   placeholder="Ton pseudo" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ trans('messages.actions.continue') }}
                            <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="@guest d-none @endguest h-100 container-fluid" data-vote-step="2">
                <h2 class="text-uppercase h6 mt-2 mb-3">Etape 2 sur 2 - <span class="opacity-50">vote sur les sites</span></h2>
                <div class="row align-items-center justify-content-center flex-wrap gap-3">
                    @forelse($sites as $site)
                        <a class="col-md-3 btn btn-primary vote-link fs-6" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
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
            </div>

            <div class="d-none" data-vote-step="3">
                <p id="vote-result"></p>
            </div>
        </div>
    </div>
    <div class="row flex-column align-items-center justify-content-md-center mt-5">
        <div class="col-12 col-md-8 p-0">
            <div class="table-custom">
                <div class="container-fluid">
                    <div class="table-custom-header row px-3 px-md-4 mb-2 mb-md-3">
                        <div class="col-5 p-0">
                            <span class="text-uppercase">Place</span>
                        </div>
                        <div class="col-6 p-0">
                            <span class="text-uppercase">Récompenses</span>
                        </div>
                        <div class="col-1 p-0">
                            <span class="text-uppercase">Vote</span>
                        </div>
                    </div>
                    <div class="table-custom-body">
                        <div class="gradient-circle"></div>
                        <div class="d-flex flex-column gap-2_5">
                            @foreach($votes->take(10) as $id => $vote)
                                <div class="row d-flex align-items-center custom-card">
                                    <span class="col-5 p-0 d-flex align-items-center gap-2_5">
                                        {{ $id }}
                                        <img class="avatar" src="{{ $vote->user?->getAvatar() != null ? $vote->user->getAvatar():'https://mc-heads.net/head/'.$vote->user_name.'/64.png' }}" height="40" alt="Minecraft avatar de {{ $vote->user_name }}">
                                        {{ $vote->user->name ?? $vote->user_name }}
                                    </span>
                                    <span class="col-6 p-0">{{theme_config('vote.top-vote-reward.'.$loop->iteration) ?? 'Aucune'}} <img class="ms-1" src="{{ theme_asset('images/illu_rubis.png') }}" alt="Rubis"></span>
                                    <span class="col-1 p-0">{{ $vote->votes }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    @if($displayRewards)--}}
{{--        <div class="card mt-4">--}}
{{--            <div class="card-body">--}}
{{--                <h2 class="card-title">--}}
{{--                    {{ trans('vote::messages.sections.rewards') }}--}}
{{--                </h2>--}}

{{--                <table class="table mb-0">--}}
{{--                    <thead class="table-dark">--}}
{{--                    <tr>--}}
{{--                        <th scope="col">{{ trans('messages.fields.name') }}</th>--}}
{{--                        <th scope="col">{{ trans('vote::messages.fields.chances') }}</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}

{{--                    @foreach($rewards as $reward)--}}
{{--                        <tr>--}}
{{--                            <th scope="row">--}}
{{--                                @if($reward->image)--}}
{{--                                    <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="45">--}}
{{--                                @endif--}}
{{--                                {{ $reward->name }}--}}
{{--                            </th>--}}
{{--                            <td>{{ $reward->chances }} %</td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}

{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

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
