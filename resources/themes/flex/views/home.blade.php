@extends('layouts.base')

@section('title', trans('messages.home'))

@php
    $resolveHomeOrder = static fn (string $sectionKey, int $default): int => max(1, (int) (theme_config('home.'.$sectionKey.'.order') ?: $default));

    $homeSections = collect([
        [
            'key' => 'hero',
            'order' => $resolveHomeOrder('hero', 10),
            'position' => 1,
            'enabled' => true,
        ],
        [
            'key' => 'stats',
            'order' => $resolveHomeOrder('stats', 20),
            'position' => 2,
            'enabled' => !theme_config('home.stats.off'),
        ],
        [
            'key' => 'servers',
            'order' => $resolveHomeOrder('servers', 30),
            'position' => 3,
            'enabled' => (bool) theme_config('home.servers.on'),
        ],
        [
            'key' => 'video',
            'order' => $resolveHomeOrder('video', 40),
            'position' => 4,
            'enabled' => theme_config('home.video.trailer.off') !== 'on',
        ],
        [
            'key' => 'news',
            'order' => $resolveHomeOrder('news', 50),
            'position' => 5,
            'enabled' => !theme_config('home.news.off'),
        ],
        [
            'key' => 'discord',
            'order' => $resolveHomeOrder('discord', 60),
            'position' => 6,
            'enabled' => !theme_config('home.discord.off'),
        ],
        [
            'key' => 'gallery',
            'order' => $resolveHomeOrder('gallery', 70),
            'position' => 7,
            'enabled' => plugins()->isEnabled('gallery') && !theme_config('home.gallery.off'),
        ],
        [
            'key' => 'faq',
            'order' => $resolveHomeOrder('faq', 80),
            'position' => 8,
            'enabled' => plugins()->isEnabled('faq') && !theme_config('home.faq.off'),
        ],
    ])
        ->filter(static fn (array $section): bool => (bool) $section['enabled'])
        ->sort(static function (array $first, array $second): int {
            return [$first['order'], $first['position']] <=> [$second['order'], $second['position']];
        })
        ->values();
@endphp

@section('app')
    <main id="content">
        <h1 class="d-none">{{ site_name() }}</h1>

        @foreach($homeSections as $section)
            <div data-aos="fade-up">
                @if($section['key'] === 'hero')
                    @include('components.home.hero')
                    @include('components.home.second-hero')
                @elseif($section['key'] === 'stats')
                    @include('components.home.stats')
                @elseif($section['key'] === 'servers')
                    @include('components.home.servers')
                @elseif($section['key'] === 'video')
                    @include('components.home.trailer')
                @elseif($section['key'] === 'news')
                    @include('components.home.news')
                @elseif($section['key'] === 'discord')
                    @include('components.home.discord-cta')
                @elseif($section['key'] === 'gallery')
                    @include('components.home.gallery')
                @elseif($section['key'] === 'faq')
                    @include('components.home.faq')
                @endif
            </div>
        @endforeach
    </main>
@endsection
