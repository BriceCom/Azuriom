@if(request()->routeIs('vote.home'))
    @php
        $voteName = $name ?? '';
        $voteSites = $sites ?? [];
        $voteAuthRequired = (bool) ($authRequired ?? false);
        $voteUser = $user ?? auth()->user();
        $voteRequest = $request ?? request();
    @endphp

    <div class="card mb-4">
        <div id="status-message" class="mb-3"></div>

        <div class="card-body text-center position-relative" id="vote-card">
            <div class="spinner-parent h-100">
                <div class="spinner-border text-white" role="status"></div>
            </div>

            <div class="@auth d-none @endauth" data-vote-step="1">
                <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                    @if(!$voteAuthRequired)
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-3">
                                <input type="text" id="stepNameInput" name="name" class="form-control"
                                       value="{{ $voteName }}"
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
                @forelse($voteSites as $site)
                    <a class="btn btn-primary" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                       data-vote-id="{{ $site->id }}"
                       data-vote-url="{{ route('vote.vote', $site) }}"
                       @auth data-vote-time="{{ $site->getNextVoteTime($voteUser, $voteRequest)?->valueOf() }}" @endauth>
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
@else
    <div class="alert alert-warning mb-0">
        {{ trans('theme::pagebuilder.page_component_unavailable', ['component' => trans('theme::pagebuilder.page_vote_card')]) }}
    </div>
@endif
