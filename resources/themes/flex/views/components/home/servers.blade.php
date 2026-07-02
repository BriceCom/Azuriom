@php
    $homeServers = $servers->where('home_display', true);
    if ($homeServers->isEmpty()) {
        $homeServers = $servers;
    }
@endphp

@if(! $homeServers->isEmpty())
    <section class="servers-section">
        <div class="container">
            <div class="section-copy text-center mb-5">
                <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">
                    {{ theme_config('home.servers.badge') ?? trans('theme::admin.menus.home.servers') }}
                </span>
                <h2>{{ theme_config('home.servers.title') ?? trans('theme::admin.menus.home.servers') }}</h2>
                @if(theme_config('home.servers.text'))
                    <p>{{ theme_config('home.servers.text') }}</p>
                @endif
            </div>

            <div class="row g-4">
                @foreach($homeServers as $server)
                    <div class="col-md-6 col-xl-4">
                        <div class="card server-card h-100">
                            <div class="card-body d-flex flex-column gap-3">
                                <h3 class="card-title mb-0">{{ $server->name }}</h3>

                                @if($server->isOnline())
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $server->getPlayersPercents() }}%"></div>
                                    </div>

                                    <p class="mb-0 text-muted">
                                        {{ trans_choice('messages.server.total', $server->getOnlinePlayers(), [
                                            'max' => $server->getMaxPlayers(),
                                        ]) }}
                                    </p>
                                @else
                                    <span class="badge bg-danger align-self-start">
                                        {{ trans('messages.server.offline') }}
                                    </span>
                                @endif

                                @if($server->join_url)
                                    <a href="{{ $server->join_url }}" class="btn btn-primary mt-auto">
                                        {{ trans('messages.server.join') }}
                                    </a>
                                @else
                                    <p class="card-text text-break mt-auto mb-0">{{ $server->fullAddress() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
