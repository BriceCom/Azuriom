@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')

    @php
        $months_list = array("", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
    @endphp

    <h1>{{ trans('vote::messages.sections.vote') }}</h1>

    @if(date("j") <= 15)
        <div class="alert alert-primary" style="background-color: #3498DB; color: white" role="alert">
            <i class="bi bi-gift-fill"></i> Bonus en cours jusqu'au 15 {{ $months_list[date('n')] }} ! Tous les votes donneront <b>le double de leur récompense</b> !
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                    @if(!$authRequired)
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
                    @else
                        <div class="col-md-6">
                            <div class="alert alert-info" role="status">
                                <i class="bi bi-info-circle"></i> {{ trans('vote::messages.errors.auth') }}
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> {{ trans('auth.login') }}
                            </a>
                        </div>
                    @endif
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

            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">Récompense</th>
                    <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($votes as $id => $vote)
                    <tr class="toSlideInRightLess toAnimate" >
                        <th scope="row"><span class="index">#{{ $id }}</span></th>
                        <td><img src="{{ $vote->user->getAvatar(64) }}" width="25px" class="avatar">{{ $vote->user->name }}</td>
                        @if(theme_config('vote.rewards.'.$id))
                            <td>
                                <span class="reward">
                                    {{theme_config('vote.rewards.'.$id.'.reward')}}
                                </span>
                            </td>
                        @else
                            <td></td>
                        @endif
                        <td><b>{{ $vote->votes }}</b> votes</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
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

@push('footer-scripts')
    <script type="text/javascript">
        $("tr").each(function (index ) {
            $(this).css('animation-delay',index *0.1 +'s');
        });
    </script>
@endpush

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
