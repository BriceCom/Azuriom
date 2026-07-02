@if(! $servers->isEmpty())
    @php($totalOnline = $servers->sum(fn($server) => $server->isOnline() ? $server->getOnlinePlayers() : 0))

    <div class="home-servers">
        <div class="home-section-head d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-2 mb-3">
            <h2 class="mb-0">{{ trans('messages.fields.server') }}</h2>
            <p class="mb-0 opacity-75">{{ trans_choice('messages.server.online', $totalOnline, ['count' => $totalOnline]) }}</p>
        </div>

        <div class="row gy-3">
        @foreach($servers as $server)
            <div class="col-md-4">
                <article class="home-server-node h-100 d-flex flex-column justify-content-between {{ $server->isOnline() ? 'is-online' : 'is-offline' }}">
                    <div>
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                            <h3 class="home-server-name mb-0">{{ $server->name }}</h3>
                            @if($server->isOnline())
                                <span class="home-server-pill">{{ trans('theme::theme.online') }}</span>
                            @endif
                        </div>

                        @if($server->isOnline())
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: {{ $server->getPlayersPercents() }}%">
                                </div>
                            </div>

                            <p class="mb-0 opacity-75">
                                {{ trans_choice('messages.server.total', $server->getOnlinePlayers(), [
                                    'max' => $server->getMaxPlayers(),
                                ]) }}
                            </p>
                        @else
                            <p class="mb-0 text-danger-emphasis">{{ trans('messages.server.offline') }}</p>
                        @endif
                    </div>

                    @if($server->join_url)
                        <a href="{{ $server->join_url }}" class="btn btn-primary mt-3">
                            {{ trans('messages.server.join') }}
                        </a>
                    @else
                        <p class="home-server-address mt-3 mb-0">{{ $server->fullAddress() }}</p>
                    @endif
                </article>
            </div>
        @endforeach
        </div>
    </div>
@endif
