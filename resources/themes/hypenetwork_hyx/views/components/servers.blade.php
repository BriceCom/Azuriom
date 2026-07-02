@if(! $servers->isEmpty())
<div id="nos-serveurs">
    <h2 class="h4 mb-6">
        Nos serveurs
    </h2>

    <div class="row server__wrapper justify-content-lg-start px-3">
        @foreach($servers as $server)
            <div class="col-sm-4 col-xl-3 server" data-aos="fade-left">
                <div class="card border-0 bg-body-secondary h-100">

                    <div class="card-img-top server__img">
                        <img aria-hidden="true" class="object-fit-cover" src="{{theme_config('home.servers.bg.'.str_replace(' ', '_', $server->name)) ?  image_url(theme_config('home.servers.bg.'.str_replace(' ', '_', $server->name))):"https://placehold.jp/400x228.png"}}" alt="Bannière du serveur {{$server->name}}" height="228" width="400">
                    </div>

                    <div class="card-body p-5 text-center">

                        <div class="d-flex align-items-end justify-content-between">

                                <span class="h5 mb-0">
                                    {{ $server->name }}
                                </span>

                            @if($server->joinUrl())
                                <a href="{{ $server->joinUrl() }}" class="btn btn-icon btn-secondary d-inline-flex align-items-center">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 5.5C3.83579 5.5 3.5 5.83579 3.5 6.25V14.75C3.5 15.1642 3.83579 15.5 4.25 15.5H12.75C13.1642 15.5 13.5 15.1642 13.5 14.75V10.75C13.5 10.3358 13.8358 10 14.25 10C14.6642 10 15 10.3358 15 10.75V14.75C15 15.9926 13.9926 17 12.75 17H4.25C3.00736 17 2 15.9926 2 14.75V6.25C2 5.00736 3.00736 4 4.25 4H9.25C9.66421 4 10 4.33579 10 4.75C10 5.16421 9.66421 5.5 9.25 5.5H4.25Z" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.19385 12.7532C6.47175 13.0603 6.94603 13.0841 7.25319 12.8062L16.5 4.43999V7.25C16.5 7.66421 16.8358 8 17.25 8C17.6642 8 18 7.66421 18 7.25V2.75C18 2.33579 17.6642 2 17.25 2H12.75C12.3358 2 12 2.33579 12 2.75C12 3.16421 12.3358 3.5 12.75 3.5H15.3032L6.24682 11.6938C5.93966 11.9717 5.91595 12.446 6.19385 12.7532Z" fill="white"/>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <div class="mt-3">
                            @if($server->isOnline())
                                <p class="d-flex align-items-center gap-1 mb-2 text-muted text-sm">
                                    <svg class="me-1" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 9C11.6569 9 13 7.65685 13 6C13 4.34315 11.6569 3 10 3C8.34315 3 7 4.34315 7 6C7 7.65685 8.34315 9 10 9Z" fill="#D1D5DB"/>
                                        <path d="M6 8C6 9.10457 5.10457 10 4 10C2.89543 10 2 9.10457 2 8C2 6.89543 2.89543 6 4 6C5.10457 6 6 6.89543 6 8Z" fill="#D1D5DB"/>
                                        <path d="M1.49064 15.3257C1.32107 15.2271 1.19021 15.0718 1.13247 14.8843C1.04636 14.6048 1 14.3078 1 14C1 12.3431 2.34315 11 4 11C4.522 11 5.01287 11.1333 5.4404 11.3678C4.39329 12.3989 3.69414 13.7825 3.53478 15.3267C3.5118 15.5494 3.52139 15.7692 3.55996 15.9809C2.81061 15.9156 2.10861 15.6849 1.49064 15.3257Z" fill="#D1D5DB"/>
                                        <path d="M16.4405 15.9809C17.1897 15.9155 17.8915 15.6849 18.5094 15.3257C18.6789 15.2271 18.8098 15.0718 18.8675 14.8843C18.9536 14.6048 19 14.3078 19 14C19 12.3431 17.6569 11 16 11C15.4781 11 14.9873 11.1333 14.5599 11.3676C15.6071 12.3987 16.3063 13.7824 16.4656 15.3267C16.4886 15.5494 16.479 15.7692 16.4405 15.9809Z" fill="#D1D5DB"/>
                                        <path d="M18 8C18 9.10457 17.1046 10 16 10C14.8954 10 14 9.10457 14 8C14 6.89543 14.8954 6 16 6C17.1046 6 18 6.89543 18 8Z" fill="#D1D5DB"/>
                                        <path d="M5.30383 16.1909C5.10473 16.0106 4.99922 15.7478 5.02679 15.4807C5.28657 12.9633 7.41408 11 10.0001 11C12.5862 11 14.7137 12.9633 14.9735 15.4807C15.0011 15.7478 14.8956 16.0107 14.6965 16.1909C13.4545 17.3152 11.8073 18 10.0001 18C8.19298 18 6.54576 17.3152 5.30383 16.1909Z" fill="#D1D5DB"/>
                                    </svg>
                                    <b class="fw-semibold">{{$server->getOnlinePlayers()}}</b> joueurs en ligne
                                </p>

                                <div class="progress mb-1">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $server->getPlayersPercents() }}%">
                                    </div>
                                </div>
                            @else
                                <p class="text-start text-muted text-sm">
                                    {{ trans('messages.server.offline') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
