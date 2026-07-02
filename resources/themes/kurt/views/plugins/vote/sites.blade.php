<div class="card">
    <div class="card-body position-relative" id="vote-card">
        <div class="spinner-parent h-100">
            <div class="spinner-border text-white" role="status"></div>
        </div>

        <div class="@auth d-none @endauth" data-vote-step="1">
            <form class="row justify-content-start" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                @if(theme_config('vote.logout.text'))
                    <p>
                        {{ theme_config('vote.logout.text') }}
                    </p>
                @endif
                <div class="col-lg-8 d-flex flex-column flex-md-row align-items-md-center gap-3">
                    <input type="text" id="stepNameInput" name="name" class="form-control w-100"
                           value="{{ $name }}"
                           placeholder="{{ trans('messages.fields.name') }}" required>

                    <button type="submit" class="w-fit btn btn-primary">
                        {{ trans('messages.actions.continue') }}
                        <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                    </button>
                </div>
            </form>
        </div>

        <div class="@guest d-none @endguest h-100" data-vote-step="2">
            <div class="row gx-1 gy-1">
                @forelse($sites as $site)
                    <div class="col-md-6">
                        <a class="btn btn-primary w-100" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                           data-vote-id="{{ $site->id }}"
                           data-vote-url="{{ route('vote.vote', $site) }}"
                           @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                            <span class="badge bg-secondary text-white vote-timer"></span> {{ $site->name }}
                        </a>
                    </div>
                @empty
                    <div class="col-12 alert alert-warning" role="alert">
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
