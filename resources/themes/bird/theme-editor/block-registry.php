<?php

$registryPath = theme_path('views/theme-editor/registry/catalog.php');
$registry = (is_string($registryPath) && is_file($registryPath))
    ? require $registryPath
    : [];

if (! is_array($registry)) {
    $registry = [];
}

$fallbackAosOptions = [
    'none',
    'fade-up',
    'fade-down',
    'fade-left',
    'fade-right',
    'zoom-in',
    'zoom-out',
    'flip-up',
    'flip-down',
];
$aosOptions = array_values(array_filter(
    is_array($registry['aos_options'] ?? null) ? $registry['aos_options'] : $fallbackAosOptions,
    static fn ($value) => is_string($value) && $value !== ''
));
if (count($aosOptions) === 0) {
    $aosOptions = $fallbackAosOptions;
}

$catalog = is_array($registry['catalog'] ?? null) ? $registry['catalog'] : [];
$viewMap = is_array($registry['view_map'] ?? null) ? $registry['view_map'] : [];

$normalizeBlockId = static function ($id): ?string {
    if (! is_string($id)) {
        return null;
    }

    $trimmed = trim($id);
    return $trimmed === '' ? null : $trimmed;
};

$normalizeDiscoveredId = static function (string $fileName): ?string {
    $base = trim(pathinfo($fileName, PATHINFO_FILENAME));
    if ($base === '' || $base === 'partials') {
        return null;
    }

    $id = str_replace('-', '_', $base);
    return $id === '' ? null : $id;
};

$humanizeBlockLabel = static function (string $id): string {
    $label = str_replace('_', ' ', $id);
    return ucwords($label);
};

$catalogById = [];
$orderedIds = [];
foreach ($catalog as $item) {
    $id = $normalizeBlockId(is_array($item) ? ($item['id'] ?? null) : null);
    if ($id === null || isset($catalogById[$id])) {
        continue;
    }

    $catalogById[$id] = is_array($item) ? $item : [];
    $catalogById[$id]['id'] = $id;
    $orderedIds[] = $id;

    if (! isset($viewMap[$id]) && is_string($catalogById[$id]['view'] ?? null)) {
        $viewMap[$id] = $catalogById[$id]['view'];
    }
}

foreach ($viewMap as $id => $view) {
    $normalizedId = $normalizeBlockId($id);
    if ($normalizedId === null || isset($catalogById[$normalizedId])) {
        continue;
    }

    $catalogById[$normalizedId] = [
        'id' => $normalizedId,
        'label' => $humanizeBlockLabel($normalizedId),
        'default_params' => [],
        'params' => [],
    ];
    $orderedIds[] = $normalizedId;
}

$discoveryRoots = array_values(array_filter(
    is_array($registry['block_view_discovery_roots'] ?? null)
        ? $registry['block_view_discovery_roots']
        : ['views/theme-editor/blocks'],
    static fn ($value) => is_string($value) && trim($value) !== ''
));

foreach ($discoveryRoots as $discoveryRoot) {
    $normalizedRoot = trim(str_replace('\\', '/', $discoveryRoot), '/');
    $rootPath = theme_path($normalizedRoot);
    if (! is_string($rootPath) || ! is_dir($rootPath)) {
        continue;
    }

    $viewPrefix = str_starts_with($normalizedRoot, 'views/')
        ? substr($normalizedRoot, 6)
        : $normalizedRoot;
    $viewPrefix = trim(str_replace('/', '.', $viewPrefix), '.');

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if (! $fileInfo instanceof SplFileInfo || ! $fileInfo->isFile()) {
            continue;
        }

        $filePath = str_replace('\\', '/', $fileInfo->getPathname());
        if (! str_ends_with($filePath, '.blade.php')) {
            continue;
        }
        if (str_contains($filePath, '/partials/')) {
            continue;
        }

        $relative = trim(str_replace('\\', '/', substr($filePath, strlen($rootPath))), '/');
        $relativeView = str_replace('/', '.', preg_replace('/\.blade\.php$/', '', $relative));
        $viewName = trim($viewPrefix.'.'.$relativeView, '.');

        $mappedId = array_search($viewName, $viewMap, true);
        $id = is_string($mappedId) && trim($mappedId) !== ''
            ? trim($mappedId)
            : $normalizeDiscoveredId($fileInfo->getBasename('.blade.php'));
        if ($id === null) {
            continue;
        }

        if (! isset($viewMap[$id])) {
            $viewMap[$id] = $viewName;
        }

        if (! isset($catalogById[$id])) {
            $catalogById[$id] = [
                'id' => $id,
                'label' => $humanizeBlockLabel($id),
                'default_params' => [],
                'params' => [],
            ];
            $orderedIds[] = $id;
        }
    }
}

$aosParam = [
    'key' => 'aos',
    'label' => 'Animation',
    'type' => 'select',
    'options' => $aosOptions,
    'rules' => ['nullable', 'in:'.implode(',', $aosOptions)],
];

$finalCatalog = [];
foreach ($orderedIds as $id) {
    $item = $catalogById[$id] ?? null;
    if (! is_array($item)) {
        continue;
    }

    $view = $viewMap[$id] ?? null;
    if (! is_string($view) || $view === '' || ! view()->exists($view)) {
        continue;
    }

    $item['default_params'] = is_array($item['default_params'] ?? null) ? $item['default_params'] : [];
    $item['params'] = is_array($item['params'] ?? null) ? $item['params'] : [];

    if (! in_array($id, ['header', 'footer', 'page_content'], true)) {
        $item['default_params']['aos'] = is_string($item['default_params']['aos'] ?? null)
            ? $item['default_params']['aos']
            : 'none';

        $hasAosParam = false;
        foreach ($item['params'] as $param) {
            if (is_array($param) && ($param['key'] ?? null) === 'aos') {
                $hasAosParam = true;
                break;
            }
        }
        if (! $hasAosParam) {
            array_unshift($item['params'], $aosParam);
        }
    }

    if (! is_string($item['label'] ?? null) || trim((string) $item['label']) === '') {
        $item['label'] = $humanizeBlockLabel($id);
    }

    $finalCatalog[] = $item;
}

$finalViewMap = [];
$defaultParams = [];
$paramDefinitions = [];
$paramRules = [];

foreach ($finalCatalog as $item) {
    $id = $item['id'];
    $view = $viewMap[$id] ?? null;
    if (! is_string($view) || $view === '') {
        continue;
    }

    $finalViewMap[$id] = $view;
    $defaultParams[$id] = $item['default_params'];
    $paramDefinitions[$id] = $item['params'];

    foreach ($item['params'] as $definition) {
        $key = is_array($definition) ? ($definition['key'] ?? null) : null;
        $rules = is_array($definition) ? ($definition['rules'] ?? null) : null;
        if (! is_string($key) || $key === '' || ! is_array($rules) || count($rules) === 0) {
            continue;
        }

        $paramRules[$id][$key] = $rules;
    }
}

$paramRulesOverrides = is_array($registry['param_rules'] ?? null)
    ? $registry['param_rules']
    : (is_array($registry['param_rules_overrides'] ?? null) ? $registry['param_rules_overrides'] : []);
foreach ($paramRulesOverrides as $blockId => $rules) {
    if (! is_array($rules)) {
        continue;
    }
    $paramRules[$blockId] = array_replace($paramRules[$blockId] ?? [], $rules);
}

$withLayoutBlocks = static function (array $ids): array {
    $sanitized = array_values(array_filter(
        $ids,
        static fn ($id) => is_string($id) && $id !== 'header' && $id !== 'footer',
    ));
    array_unshift($sanitized, 'header');
    $sanitized[] = 'footer';

    return array_values(array_unique($sanitized));
};

$defaultBlocksForRoute = is_callable($registry['default_blocks_for_route'] ?? null)
    ? $registry['default_blocks_for_route']
    : static function (?string $routeName, ?string $routePattern, string $routePath) use ($withLayoutBlocks): array {
        return $withLayoutBlocks(['page_content']);
    };

return [
    'catalog' => $finalCatalog,
    'view_map' => $finalViewMap,
    'block_ids' => array_values(array_keys($finalViewMap)),
    'default_params' => $defaultParams,
    'param_definitions' => $paramDefinitions,
    'param_rules' => $paramRules,
    'default_blocks_for_route' => $defaultBlocksForRoute,
];
