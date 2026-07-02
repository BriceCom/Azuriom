@php
    $serversList = isset($servers) && $servers instanceof \Illuminate\Support\Collection
        ? $servers
        : collect();
@endphp

@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'servers',
    'params' => $params ?? [],
    'class' => 'te-landing te-landing-block',
])
    @if(! $serversList->isEmpty())
        <div id="servers" class="te-landing-section">
            <h2 class="text-center mb-0">{{ trans('messages.servers') }}</h2>

            <div class="row gy-3 justify-content-center mb-4 mt-2">
                @foreach($serversList as $server)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title">{{ $server->name }}</h3>

                                @if($server->isOnline())
                                    <div class="progress mb-1">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $server->getPlayersPercents() }}%"></div>
                                    </div>

                                    <p class="mb-1">
                                        {{ trans_choice('messages.server.total', $server->getOnlinePlayers(), [
                                            'max' => $server->getMaxPlayers(),
                                        ]) }}
                                    </p>
                                @else
                                    <p>
                                        <span class="badge bg-danger">
                                            {{ trans('messages.server.offline') }}
                                        </span>
                                    </p>
                                @endif

                                @if($server->join_url)
                                    <a href="{{ $server->join_url }}" class="btn btn-primary">
                                        {{ trans('messages.server.join') }}
                                    </a>
                                @else
                                    <p class="card-text">{{ $server->fullAddress() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="te-landing-divider"></div>
@endcomponent
