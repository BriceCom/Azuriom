@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    @php
        $heroEnabled = theme_config('home.hero.enabled') ?? true;
        $trailerEnabled = theme_config('home.trailer.enabled') ?? true;
        $featuresEnabled = theme_config('home.features.enabled') ?? true;
        $testimonialEnabled = theme_config('home.testimonial.enabled') ?? true;
        $serversEnabled = theme_config('home.servers.enabled') ?? true;
        $blogEnabled = theme_config('home.blog.enabled') ?? true;

        $heroImage = theme_config('home.hero.image')
            ? image_url(theme_config('home.hero.image'))
            : 'https://placehold.co/600x400';

        $hero = [
            'title' => theme_config('home.hero.title') ?: trans('theme::theme.home.hero.title_default', ['site' => site_name()]),
            'subtitle' => theme_config('home.hero.subtitle') ?: trans('theme::theme.home.hero.subtitle_default'),
            'primary_button_text' => theme_config('home.hero.primary_button_text') ?: trans('theme::theme.home.hero.primary_button_default'),
            'primary_button_url' => theme_config('home.hero.primary_button_url') ?: '/shop',
            'image' => $heroImage,
        ];

        $serverIsLauncher = theme_config('settings.server.launcher') ?? false;
        $serverIp = theme_config('settings.server.ip') ?? ($server?->fullAddress() ?? 'serveurliste.com');
        $serverCopiedText = theme_config('settings.server.copied_text') ?? trans('theme::theme.home.server.copied_text_default');
        $serverLauncherText = theme_config('settings.server.text') ?? trans('theme::theme.home.server.launcher_button_default');
        $serverLauncherUrl = theme_config('settings.server.url') ?? ($server?->joinUrl() ?? '#');
        $serverOnlinePlayers = ($server && $server->isOnline()) ? $server->getOnlinePlayers() : 0;

        $trailerEmbedUrl = 'https://www.youtube.com/embed/lHngf-CKCzk';

        $trailer = [
            'title' => theme_config('home.trailer.title') ?? trans('theme::theme.home.trailer.title_default'),
            'subtitle' => theme_config('home.trailer.subtitle') ?? trans('theme::theme.home.trailer.subtitle_default'),
            'video_url' => theme_config('home.trailer.video_url') ?? $trailerEmbedUrl,
            'button_text' => theme_config('home.trailer.button_text') ?? trans('theme::theme.home.trailer.button_text_default'),
            'button_url' => theme_config('home.trailer.button_url') ?? 'https://www.youtube.com/watch?v=lHngf-CKCzk',
        ];

        $defaultFeatureItems = [
            ['icon' => 'bi-shield-check', 'title' => trans('theme::theme.home.features.items.first.title'), 'text' => trans('theme::theme.home.features.items.first.text')],
            ['icon' => 'bi-people', 'title' => trans('theme::theme.home.features.items.second.title'), 'text' => trans('theme::theme.home.features.items.second.text')],
            ['icon' => 'bi-gem', 'title' => trans('theme::theme.home.features.items.third.title'), 'text' => trans('theme::theme.home.features.items.third.text')],
            ['icon' => 'bi-lightning-charge', 'title' => trans('theme::theme.home.features.items.fourth.title'), 'text' => trans('theme::theme.home.features.items.fourth.text')],
        ];

        $features = theme_config('home.features.items');
        $featureItems = is_array($features) && !empty($features) ? $features : $defaultFeatureItems;
        $featuresTitle = theme_config('home.features.title') ?? trans('theme::theme.home.features.title_default');

        $avatarConfig = theme_config('home.testimonial.avatar');
        $avatarImage = $avatarConfig
            ? (filter_var($avatarConfig, FILTER_VALIDATE_URL) ? $avatarConfig : image_url($avatarConfig))
            : 'https://dummyimage.com/48x48/ced4da/6c757d';

        $testimonial = [
            'quote' => theme_config('home.testimonial.quote') ?? trans('theme::theme.home.testimonial.quote_default'),
            'author' => theme_config('home.testimonial.author') ?? trans('theme::theme.home.testimonial.author_default'),
            'role' => theme_config('home.testimonial.role') ?? trans('theme::theme.home.testimonial.role_default'),
            'avatar' => $avatarImage,
        ];

        $blogTitle = theme_config('home.blog.title') ?? trans('theme::theme.home.blog.title_default');
        $blogSubtitle = theme_config('home.blog.subtitle') ?? trans('theme::theme.home.blog.subtitle_default');

        $latestPosts = $posts instanceof \Illuminate\Pagination\AbstractPaginator
            ? $posts->getCollection()->take(3)
            : collect($posts ?? [])->take(3);
    @endphp

    <main class="flex-shrink-0">
        <h1 class="d-none">{{ site_name() }}</h1>

        <div class="container">
            @include('elements.session-alerts')
        </div>

        @if($heroEnabled)
            @include('components.home.hero', [
                'hero' => $hero,
                'serverIsLauncher' => $serverIsLauncher,
                'serverLauncherUrl' => $serverLauncherUrl,
                'serverLauncherText' => $serverLauncherText,
                'serverIp' => $serverIp,
                'serverCopiedText' => $serverCopiedText,
                'serverOnlinePlayers' => $serverOnlinePlayers,
            ])
        @endif

        @if($trailerEnabled)
            @include('components.home.trailer', ['trailer' => $trailer])
        @endif

        @if($featuresEnabled)
            @include('components.home.features', [
                'featuresTitle' => $featuresTitle,
                'featureItems' => $featureItems,
            ])
        @endif

        @if($testimonialEnabled)
            @include('components.home.testimonial', ['testimonial' => $testimonial])
        @endif

        @if($serversEnabled && ! $servers->isEmpty())
            @include('components.home.servers', ['servers' => $servers])
        @endif

        @if($blogEnabled && $latestPosts->isNotEmpty())
            @include('components.home.blog', [
                'blogTitle' => $blogTitle,
                'blogSubtitle' => $blogSubtitle,
                'latestPosts' => $latestPosts,
            ])
        @endif
    </main>
@endsection
