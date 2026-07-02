<div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
    <div class="d-flex align-items-center">
        <div>
            <img class="object-fit-contain" src="{{site_logo()}}" alt="Logo {{site_name()}}" height="64">
        </div>
        <div class="d-flex flex-column">
            <p class="m-0 fw-semibold">{{ setting('copyright') }}
                |
                @if(!theme_config('footer.index.dixept_copyright.off'))
                    <span title="Version {{$version_theme}}">{{trans('theme::theme.footer.copyright')}}
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
            </span>|
                @endif
                @lang('messages.copyright')
            </p>
            <ul class="list-unstyled d-flex flex-wrap align-items-center m-0">
                <li><a href="">zz</a></li>
            </ul>
        </div>
    </div>
    <button
        class="copyButton d-flex flex-column align-items-center bg-transparent cursor-pointer border-0 mb-0"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual">
        <span class="fw-semibold border text-sm p-2 mb-1">
            @if($servers)
                @php
                    $connected = 0
                @endphp
                @foreach($servers as $server)
                    @if($server->isOnline())
                        @php
                            $connected += $server->getOnlinePlayers()
                        @endphp
                    @endif
                @endforeach
                <span class="d-flex align-items-center"><span class="d-block bg-success rounded-pill me-2" style="width: 8px; height: 8px;"></span>{{$connected}} joueurs en ligne</span>
            @else
                <span class="d-flex align-items-center"> <span class="d-block bg-danger rounded-pill me-2" style="width: 8px; height: 8px;"></span> Serveur hors-ligne</span>
            @endif
        </span>
    </button>
</div>
