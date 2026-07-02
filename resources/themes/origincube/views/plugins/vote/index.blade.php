@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div class="pageTitle">
        <h1>VOTE ET GAGNE DES RÉCOMPENSES</h1>
        <p class="fw-normal text-light">Vote pour OriginCube et obtient des récompenses directement en jeu</p>
    </div>

    <div class="card mb-4 mb-md-8">
        <div class="card-body p-0 text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                    <div class="col-md-9 p-5">
                        <div class="d-flex flex-md-row flex-column align-items-center gap-2 mb-3">
                            <input type="text" id="stepNameInput" name="name" class="form-control"
                                   value="{{ $name }}"
                                   placeholder="Votre pseudo en jeu" required>
                            <div>
                                <button id="stepNameButton"  type="submit" class="d-inline-flex align-items-center gap-2 btn btn-primary text-uppercase px-5">
                                    CONFIRMER
                                    <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                                </button>
                            </div>
                        </div>
                        <small class="text-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M12 6C12 7.5913 11.3679 9.11742 10.2426 10.2426C9.11742 11.3679 7.5913 12 6 12C4.4087 12 2.88258 11.3679 1.75736 10.2426C0.632141 9.11742 0 7.5913 0 6C0 4.4087 0.632141 2.88258 1.75736 1.75736C2.88258 0.632141 4.4087 0 6 0C7.5913 0 9.11742 0.632141 10.2426 1.75736C11.3679 2.88258 12 4.4087 12 6ZM6 3C5.90521 3.00005 5.81147 3.01996 5.72484 3.05845C5.63821 3.09693 5.5606 3.15313 5.49701 3.22343C5.43342 3.29374 5.38526 3.37658 5.35563 3.46662C5.32601 3.55667 5.31557 3.65193 5.325 3.74625L5.5875 6.3765C5.59632 6.47983 5.6436 6.57608 5.71998 6.64623C5.79637 6.71637 5.8963 6.75529 6 6.75529C6.1037 6.75529 6.20363 6.71637 6.28002 6.64623C6.3564 6.57608 6.40368 6.47983 6.4125 6.3765L6.675 3.74625C6.68443 3.65193 6.67399 3.55667 6.64437 3.46662C6.61474 3.37658 6.56658 3.29374 6.50299 3.22343C6.4394 3.15313 6.36179 3.09693 6.27516 3.05845C6.18853 3.01996 6.09479 3.00005 6 3ZM6.0015 7.5C5.80259 7.5 5.61182 7.57902 5.47117 7.71967C5.33052 7.86032 5.2515 8.05109 5.2515 8.25C5.2515 8.44891 5.33052 8.63968 5.47117 8.78033C5.61182 8.92098 5.80259 9 6.0015 9C6.20041 9 6.39118 8.92098 6.53183 8.78033C6.67248 8.63968 6.7515 8.44891 6.7515 8.25C6.7515 8.05109 6.67248 7.86032 6.53183 7.71967C6.39118 7.57902 6.20041 7.5 6.0015 7.5Z" fill="#DADADA"/>
                            </svg>
                            Attention, votre pseudo sur le site doit être identique à votre pseudo en jeu.
                        </small>
                    </div>
                </form>
            </div>

            <div class="@guest d-none @endguest row align-items-center justify-content-between h-100 pt-3 px-5" data-vote-step="2">
                <div class="col-lg-7 d-flex align-items-center gap-3">
                    <div class="text-start overflow-hidden mb-4 mb-xl-0" style="height: 176px; width: 230px">
                        <img src="https://mc-heads.net/body/{{$user->name ?? $name}}.png" class="rounded mb-3 skin" alt="@auth Votre personnage du jeu minecraft @endauth @guest Personnage du jeu minecraft @endguest" height="274">
                    </div>
                    <div class="text-start py-5">
                        <p class="fs-5 mb-1">Merci, @auth{{$user->name}},@endauth @guest<span id="user_name"></span>,@endguest</p>
                        <p>Merci de soutenir {{site_name()}}. Tu peux retrouver les différents sites de vote juste à droite.</p>
                    </div>
                </div>
                @push('footer-scripts')
                    <script type="text/javascript">
                        const stepNameButton_17 = document.getElementById('stepNameButton');
                        const stepNameInput_17 = document.getElementById('stepNameInput');
                        const userName = document.getElementById('user_name');
                        const skin = document.querySelector('.skin');

                        stepNameButton_17.addEventListener('click', () => {
                            const value = stepNameInput_17.value;
                            userName.innerHTML = value;
                            skin.src = `https://mc-heads.net/body/${value}.png`;
                        });
                    </script>
                @endpush
                <div class="vote-sites col-lg-5 d-flex flex-column gap-3 mb-4">
                    @forelse($sites as $site)
                        <a class="btn btn-primary fw-normal text-uppercase text-nowrap overflow-hidden" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
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

    <div class="card mb-4 mb-md-8">
        <div class="card-body">
            <h2 class="card-title">
                MEILLEURS VOTEURS
            </h2>
            <p class="fw-normal text-light">Merci à toutes les personnes qui votent pour le serveur</p>

            <div>
                <div class="row gx-4 gy-4">
                @foreach($votes as $id => $vote)
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="h-100 d-flex gap-3 align-items-center bg-black p-3 rounded-4">
                            <div>
                                <span class="voteTop-position rounded-3 fw-normal bg-gray-custom voteTop-{{$loop->iteration}}">#{{$id}}</span>
                            </div>
                            <div>
                                <img src="{{$vote->user->getAvatar()}}" height="28px" alt="Avater de {{$vote->user->name}}">
                            </div>
                            <div class="voteTop-wrapper d-flex flex-column gap-1">
                                <span class="fw-semibold">{{$vote->user->name}}</span>
                                <div class="fw-normal d-flex align-items-center flex-wrap gap-2 text-nowrap">
                                    @if(theme_config('vote.top-vote-reward.'.$loop->iteration))
                                        <small class="py-1 px-2 rounded-pill bg-gray-custom voteTop-{{$loop->iteration}}">{{theme_config('vote.top-vote-reward.'.$loop->iteration)}}</small>
                                    @endif
                                    <small>{{ $vote->votes }} votes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

        </div>
    </div>

    @if(display_rewards())
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
