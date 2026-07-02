@php
    $teThemeRootPath = theme_path();
    if (is_string($teThemeRootPath) && is_dir($teThemeRootPath)) {
        $teFinder = view()->getFinder();
        if (method_exists($teFinder, 'getPaths') && method_exists($teFinder, 'addLocation')) {
            $teViewPaths = $teFinder->getPaths();
            if (!in_array($teThemeRootPath, $teViewPaths, true)) {
                $teFinder->addLocation($teThemeRootPath);
            }
        }
    }

    $teInitContextPath = theme_path('theme-editor/init-context.php');
    $teInitContext = (is_string($teInitContextPath) && is_file($teInitContextPath))
        ? require $teInitContextPath
        : [];

    $teThemeEditorVersion = is_string($teInitContext['theme_editor_version'] ?? null)
        ? $teInitContext['theme_editor_version']
        : '1';

    $teLayoutBlockParams = is_array($teInitContext['layout_block_params'] ?? null)
        ? $teInitContext['layout_block_params']
        : ['header' => [], 'footer' => []];

    $teBlockViews = is_array($teInitContext['block_views'] ?? null)
        ? $teInitContext['block_views']
        : [];

    $teHeaderView = is_string($teBlockViews['header'] ?? null) && view()->exists($teBlockViews['header'])
        ? $teBlockViews['header']
        : null;
    $teFooterView = is_string($teBlockViews['footer'] ?? null) && view()->exists($teBlockViews['footer'])
        ? $teBlockViews['footer']
        : null;
    $tePageContentView = is_string($teBlockViews['page_content'] ?? null) && view()->exists($teBlockViews['page_content'])
        ? $teBlockViews['page_content']
        : null;

    $teBlocksForRoute = $teInitContext['blocks_for_route'] ?? collect();
    if (!($teBlocksForRoute instanceof \Illuminate\Support\Collection)) {
        $teBlocksForRoute = collect(is_array($teBlocksForRoute) ? $teBlocksForRoute : []);
    }

    $teContentBlocksForRoute = $teInitContext['content_blocks_for_route'] ?? collect();
    if (!($teContentBlocksForRoute instanceof \Illuminate\Support\Collection)) {
        $teContentBlocksForRoute = collect(is_array($teContentBlocksForRoute) ? $teContentBlocksForRoute : []);
    }

    view()->share([
        'teThemeEditorVersion' => $teThemeEditorVersion,
        'teLayoutBlockParams' => $teLayoutBlockParams,
        'teBlockViews' => $teBlockViews,
        'teHeaderView' => $teHeaderView,
        'teFooterView' => $teFooterView,
        'tePageContentView' => $tePageContentView,
        'teBlocksForRoute' => $teBlocksForRoute,
        'teContentBlocksForRoute' => $teContentBlocksForRoute,
    ]);
@endphp
