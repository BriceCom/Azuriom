@extends('layouts.base')

@php
    $route = request()->route();
    $routeName = $route ? $route->getName() : null;
    $path = trim(request()->path(), '/');
    $pageIdentifier = $routeName ?: 'uri:' . ($path === '' ? '/' : $path);
    $pagebuilderPageKey = app()->getLocale() . '::' . $pageIdentifier;

    $pagebuilderRaw = setting('themes.config.pagebuilder')['pagebuilder'] ?? null;
    $pagebuilderConfig = is_string($pagebuilderRaw) ? json_decode($pagebuilderRaw, true) : $pagebuilderRaw;
    $pagebuilderComponents = [];
    $pagebuilderCss = '';

    $isComponentMap = static function ($value): bool {
        if (!is_array($value)) {
            return false;
        }

        if ($value === []) {
            return true;
        }

        foreach ($value as $component) {
            if (!is_array($component)) {
                return false;
            }

            if (!isset($component['type']) && !isset($component['tagName']) && !isset($component['components']) && !isset($component['content'])) {
                return false;
            }
        }

        return true;
    };

    $normalizePageEntry = static function ($entry) use ($isComponentMap) {
        if ($isComponentMap($entry)) {
                return [
                    'components' => $entry,
                    'css' => '',
                    'theme_tokens' => [],
                    'metadata' => [],
                    'last_snapshot' => null,
            ];
        }

        if (!is_array($entry)) {
            return null;
        }

        $components = $entry['components'] ?? null;
        if ($isComponentMap($components)) {
                $normalized = [
                    'components' => $components,
                    'css' => is_string($entry['css'] ?? null) ? $entry['css'] : '',
                    'theme_tokens' => is_array($entry['theme_tokens'] ?? null) ? $entry['theme_tokens'] : [],
                    'metadata' => is_array($entry['metadata'] ?? null) ? $entry['metadata'] : [],
                    'last_snapshot' => null,
            ];

            $lastSnapshot = $entry['last_snapshot'] ?? null;
            if (is_array($lastSnapshot) && $isComponentMap($lastSnapshot['components'] ?? null)) {
                    $normalized['last_snapshot'] = [
                        'components' => $lastSnapshot['components'],
                        'css' => is_string($lastSnapshot['css'] ?? null) ? $lastSnapshot['css'] : '',
                        'theme_tokens' => is_array($lastSnapshot['theme_tokens'] ?? null) ? $lastSnapshot['theme_tokens'] : [],
                        'metadata' => is_array($lastSnapshot['metadata'] ?? null) ? $lastSnapshot['metadata'] : [],
                    ];
            }

            return $normalized;
        }

        $snapshotComponents = $entry['last_snapshot']['components'] ?? null;
        if ($isComponentMap($snapshotComponents)) {
                return [
                    'components' => $snapshotComponents,
                    'css' => is_string($entry['last_snapshot']['css'] ?? null) ? $entry['last_snapshot']['css'] : '',
                    'theme_tokens' => is_array($entry['last_snapshot']['theme_tokens'] ?? null) ? $entry['last_snapshot']['theme_tokens'] : [],
                    'metadata' => is_array($entry['last_snapshot']['metadata'] ?? null) ? $entry['last_snapshot']['metadata'] : [],
                    'last_snapshot' => null,
            ];
        }

        return null;
    };

    if (is_array($pagebuilderConfig)) {
        if (isset($pagebuilderConfig['pages']) && is_array($pagebuilderConfig['pages'])) {
            $scopedEntry = $normalizePageEntry($pagebuilderConfig['pages'][$pagebuilderPageKey] ?? null);

                if ($scopedEntry !== null) {
                    $pagebuilderComponents = $scopedEntry['components'];
                    $pagebuilderCss = $scopedEntry['css'] ?? '';
                }
            }
        }

    $hasPagebuilderContent = !empty($pagebuilderComponents);
    $pagebuilderContextKeys = [
        'name', 'user', 'request', 'sites', 'rewards', 'votes', 'userVotes', 'displayRewards', 'authRequired',
        'category', 'categories', 'displayHome', 'goal', 'topCustomer', 'recentPayments', 'displaySidebarAmount', 'welcome',
        'shopUser', 'userHasPayments',
    ];
    $pagebuilderRenderContext = [];
    $pagebuilderDefinedVars = get_defined_vars();

    foreach ($pagebuilderContextKeys as $contextKey) {
        if (array_key_exists($contextKey, $pagebuilderDefinedVars)) {
            $pagebuilderRenderContext[$contextKey] = $pagebuilderDefinedVars[$contextKey];
        }
    }
@endphp

@section('app')
    <main class="container content my-5">
        <div data-pagebuilder-slot="main-content" data-pagebuilder-page="{{ $pagebuilderPageKey }}">
            @if($hasPagebuilderContent)
                @if(!empty($pagebuilderCss))
                    <style>{!! $pagebuilderCss !!}</style>
                @endif
                @foreach($pagebuilderComponents as $component)
                    <x-render-component :component="$component" :context="$pagebuilderRenderContext" />
                @endforeach
            @else
                @include('elements.session-alerts')
                @yield('content')
            @endif
        </div>
    </main>
@endsection
