@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div class="d-flex flex-column gap-8 gap-md-11">
        <div class="container px-md-3 px-md-7">
            <div class="d-flex flex-column gap-8 gap-md-9">
                <div>
                    <div class="col position-relative card vote-card__wrapper" data-aos="fade-up" data-aos-delay="0">
                        <i class="position-absolute start-0 translate-middle bi bi-star-fill vote-icon"></i>

                        <div class="row">
                            <div class="col-xl-8">
                                <div class="vote-card card-body d-flex flex-column gap-3" id="vote-card">
                                    <div class="spinner-parent h-100">
                                        <div class="spinner-border text-white" role="status"></div>
                                    </div>

                                    <hgroup>
                                        <h1 class="mb-0">
                                            {{ theme_config('vote.index.title') ?? trans('vote::messages.sections.vote') . " pour ". site_name() }}
                                        </h1>
                                        @if(theme_config('vote.index.rewardText'))
                                            <p class="mb-0 opacity-75">{{ theme_config('vote.index.text') }}</p>
                                        @endif
                                    </hgroup>

                                    <div class="@auth d-none @endauth @guest d-flex flex-column gap-3 @endguest" data-vote-step="1">
                                        <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                                            <div class="w-100 d-flex align-items-lg-center flex-column flex-lg-row gap-1 gap-lg-3">
                                                <i class="bi bi-number">1</i>

                                                <div class="w-100">
                                                    <div>
                                                        <label for="stepNameInput" class="form-label">
                                                            Entrez votre pseudo
                                                        </label>

                                                        <div class="col-lg-7 d-flex flex-column flex-md-row align-items-md-center gap-3">
                                                            <input type="text" id="stepNameInput" name="name" class="form-control col-lg-7"
                                                                   value="{{ $name }}"
                                                                   placeholder="{{ site_name() }}" required>

                                                            <button type="submit" class="w-fit btn btn-quaternary text-uppercase">
                                                                {{ trans('messages.actions.continue') }}
                                                                <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <p class="text-xs fw-semibold mt-1 mb-0">
                                                        ⚠ Tu dois être inscrit pour voter : pas encore inscrit ?

                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" class="text-sm">
                                                            Clique ici
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row gap-1 gap-lg-3">
                                            <i class="bi bi-number">2</i>
                                            <p class="text-lg mb-0">Cliquez sur le site sur lequel vous souhaitez voter. </p>
                                        </div>
                                    </div>

                                    <div class="@guest d-none @endguest d-flex flex-column gap-3"
                                         data-vote-step="2">

                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row gap-1 gap-lg-3">
                                            <i class="bi bi-number">1</i>
                                            <div class="d-flex align-items-center flex-wrap gap-2 text-lg">
                                                <p class="mb-0 text-lg">
                                                    Se connecter sur le site:
                                                </p>
                                                <div class="d-flex align-items-center gap-2 text-lg mb-0">
                                                    <img @auth src="https://mc-heads.net/avatar/{{ auth()->user()->name }}/64.png" @endauth alt="" width="32" class="@guest d-none @endguest username-img rounded-3">
                                                    <span class="@guest d-none @endguest username">@auth {{ auth()->user()->name }}@endauth</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row gap-1 gap-lg-3">
                                            <i class="bi bi-number">2</i>
                                            <p class="text-lg mb-0">Cliquez sur le site sur lequel vous souhaitez voter.</p>
                                        </div>

                                        <div class="d-flex flex-column align-items-md-center gap-2">
                                            @forelse($sites as $site)
                                                <a class="w-100 btn btn-primary" href="{{ $site->url }}" target="_blank"
                                                   rel="noopener noreferrer"
                                                   data-vote-id="{{ $site->id }}"
                                                   data-vote-url="{{ route('vote.vote', $site) }}"
                                                   @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                                                    <span class="badge bg-secondary text-white vote-timer"></span>

                                                    @foreach($site->rewards as $reward)
                                                        {{ $reward->name }}
                                                    @endforeach
                                                </a>
                                            @empty
                                                <div class="alert alert-warning" role="alert">
                                                    {{ trans('vote::messages.errors.site') }}
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-lg-center flex-column flex-lg-row gap-1 gap-lg-3">
                                        <i class="bi bi-number">3</i>
                                        <p class="text-lg mb-0">{{ theme_config('vote.index.captchaText') ?? "Complétez le captcha et validez le vote."}}</p>
                                    </div>

                                    <div class="d-flex align-items-lg-center flex-column flex-lg-row gap-1 gap-lg-3">
                                        <i class="bi bi-gift-fill text-xxl"></i>
                                        <p class="text-lg mb-0">{{ theme_config('vote.index.rewardInfosText') ?? "Vos récompenses arriverons en jeu sous 5 minutes."}}</p>
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

                            <div class="col-xl-4 card-infos__img position-absolute bottom-0 end-0">
                                <img src="{{ theme_config('vote.index.voteCardImg') ? image_url(theme_config('vote.index.voteCardImg')): theme_asset('img/boy.webp') }}" alt="" class="card-infos__img-img">
                            </div>
                        </div>
                    </div>

                    <div class="position-relative vote-card__wrapper mt-4.5" data-aos="fade-up" data-aos-delay="0">
                        @include('components.alert', [
                                 'type' => 'secondary',
                                 'message' => theme_config('vote.index.howToVoteText') ?? "<p>Faites <strong>/vote</strong> en jeu pour consulter le classement et ses récompenses !</p>",
                                 'icon' => theme_config('vote.index.howToVoteIcon') ?? 'bi bi-play-btn-fill',
                                 'href'=> theme_config('vote.index.howToVoteHref') ?? '#',
                                 'target'=> "_blank"
                             ])
                    </div>
                </div>

                @include("plugins.vote._components.rewards")
            </div>
        </div>

        @include("components.faq")

        @include('components.howToJoin')
    </div>
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

@push('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const voteNameForm = document.getElementById('voteNameForm');
            const username = document.querySelector('.username');
            const usernameImg = document.querySelector('.username-img');

            voteNameForm.addEventListener('submit', function(event) {
                event.preventDefault();

                if (voteNameForm.checkValidity()) {
                    setTimeout(() => {
                        console.log('pseudo', window.username)

                        usernameImg.src = 'https://mc-heads.net/avatar/' + window.username + '/64.png';
                        username.innerText = window.username;
                        usernameImg.classList.remove('d-none');
                        username.classList.remove('d-none');
                    }, 100);
                }
            });
        });
    </script>
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
