@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div class="container my-5 my-md-15">
        <div class="row align-items-center gap-8 gap-md-0">
            <div class="col-md-6 text-center text-md-start">
                <h1>Vote <br/><span class="h3">des <b class="text-primary">récompenses</b> gratuite !</span>
                </h1>
                <hr/>
                <p>Votez pour obtenir une récompense gratuitement sur notre serveur !</p>
                <p><i class="fw-lighter">Grâce à cela vous pourrez avancez dans votre aventure plus
                        rapidement, alors n’attendez plus !</i></p>
                <a href="#vote-section" class="btn btn-primary fs-3 px-5 text-uppercase">
                    Voter
                </a>
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center">
                <img aria-hidden="true" src="{{theme_config('vote.hero.image.url') ? image_url(theme_config('vote.hero.image.url')) : "https://via.placeholder.com/300"}}" alt="Image non pertinente" height="{{theme_config('vote.hero.image.height') ?? '200' }}">
            </div>
        </div>
    </div>


    <div id="vote-section" class="mb-4 mt-15 pt-md-15">
        <h2 class="vote-section-title text-uppercase custom-underline mx-auto mb-5 mb-md-13">
            @auth
                Choix du serveur
            @else
                Inscrivez votre nom
            @endauth
        </h2>

        @include('elements.session-alerts')

        <div id="vote-card">

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '') }}" id="voteNameForm" onsubmit="changeVoteTitle()">
                    <div class="col-md-6 col-lg-4 text-center">
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

            <div class="@guest d-none @endguest position-relative h-100" data-vote-step="2">
                <div class="spinner-parent h-100">
                    <div class="spinner-border text-white" role="status"></div>
                </div>
                <div class="d-flex justify-content-center flex-wrap gap-md-10 gap-5 mt-8">
                    @forelse($sites as $site)
                        <button class="vote__site-card"
                                style="background: url('{{ theme_config('vote.site.'.$loop->iteration.'.image.url') != null ? image_url(theme_config('vote.site.'.$loop->iteration.'.image.url')) : image_url(setting('background')??"https://via.placeholder.com/300") }}') center / cover no-repeat;"
                                data-vote="{{ route('vote.vote', $site) }}"
                                data-site-name="{{ $site->name }}"
                                onclick="selectedVote(this)">
                            <a class="text-decoration-none fw-semibold"
                                href="{{ $site->url }}"
                               target="_blank" rel="noopener noreferrer"
                               data-vote-id="{{ $site->id }}"
                               data-vote-url="{{ route('vote.vote', $site) }}"
                               @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                                {{$site->name}}
                                <br/>
                                <span class="badge bg-secondary text-white vote-timer mt-3"></span>
                            </a>
                        </button>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            {{ trans('vote::messages.errors.site') }}
                        </div>
                    @endforelse
                </div>
                <div class="text-center">
                    <a id="vote__button" onclick="voteOnSelected()" href="#" class="d-inline-block d-none btn btn-primary mt-8">Voter</a>
                </div>
            </div>

            <div class="d-none" data-vote-step="3">
                <p id="vote-result"></p>
            </div>

            @push('footer-scripts')
                <script>
                    let selectedVoteUrl = "";
                    let selectedVoteName = "";
                    const voteBtn = document.getElementById('vote__button');

                    function selectedVote(e){
                        selectedVoteUrl = e.getAttribute('data-vote');
                        selectedVoteName = e.getAttribute('data-site-name');

                        const searchSiteVote = document.querySelector(`[data-vote-url="${selectedVoteUrl}"]`);

                        if(searchSiteVote.getAttribute('data-vote-time')){
                            if(searchSiteVote.getAttribute('data-vote-time') !== "") return;
                        }

                        voteBtn.innerText = `Voter sur ${selectedVoteName}`;
                        voteBtn.classList.remove('d-none');

                        const voteSelectorCards = document.querySelectorAll('[data-vote]');

                        voteSelectorCards.forEach(card => {
                            card.classList.remove('active');
                        })

                        e.classList.add('active');
                    }

                    function voteOnSelected() {
                        const searchSiteVote = document.querySelector(`[data-vote-url="${selectedVoteUrl}"]`);

                        if (searchSiteVote) {
                            searchSiteVote.click();
                            voteBtn.classList.add('d-none');
                        }
                    }

                    function changeVoteTitle() {
                        const voteTitle = document.querySelector('.vote-section-title');
                        voteTitle.innerText = `Choix du serveur`;
                    }
                </script>
            @endpush
        </div>
    </div>

    <div class="mt-md-15 pt-md-8 mt-10">
        <h2 class="text-uppercase custom-underline mx-auto mb-5 mb-md-13">Classement</h2>
        <table class="table mb-0 w-75 mx-auto">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('messages.fields.name') }}</th>
                <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
            </tr>
            </thead>
            <tbody  vertical-align="middle">

            @foreach($votes as $id => $vote)
                <tr class="align-middle">
                    <th scope="row">#{{ $id }}</th>
                    <td><img class="rounded-3 me-2" src="{{$vote->user->getAvatar(32)}}" alt=""> {{ $vote->user->name }}</td>
                    <td>{{ $vote->votes }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    @if($displayRewards)
        <div class="mt-md-15 pt-md-8 mt-10">
            <h2 class="text-uppercase custom-underline mx-auto  mb-5 mb-md-13">Récompenses</h2>
            <table class="table mb-0 w-75 mx-auto">
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
