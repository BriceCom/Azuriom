<?php

$teThemeEditorAssetPaths = [
    theme_path('assets/js/theme-editor/editor.js'),
    theme_path('assets/js/theme-editor/editor-core.js'),
];
$teThemeEditorVersionParts = [];
foreach ($teThemeEditorAssetPaths as $teThemeEditorAssetPath) {
    if (! is_string($teThemeEditorAssetPath) || ! is_file($teThemeEditorAssetPath)) {
        continue;
    }

    $teThemeEditorVersionParts[] = (string) filemtime($teThemeEditorAssetPath);
}
$teThemeEditorVersion = count($teThemeEditorVersionParts) > 0
    ? implode('.', $teThemeEditorVersionParts)
    : '1';

$teRoute = request()->route();
$teRouteName = $teRoute?->getName();
$teRoutePattern = $teRoute && method_exists($teRoute, 'uri') ? $teRoute->uri() : null;
$tePath = trim(request()->path(), '/');
$teRoutePath = $tePath === '' ? '/' : '/'.$tePath;
$teCurrentRouteSignature = $teRouteName
    ? 'route:'.$teRouteName
    : ($teRoutePattern ? 'uri:'.$teRoutePattern : 'path:'.$teRoutePath);
$teCurrentRouteKey = 'r_'.substr(md5($teCurrentRouteSignature), 0, 16);
$teIsHomeRoute = $teRoutePath === '/'
    || strtolower(trim((string) $teRouteName)) === 'home';

$teThemeEditorRegistryPath = theme_path('theme-editor/block-registry.php');
$teThemeEditorRegistry = (is_string($teThemeEditorRegistryPath) && is_file($teThemeEditorRegistryPath))
    ? require $teThemeEditorRegistryPath
    : [];

$teBlockDefaults = is_array($teThemeEditorRegistry['default_params'] ?? null)
    ? $teThemeEditorRegistry['default_params']
    : [];
$teBlockViews = is_array($teThemeEditorRegistry['view_map'] ?? null)
    ? $teThemeEditorRegistry['view_map']
    : [];
$teDefaultBlockIdsForRoute = is_callable($teThemeEditorRegistry['default_blocks_for_route'] ?? null)
    ? $teThemeEditorRegistry['default_blocks_for_route']
    : static function (?string $routeName, ?string $routePattern, string $routePath): array {
        return ['header', 'page_content', 'footer'];
    };

$teCatalog = is_array($teThemeEditorRegistry['catalog'] ?? null)
    ? $teThemeEditorRegistry['catalog']
    : [];
$teCatalogById = [];
foreach ($teCatalog as $teCatalogItem) {
    $teCatalogId = $teCatalogItem['id'] ?? null;
    if (is_string($teCatalogId) && $teCatalogId !== '') {
        $teCatalogById[$teCatalogId] = $teCatalogItem;
    }
}

$teNormalizeBlocksList = static function (array $blocks): array {
    return array_values(array_filter($blocks, static fn ($block) => is_array($block) && isset($block['id'])));
};

$tePageBlocks = theme_config('page.blocks', []);
if (! is_array($tePageBlocks)) {
    $tePageBlocks = [];
}

$teIsList = static function (array $array): bool {
    if (function_exists('array_is_list')) {
        return array_is_list($array);
    }

    return array_keys($array) === range(0, count($array) - 1);
};

if ($teIsList($tePageBlocks)) {
    $tePageBlocks = [$teCurrentRouteKey => $tePageBlocks];
}

foreach ($tePageBlocks as $teRouteKey => $teBlocks) {
    $tePageBlocks[$teRouteKey] = is_array($teBlocks)
        ? $teNormalizeBlocksList($teBlocks)
        : [];
}

$teDefaultRouteIds = array_values(array_filter(
    $teDefaultBlockIdsForRoute($teRouteName, $teRoutePattern, $teRoutePath),
    static fn ($id) => is_string($id) && isset($teBlockViews[$id]),
));

if (!isset($tePageBlocks[$teCurrentRouteKey]) || count($tePageBlocks[$teCurrentRouteKey]) === 0) {
    $tePageBlocks[$teCurrentRouteKey] = array_values(array_map(static fn (string $id, int $index) => [
        'id' => $id,
        'order' => $index + 1,
        'params' => [],
    ], $teDefaultRouteIds, array_keys($teDefaultRouteIds)));
}

$teBuildBlocksForRoute = static function (array $blocks) use ($teBlockDefaults, $teBlockViews, $teCatalogById): \Illuminate\Support\Collection {
    $uniqueBlocks = [];
    $uniqueIds = [];
    foreach ($blocks as $index => $block) {
        $id = is_array($block) && is_string($block['id'] ?? null) ? $block['id'] : null;
        if (! is_string($id) || !isset($teBlockViews[$id])) {
            continue;
        }

        $catalogItem = $teCatalogById[$id] ?? [];
        if (!empty($catalogItem['unique']) && in_array($id, $uniqueIds, true)) {
            continue;
        }

        $uniqueIds[] = $id;
        $uniqueBlocks[] = [
            'id' => $id,
            'order' => (int) ($block['order'] ?? ($index + 1)),
            'params' => array_replace(
                $teBlockDefaults[$id] ?? [],
                is_array($block['params'] ?? null) ? $block['params'] : [],
            ),
        ];
    }

    return collect($uniqueBlocks)
        ->sortBy('order')
        ->values();
};

$teBlocksForRoute = $teBuildBlocksForRoute($tePageBlocks[$teCurrentRouteKey] ?? []);
if ($teBlocksForRoute->isEmpty()) {
    $teBlocksForRoute = $teBuildBlocksForRoute(array_values(array_map(static fn (string $id, int $index) => [
        'id' => $id,
        'order' => $index + 1,
        'params' => [],
    ], $teDefaultRouteIds, array_keys($teDefaultRouteIds))));
}

if ($teIsHomeRoute) {
    $teBlocksForRoute = $teBlocksForRoute
        ->filter(static fn (array $block): bool => ($block['id'] ?? null) !== 'page_content')
        ->values();
} elseif (! $teBlocksForRoute->contains(static fn (array $block): bool => ($block['id'] ?? null) === 'page_content')) {
    $teBlocksForRoute->push([
        'id' => 'page_content',
        'order' => (int) $teBlocksForRoute->count() + 1,
        'params' => $teBlockDefaults['page_content'] ?? [],
    ]);
    $teBlocksForRoute = $teBlocksForRoute->sortBy('order')->values();
}

$teLayoutBlockParams = [
    'header' => is_array($teBlockDefaults['header'] ?? null) ? $teBlockDefaults['header'] : [],
    'footer' => is_array($teBlockDefaults['footer'] ?? null) ? $teBlockDefaults['footer'] : [],
];

foreach ($teBlocksForRoute as $teBlock) {
    $teBlockId = $teBlock['id'] ?? null;
    if (! is_string($teBlockId) || ! in_array($teBlockId, ['header', 'footer'], true)) {
        continue;
    }

    $teLayoutBlockParams[$teBlockId] = array_replace(
        $teLayoutBlockParams[$teBlockId],
        is_array($teBlock['params'] ?? null) ? $teBlock['params'] : [],
    );
}

$teContentBlocksForRoute = $teBlocksForRoute
    ->filter(static fn (array $block): bool => ! in_array($block['id'], ['header', 'footer'], true))
    ->values();

return [
    'theme_editor_version' => $teThemeEditorVersion,
    'layout_block_params' => $teLayoutBlockParams,
    'block_views' => $teBlockViews,
    'blocks_for_route' => $teBlocksForRoute,
    'content_blocks_for_route' => $teContentBlocksForRoute,
];
