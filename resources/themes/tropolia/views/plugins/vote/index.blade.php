@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div>
        <hgroup class="mb-4.5" data-aos="fade-up" data-aos-delay="0">
            <h1 class="mb-2">
                {{ theme_config('vote.title') ?? trans('vote::messages.sections.vote') . " pour ". site_name() }}
            </h1>
            @if(theme_config('vote.rewardText'))
                <p class="col-lg-8 mb-0">{{ theme_config('vote.text') }}</p>
            @endif
        </hgroup>

        <div class="card" data-aos="fade-up" data-aos-delay="100">
            <div class="position-relative card-body" id="vote-card">
                <div class="spinner-parent h-100">
                    <div class="spinner-border text-white" role="status"></div>
                </div>

                <div class="@auth d-none @endauth" data-vote-step="1">
                    <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}"
                          id="voteNameForm">
                        <p class="h3 mb-4 text-center text-initial">Entrez votre pseudo pour voter</p>

                        <div class="col-lg-6 d-flex flex-column flex-md-row align-items-md-center gap-3">
                            <input type="text" id="stepNameInput" name="name" class="form-control w-100"
                                   value="{{ $name }}"
                                   placeholder="Pseudo en jeu" required>

                            <button type="submit" class="w-fit btn btn-primary text-uppercase">
                                {{ trans('messages.actions.continue') }}
                                <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="@guest d-none @endguest d-flex flex-column align-items-center justify-content-center"
                     data-vote-step="2">
                    <p class="h3 mb-4 text-initial">{{theme_config('vote.chooseSiteText') ?? "Choisissez sur quel site voter"}}</p>
                    <div>
                        @forelse($sites as $site)
                            <a class="btn btn-primary m-1" href="{{ $site->url }}" target="_blank"
                               rel="noopener noreferrer"
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

                <div class="d-none" data-vote-step="server">
                    <p>{{ trans('vote::messages.server') }}</p>

                    <div id="server-select"></div>
                </div>
            </div>
        </div>
    </div>

    @include("plugins.vote._components.top")
    @include("plugins.vote._components.rewards")

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
