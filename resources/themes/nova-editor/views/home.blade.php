@extends('layouts.base')

@section('title', trans('messages.home'))

@php
    $showSidebar = !(
        theme_config('sidebar.buttons.off')
        && theme_config('sidebar.discord.off')
        && theme_config('sidebar.article.off')
        && theme_config('sidebar.vote.off')
    );

    $resolveHomeOrder = static fn (?string $key, int $default): int => max(1, (int) (theme_config($key) ?: $default));

    $homeSections = collect([
        [
            'key' => 'cta',
            'order' => $resolveHomeOrder('home.cta.order', 10),
            'position' => 1,
            'enabled' => theme_config('home.cta.on'),
        ],
        [
            'key' => 'servers',
            'order' => $resolveHomeOrder('home.servers.order', 20),
            'position' => 2,
            'enabled' => theme_config('home.servers.on'),
        ],
        [
            'key' => 'video',
            'order' => $resolveHomeOrder('home.video.order', 30),
            'position' => 3,
            'enabled' => theme_config('home.video.trailer.off') !== 'on',
        ],
        [
            'key' => 'news',
            'order' => $resolveHomeOrder('home.news.order', 40),
            'position' => 4,
            'enabled' => !theme_config('home.news.off'),
        ],
        [
            'key' => 'changelog',
            'order' => $resolveHomeOrder('home.changelog.order', 50),
            'position' => 5,
            'enabled' => !theme_config('home.changelog.off'),
        ],
    ])
        ->filter(static fn (array $section): bool => (bool) $section['enabled'])
        ->sort(static function (array $first, array $second): int {
            return [$first['order'], $first['position']] <=> [$second['order'], $second['position']];
        })
        ->values();
@endphp

@section('app')
    <main id="content" class="d-flex flex-column gap-10 mb-15 pt-7">
        <h1 class="d-none">{{ site_name() }}</h1>

        <div class="container">
           <div class="row gx-5 gy-5">
               <div class="@if($showSidebar) col-lg-9 @endif">
                   <div class="d-flex flex-column gap-5">
                       @foreach($homeSections as $section)
                           @if($section['key'] === 'cta')
                               @include('components.cta', [
                                   'icon' => theme_config('home.cta.icon') ?? 'bi bi-megaphone',
                                   'title' => theme_config('home.cta.title') ?? "Bienvenue sur " . site_name(),
                                   'text' => theme_config('home.cta.text'),
                                   'button_text' => theme_config('home.cta.link.text'),
                                   'button_url' => theme_config('home.cta.link.url'),
                                   'image' => theme_config('home.cta.img')
                               ])
                           @elseif($section['key'] === 'servers')
                               @include('components.servers')
                           @elseif($section['key'] === 'video')
                               @include('components.trailer')
                           @elseif($section['key'] === 'news')
                               @include('components.news')
                           @elseif($section['key'] === 'changelog')
                               @plugin('changelog')
                                   @include('components.changelog')
                               @endplugin
                           @endif
                       @endforeach
                   </div>
               </div>

               @if($showSidebar)
                   <div class="col-lg-3 d-flex flex-column gap-4">
                       @include('components.sidebar.buttons')
                       @include('components.sidebar.top-vote')
                       @include('components.sidebar.discord')
                       @include('components.sidebar.hightlight-shop')
                   </div>
               @endif
           </div>
        </div>
    </main>
@endsection
