@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="container-fuid px-4 px-md-8">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        <div class="row gap-5 justify-content-between">

            <div class="col-md-7 mt-md-10">
                <div class="w-75">
                    {!! theme_config('home.text') ?? trans('theme::theme.home.home_premium') !!}
                </div>
                @if(!theme_config('home.server.show'))
                <button
                    class="copyButton d-flex flex-column align-items-center bg-transparent cursor-pointer border-0 mb-0 p-0 mt-4"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{trans('theme::theme.home.adress_copied')}}" aria-label="{{trans('theme::theme.home.adress_copied')}}" data-bs-trigger="manual"
                >
                    <span class="btn btn-outline-primary px-4 text-uppercase fw-semibold">
                        {{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}
                    </span>
                    <span class="fw-semibold text-white text-xs mt-1">
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
                            {{trans('theme::theme.home.user_connected', ['nb' => $connected])}}
                        @else
                            {{trans('theme::theme.home.server_off')}}
                        @endif
                </button>
                @endif

            </div>
            <div class="col-lg-4 d-flex flex-column align-items-end gap-4">
                @plugin('vote')
                    @php
                        $votes = Azuriom\Plugin\Vote\Models\Vote::getTopVoters(now()->startOfMonth());
                        $totalVotes = Azuriom\Plugin\Vote\Models\Vote::where('created_at', '>=', now()->startOfMonth())->count();
                    @endphp
                    <div class="card home-card">
                        <div class="card-header">
                            {{trans('theme::theme.home.top_vote')}}
                        </div>
                        <div class="card-body d-flex flex-column">
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
                                    {{trans('theme::theme.home.no_vote')}}
                                @endforelse
                            </div>
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 px-2 text-sm mt-3">
                                <span class="text-primary">{{trans('theme::theme.home.vote_total', ['nb' => $totalVotes])}}</span>
                                <a class="btn btn-primary rounded-pill text-sm"
                                   href="/vote"
                                   rel="noopener" target="_blank">
                                    {{trans('theme::theme.home.vote_for', ['name' => site_name()])}}
                                </a>
                            </div>
                        </div>
                    </div>
                @endplugin
                <div class="card home-card">
                    <div class="card-header">
                        {{trans('theme::theme.home.our_discord')}}
                    </div>
                    <div class="card-body discord">
                        @includeIf('components.general.discord')
                    </div>
                </div>
            </div>
        </div>

    </div>
    @includeIf('components.general.discordAPI')
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/libs/skinview3d.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/ranks.js') }}" defer></script>
@endpush

@push('footer-scripts')
    <script type="text/javascript">

        async function copyToClipboard(textToCopy) {
            // Navigator clipboard api needs a secure context (https)
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(textToCopy);
            } else {

                const tempInput = document.createElement("input");
                tempInput.value = textToCopy;
                tempInput.style.position = "absolute";
                tempInput.style.left = "-999999px";

                document.body.prepend(tempInput);
                tempInput.select();

                try {
                    document.execCommand('copy');
                } catch (error) {
                    console.error(error);
                } finally {
                    tempInput.remove();
                }
            }
        }

        let copyButton = document.querySelectorAll(".copyButton");

        copyButton.forEach(function(e) {
            e.addEventListener("click", function() {
                let textToCopy = '{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}';
                copyToClipboard(textToCopy);

                let tooltip = new bootstrap.Tooltip(e);
                tooltip.show();

                setTimeout(function() {
                    tooltip.hide();
                }, 2000);
            })

            e.addEventListener("mouseover", function() {
                let tooltip = bootstrap.Tooltip.getInstance(e);
                if (tooltip) {
                    tooltip.hide();
                }
            });
        });
    </script>
@endpush
