<button
    class="copyButton d-flex align-items-center gap-3 py-2 px-3 rounded rounded-lg text-uppercase fw-bold border-0 text-white h5 mb-0"
    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.server_address_copied')}}" aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
>
    {{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}
   <span class="d-flex align-items-center gap-2">
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
       @endif
       <span>{{$connected}}</span>
           <span class="state-point"></span>
   </span>
</button>
