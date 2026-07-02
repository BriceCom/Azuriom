@php($imgUrl = $imgUrl ?? null)
@php($content = $content ?? null)
@php($button = $button ?? null)
@php($joinButton = $joinButton ?? null)
@if($show)
    <section class="textimage container d-flex flex-column flex-lg-row align-items-md-center justify-content-between gap-6">
        <div class="textimage__img">
            <img class="mb-3" height="663" src="{{$imgUrl ?? 'https://placehold.jp/1000x1000.png'}}" alt="Illustration du jeu Minecraft">
        </div>
        <div class="textimage__content">
            {!! $content !!}

            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-4 mt-6">
                @if($button && $button['text'])
                    <a href={{$button['url']}}} @if(isset($button['newTab'])) target="_blank" @endif class="btn btn-tertiary text-uppercase">{{$button['text']}}</a>
                @endif
                @if($joinButton)
                    @include('components.join-button', ['btn' => 'tertiary'])
                @endif
            </div>
        </div>
    </section>
@endif
