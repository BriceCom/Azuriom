@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <h1 class="text-center">{{ theme_config('vote.hero.title') ?? trans('vote::messages.sections.vote') }}</h1>
    <div class="col-12 col-md-8 p-0 card mb-4 mt-md-6 no-margin mx-auto">
        <div class="card-body text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth container-fluid" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                    <h2 class="text-uppercase h6 mt-2 mb-3">1/2 • <span>Saisi ton pseudonyme</span> </h2>
                    <div class="col-md-6 col-lg-6 d-flex flex-column flex-md-row align-items-center gap-2 gap-md-0 custom-card justify-content-center">
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
                <h2 class="text-uppercase h6 mt-2 mb-3">2/2 • <span>Vote sur un des sites</span></h2>
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
    <h2 class="text-center pt-4 pt-md-8">Classement</h2>
    <div class="row flex-column align-items-center justify-content-md-center mt-5">
        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-sm-end gap-5 gap-md-7 my-5 mt-md-5 mb-md-8">
            @foreach($votes->take(3) as $id => $vote)
                <div class="{{ $loop->iteration == 1 ? 'order-sm-2 mb-sm-5' : ($loop->iteration == 3 ? 'order-sm-3 mb-sm-3' : '') }}">
                    <div class="d-flex flex-column align-items-center align-items-{{ $loop->iteration == 1 ? 'sm-center' : ($loop->iteration == 3 ? 'sm-end' : 'sm-start') }} justify-content-{{ $loop->iteration == 1 ? 'sm-center' : ($loop->iteration == 3 ? 'sm-end' : 'sm-start') }}"
                         style="color: {{ $loop->iteration == 1 ? '#FFD700' : ($loop->iteration == 3 ? '#808080' : '#B08D57') }}"
                    >
                        <h3 class="text-center h2">{{ $id }}</h3>
                        <span class="d-block fw-semibold text-sm">{{ $vote->user->name ?? '' }}</span>
                        <span class="d-block fw-semibold h5 mb-3">{{ $vote->votes }} votes</span>
                    </div>
                    <div class="text-center">
                        <img src="https://mc-heads.net/player/{{ $vote->user->name ?? '' }}" height="{{$loop->iteration == 1 ? '200' : '180'}}" alt="Avatar de {{ $vote->user->name ?? '' }}">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12 col-md-8 p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        <th scope="col">Récompenses</th>
                        <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($votes as $id => $vote)
                        <tr class="align-middle">
                            <td>{{ $id }}
                                <img class="avatar ms-2" src="{{ 'https://mc-heads.net/head/'.($vote->user->name ?? '').'/64.png' }}" height="40" alt="Minecraft avatar de {{ $vote->user->name ?? '' }}"></td>
                            <td>
                                <div>
                                    <span class="ms-auto">{{ $vote->user->name ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if(theme_config('vote.top-vote-reward.'.$loop->iteration))
                                        {{theme_config('vote.top-vote-reward.'.$loop->iteration) ?? ''}} <img src="{{theme_config('vote.img') ? image_url(theme_config('vote.img')):"https://cdn-icons-png.flaticon.com/128/2933/2933116.png"}}" alt="" height="16" width="16"/>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $vote->votes }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($displayRewards)
        <h2 class="text-center pt-4 pt-md-8">Récompenses</h2>
        <div class="row flex-column align-items-center justify-content-md-center mt-5">
            <div class="col-12 col-md-8 p-0">
                <div class="table-responsive">
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
