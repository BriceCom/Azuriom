@extends('layouts.base')

@php
    $rebornRoute = request()->route();
    $rebornRouteName = $rebornRoute ? $rebornRoute->getName() : null;
    $rebornPath = trim(request()->path(), '/');
    $rebornPageIdentifier = $rebornRouteName ?: 'uri:'.($rebornPath === '' ? '/' : $rebornPath);
    $rebornPageKey = app()->getLocale().'::'.$rebornPageIdentifier;

    $rebornRawComposer = setting('themes.config.reborn')['composer'] ?? null;
    $rebornComposer = [];
    if (is_string($rebornRawComposer)) {
        $rebornComposer = json_decode($rebornRawComposer, true) ?: [];
    } elseif (is_array($rebornRawComposer)) {
        $rebornComposer = $rebornRawComposer;
    }

    $rebornRegistryMap = [];
    $rebornCategories = require resource_path('themes/reborn/config/components.php');
    foreach ($rebornCategories as $rebornCategory) {
        foreach (($rebornCategory['blocks'] ?? []) as $rebornDefinition) {
            if (is_array($rebornDefinition) && is_string($rebornDefinition['type'] ?? null)) {
                $rebornRegistryMap[$rebornDefinition['type']] = $rebornDefinition;
            }
        }
    }

    $rebornNormalizeBlocks = static function ($blocks): array {
        if (!is_array($blocks)) {
            return [];
        }

        return array_values(array_filter($blocks, static function ($block) {
            return is_array($block) && is_string($block['type'] ?? null) && trim($block['type']) !== '';
        }));
    };

    $rebornGlobal = is_array($rebornComposer['global'] ?? null) ? $rebornComposer['global'] : [];
    $rebornPages = is_array($rebornComposer['pages'] ?? null) ? $rebornComposer['pages'] : [];
    $rebornPageEntry = is_array($rebornPages[$rebornPageKey] ?? null) ? $rebornPages[$rebornPageKey] : [];

    $rebornGlobalBlocks = $rebornNormalizeBlocks($rebornGlobal['blocks'] ?? []);
    $rebornGlobalSidebarBlocks = $rebornNormalizeBlocks($rebornGlobal['sidebar_blocks'] ?? []);
    $rebornPageBlocks = $rebornNormalizeBlocks($rebornPageEntry['blocks'] ?? []);

    if (!collect($rebornPageBlocks)->contains(fn ($block) => ($block['type'] ?? null) === 'custom-css')) {
        $rebornPageBlocks[] = [
            'id' => 'page-custom-css-default',
            'type' => 'custom-css',
            'enabled' => true,
            'settings' => ['css' => ''],
        ];
    }

    $rebornIsBodyBlock = static function (array $block) use ($rebornRegistryMap): bool {
        $definition = $rebornRegistryMap[$block['type']] ?? null;
        if (!is_array($definition)) {
            return false;
        }

        $placements = is_array($definition['placements'] ?? null) ? $definition['placements'] : ['body'];
        return in_array('body', $placements, true);
    };

    $rebornEnabled = static function (array $block): bool {
        return array_key_exists('enabled', $block) ? (bool) $block['enabled'] : true;
    };

    $rebornMainBlocks = array_values(array_filter(
        array_merge($rebornGlobalBlocks, $rebornPageBlocks),
        fn ($block) => $rebornEnabled($block) && $rebornIsBodyBlock($block) && (($block['type'] ?? '') !== 'custom-css')
    ));

    $rebornSidebarBlocks = array_values(array_filter(
        $rebornGlobalSidebarBlocks,
        fn ($block) => $rebornEnabled($block) && $rebornIsBodyBlock($block) && (($block['type'] ?? '') !== 'custom-css')
    ));
    $rebornShowSidebarSlot = !empty($rebornSidebarBlocks) || (auth()->check() && auth()->user()->isAdmin());

    $rebornSanitizeCss = static function ($css): string {
        if (!is_string($css)) {
            return '';
        }

        $css = trim($css);
        if ($css === '') {
            return '';
        }

        return str_replace(['</style>', '<style', '<script', '</script>'], '', $css);
    };

    $rebornPageCss = collect($rebornPageBlocks)
        ->filter(fn ($block) => ($block['type'] ?? '') === 'custom-css' && $rebornEnabled($block))
        ->map(function ($block) use ($rebornSanitizeCss) {
            $settings = is_array($block['settings'] ?? null) ? $block['settings'] : [];
            return $rebornSanitizeCss($settings['css'] ?? '');
        })
        ->filter(fn ($css) => $css !== '')
        ->implode("\n");

    $rebornContextKeys = [
        'name', 'user', 'request', 'sites', 'rewards', 'votes', 'userVotes', 'displayRewards', 'authRequired',
        'category', 'categories', 'displayHome', 'goal', 'topCustomer', 'recentPayments', 'displaySidebarAmount',
        'welcome', 'shopUser', 'userHasPayments',
    ];
    $rebornRenderContext = [];
    $rebornDefinedVars = get_defined_vars();

    foreach ($rebornContextKeys as $rebornContextKey) {
        if (array_key_exists($rebornContextKey, $rebornDefinedVars)) {
            $rebornRenderContext[$rebornContextKey] = $rebornDefinedVars[$rebornContextKey];
        }
    }
@endphp

@section('app')
    <main class="content my-5">
        <div class="container" data-reborn-page="{{ $rebornPageKey }}">
            @if(!empty($rebornPageCss))
                <style>{!! $rebornPageCss !!}</style>
            @endif

            <div class="reborn-page-grid{{ $rebornShowSidebarSlot ? ' reborn-page-grid--with-sidebar' : '' }}">
                <section class="reborn-page-main-slot">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <button type="button" class="btn btn-primary btn-sm reborn-inline-add" data-reborn-quick-add="global"
                                    title="{{ trans('theme::reborn.add_block') }}">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        @endif
                    @endauth

                    @include('elements.session-alerts')

                    @if(!empty($rebornMainBlocks))
                        @foreach($rebornMainBlocks as $rebornBlock)
                            <x-reborn.render-block :block="$rebornBlock" :context="$rebornRenderContext" />
                        @endforeach
                    @endif

                    @yield('content')
                </section>

                @if($rebornShowSidebarSlot)
                    <aside class="reborn-page-sidebar-slot">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <button type="button" class="btn btn-primary btn-sm reborn-inline-add" data-reborn-quick-add="sidebar"
                                        title="{{ trans('theme::reborn.add_block') }}">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            @endif
                        @endauth

                        @if(!empty($rebornSidebarBlocks))
                            @foreach($rebornSidebarBlocks as $rebornSidebarBlock)
                                <x-reborn.render-block :block="$rebornSidebarBlock" :context="$rebornRenderContext" />
                            @endforeach
                        @elseif(auth()->check() && auth()->user()->isAdmin())
                            <div class="alert alert-secondary mb-0">
                                {{ trans('theme::reborn.no_blocks') }}
                            </div>
                        @endif
                    </aside>
                @endif
            </div>
        </div>
    </main>
@endsection
