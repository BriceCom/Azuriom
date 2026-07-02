@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <h1>{{ trans('vote::messages.sections.vote') }}</h1>

    <div class="card mb-4">
        <div class="card-body position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row  justify-content-center" action="{{ route('vote.verify-user', '') }}"
                      id="voteNameForm">
                    <div class="col-12">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-md-7 py-4">
                            <hgroup class="col-md-6">
                                <h3 class="h5">{{theme_config('vote.title') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, vero."}}</h3>
                                <p class="mb-0">{{theme_config('vote.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis eos
                                    facilis natus nesciunt quisquam sed."}}</p>
                            </hgroup>
                            <div class="flex-grow-1 text-end">
                                <input type="text" id="stepNameInput" name="name" class="form-control"
                                       value="{{ $name }}"
                                       placeholder="{{ trans('messages.fields.name') }}" required>
                                <button type="submit" class="btn btn-primary mt-3">
                                    {{ trans('messages.actions.continue') }}
                                    <span class="d-none spinner-border spinner-border-sm load-spinner"
                                          role="status"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="@guest d-none @endguest h-100 d-flex flex-wrap align-items-center gap-3" data-vote-step="2">
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
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">
                {{ trans('vote::messages.sections.top') }}
            </h2>

            <table class="table mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        @if(theme_config('vote.rewards.on'))
                            <th scope="col">{{ theme_config('vote.rewards.text') ?? 'Lorem' }}</th>
                        @endif
                        <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($votes as $id => $vote)
                    <tr>
                        <th scope="row">
                            <div>
                                #{{ $id }}
                                <span class="ms-2">
                                    <img aria-hidden="true" src="{{$vote->user->getAvatar(32)}}" alt="{{$vote->user->name}}">
                                </span>
                            </div>
                        </th>
                        <td>{{ $vote->user->name }}</td>
                        @if(theme_config('vote.rewards.on'))
                            <td>{{theme_config('vote.rewards.top.'.$id) ? theme_config('vote.rewards.top.'.$id) : ''}}</td>
                        @endif
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
