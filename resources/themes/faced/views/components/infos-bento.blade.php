<section class="d-flex flex-column gap-4">
    <div class="row w-100 mx-auto">
        <div class="col-md-6 pe-md-3 p-0">
            <div class="card h-100">
                <div class="card-body d-flex flex-column gap-3 align-items-baseline">
                    <hgroup>
                        <h2 class="h5">{{theme_config('home.bentobox.vote.title') ?? "Lorem ipsum dolor sit amet"}}</h2>
                        @if(!plugins()->isEnabled('vote'))
                            <p>{{theme_config('home.bentobox.vote.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, sequi?"}}</p>
                        @endif
                    </hgroup>

                    @if(plugins()->isEnabled('vote'))
                    @php
                        $votes = \Azuriom\Plugin\Vote\Models\Vote::getTopVoters(now()->startOfMonth())
                    @endphp
                        <div class="flex-grow-1 w-100">
                            <div
                                class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-md-between"
                                style="height: auto;">
                                @forelse($votes->take(3) as $id => $vote)
                                    <div
                                        class="d-flex align-items-center flex-column {{ $loop->iteration == 1 ? 'order-sm-2' : ($loop->iteration == 3 ? 'order-sm-3 mt-md-4' : 'mt-md-3') }}">
                                        @if(game()->name() === 'Minecraft')
                                            <canvas data-rank="{{ $id }}"
                                                    data-skin-url="{{ 'https://mineskin.eu/skin/'.$vote->user->name }}"></canvas>
                                        @else
                                            <img class="mb-2" src="{{$vote->user->getAvatar()}}" alt="Avatar {{$vote->user->name}}">
                                        @endif
                                        <span class="badge"
                                              style="background-color: {{ $loop->iteration == 1 ? '#FFD700' : ($loop->iteration == 3 ? '#808080' : '#B08D57') }}; color: {{ $loop->iteration == 1 ? '#000000' : ($loop->iteration == 3 ? '#ffffff' : '#000000') }}"
                                        >{{ $vote->user->name }}</span>
                                    </div>
                                @empty
                                    <p>{{theme_config('home.bentobox.vote_empty.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, sequi?"}}</p>
                                @endforelse
                            </div>
                        </div>

                        <a href="{{route('login')}}" class="btn btn-tertiary  text-uppercase mt-2 ms-auto">{{trans('theme::theme.vote_for', ['name' => site_name()])}} <i class="bi bi-arrow-right"></i></a>
                    @else
                        @if(theme_config('home.bentobox.vote.wysiwyg'))
                            <div>
                                {!! theme_config('home.bentobox.vote.wysiwyg') !!}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 ps-md-2 p-0 d-flex flex-column gap-4">
            <div class="card">
                    @guest
                    <div class="card-body">
                        <h2 class="h5">{{theme_config('home.bentobox.user_disconnected.title') ? theme_config('home.bentobox.user_disconnected.title'):"Lorem ipsum dolor."}}</h2>
                        <p>{{theme_config('home.bentobox.user_disconnected.text') ? theme_config('home.bentobox.user_disconnected.text'):"Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consectetur adipisicing."}}</p>
                        <div class="d-flex flex-column flex-md-row align-items-end gap-3 mt-4">
                            <a href="{{route('login')}}" class="btn btn-tertiary text-uppercase">{{ trans('auth.login') }} <i class="bi bi-arrow-right"></i></a>
                            @if(Route::has('register')) <a href="{{route('register')}}">{{trans('theme::theme.dont_have_account')}}</a> @endif
                        </div>
                    </div>
                    @else
                        <div class="card-body d-flex align-items-center justify-content-between gap-2">
                            <div class="infosbento__avatar">
                                <img src="{{Auth::user()->getAvatar(64)}}" class="object-fit-contain rounded-2" height="64" alt="">
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2">
                                <span class="d-block badge" style="background-color: {{Auth::user()->role->color}};">{{Auth::user()->role->name}}</span>
                                @if(plugins()->isEnabled('vote'))
                                   <p class="m-0 text-sm">{{\Azuriom\Plugin\Vote\Models\Vote::where('user_id', Auth::id())->where('created_at', '>=', now()->startOfMonth())->count()}} votes</p>
                                @endif
                                @if(use_site_money())
                                   <p class="m-0 text-sm">{{Auth::user()->money}} {{money_name()}}</p>
                                @endif
                                <a href="{{route('login')}}" class="btn btn-tertiary text-uppercase mt-2">{{trans('messages.nav.profile')}} <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    @endguest
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center justify-content-between gap-3">
                        <div>
                            <img src="{{site_logo()}}" alt="Logo" class="object-fit-contain me-4" width="70">
                        </div>
                       <div class="d-flex align-items-center gap-3">
                           <div class="d-flex flex-column align-items-end">
                               <h3 class="h4 m-0">{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}</h3>

                               <div class="d-flex align-items-center gap-1 mt-1">
                                   <span class="state-point"></span>
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
                                   <small>{{trans('theme::theme.connected_count', ['count' => $connected])}}</small>
                               </div>
                           </div>
                           <button
                               class="copyButton d-flex flex-column align-items-center bg-transparent border-0 mb-0"
                               data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.server_address_copied')}}" aria-label="{{trans('theme::theme.server_address_copied')}}" data-bs-trigger="manual"
                           >
                               <i class="bi bi-copy fs-4 ms-2"></i>
                           </button>

                       </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <div class="card">
        <div class="card-body text-center py-4">
            <h2 class="h1 text-center">{{theme_config('home.bentobox.shop.title') ?? "Lorem ipsum dolor sit amet."}}</h2>
            <a href="/shop" class="btn btn-secondary mx-auto mt-1 text-sm text-uppercase">{{theme_config('home.bentobox.shop.link.text') ?? "Ipsum"}}</a>
        </div>
    </div>
</section>
