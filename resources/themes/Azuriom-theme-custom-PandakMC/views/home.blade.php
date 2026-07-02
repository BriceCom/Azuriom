@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <section class="hero home d-flex align-items-center justify-content-center flex-column text-white">
        <div class="hero__bg" style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;"></div>

        <div class="hero__img mb-0 mb-md-6">
            <img height="300" src="{{ image_url(setting('logo')) }}" alt="{{ setting('title') }}">
        </div>
        <div class="d-flex align-items-center gap-4 mt-3">
            <button
                class="clipboard hero__btn w-fit d-flex flex-row align-items-center gap-3 cursor-pointer border-0 mb-0 p-2 py-1 px-5 rounded-pill fw-bold text-uppercase text-sm"
                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!"
                data-bs-trigger="manual"
            >
                @php
                    $totalPlayers = 0
                @endphp
                @if($servers->where('home_display')->count() > 0)
                    @php
                        $totalPlayers = 0
                    @endphp
                    @foreach($servers->where('home_display') as $server)
                        @php
                            $totalPlayers += $server->getOnlinePlayers()
                        @endphp
                    @endforeach
                @endif
                @if($servers->where('home_display')->count() > 0)
                    {{$totalPlayers??$server->getOnlinePlayers()}}
                @endif
                <span>
                    {{theme_config('home.index.ip.text') ?? 'play.pandakmc.fr'}}
                </span>
            </button>
            <a href="{{theme_config('home.index.discord.link') ?? 'https://discord.gg/ZdSPkxK5xT'}}" target="_blank">
                <i class="bi bi-discord h4 m-0"></i>
            </a>
        </div>

        <a href="#content" class="hero__arrow">
            <i class="bi bi-caret-down-fill"></i>
        </a>

    </section>

    <div id="content" class="container content mt-15">
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        @if(! $posts->isEmpty())
            <div class="my-15">
                <h2 class="d-none">
                    {{ trans('messages.news') }}
                </h2>

                <div class="row gy-3 gx-7">
                    @foreach($posts->take(3) as $post)
                        @php
                            $insideBrackets='';
                            $hex='';
                            $tag='';
                                    if (preg_match('/\[(.*?)\]/', $post->title, $matches)) {
                                        $insideBrackets = $matches[1];

                                        // Isoler le code HEX avec le format #rrggbb
                                        if (preg_match('/#([0-9a-fA-F]{6})/', $insideBrackets, $hexMatches)) {
                                            $hex = $hexMatches[1];
                                        }

                                        // Isoler le reste du mot après le code HEX
                                        $tag = preg_replace('/#([0-9a-fA-F]{6})_/', '', $insideBrackets);
                                    }

                                $text = preg_replace('/\[.*?\]/', '',  $post->title);
                        @endphp
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('posts.show', $post) }}" class="post text-decoration-none">
                                @if($post->hasImage())
                                    <div class="post__img">
                                        <img src="{{ $post->imageUrl() }}" alt="{{ $text }}">
                                    </div>
                                @endif
                                <div class="text-center mt-3">
                                    <h3 class="h4">{{ $text }}</h3>
                                    <span class="article__tag d-flex flex-column flex-md-row align-items-center gap-3 justify-content-center">@if($tag)<span class="tag" style="background-color: {{'#' . $hex}}">{{$tag}}</span> <i class="d-none d-md-inline-block">-</i> @endif{{$post->published_at->format('d/m/Y')}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="row align-items-center justify-content-between gy-10">
            <div class="col-lg-6">
                @include('components.howjoin')
            </div>
            <div class="col-lg-5">
                @include('components.stats', ["totalPlayers" => $totalPlayers??$server->getOnlinePlayers()])
            </div>
        </div>
    </div>
@endsection

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

        let copyButton = document.querySelectorAll(".clipboard");

        copyButton.forEach(function(e) {
            e.addEventListener("click", function() {
                let textToCopy = '{!! theme_config('home.index.ip.text') ?? 'play.pandakmc.fr' !!}';
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
