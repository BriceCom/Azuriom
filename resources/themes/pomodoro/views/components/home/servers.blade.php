<section class="py-5" id="servers">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bolder">{{ trans('messages.servers') }}</h2>
        </div>

        <div class="row gy-3 justify-content-center">
            @foreach($servers as $server)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h3 class="h5 card-title">{{ $server->name }}</h3>

                            @if($server->isOnline())
                                <div class="progress mb-2">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $server->getPlayersPercents() }}%"></div>
                                </div>

                                <p class="mb-3 text-body-secondary">
                                    {{ trans_choice('messages.server.total', $server->getOnlinePlayers(), ['max' => $server->getMaxPlayers()]) }}
                                </p>
                            @else
                                <p class="mb-3">
                                    <span class="badge bg-danger">{{ trans('messages.server.offline') }}</span>
                                </p>
                            @endif

                            @if($server->join_url)
                                <a href="{{ $server->join_url }}" class="btn btn-primary">
                                    {{ trans('messages.server.join') }}
                                </a>
                            @else
                                <p class="card-text text-body-secondary mb-0">{{ $server->fullAddress() }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
