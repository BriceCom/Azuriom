@include('theme-editor.partials.init')

@php
    $teThemeEditorVersion = isset($teThemeEditorVersion) && is_string($teThemeEditorVersion) && $teThemeEditorVersion !== ''
        ? $teThemeEditorVersion
        : (string) view()->shared('teThemeEditorVersion', '1');

    $teLayoutBlockParams = is_array($teLayoutBlockParams ?? null)
        ? $teLayoutBlockParams
        : view()->shared('teLayoutBlockParams', ['header' => [], 'footer' => []]);
    if (!is_array($teLayoutBlockParams)) {
        $teLayoutBlockParams = ['header' => [], 'footer' => []];
    }

    $teHeaderView = isset($teHeaderView) && is_string($teHeaderView)
        ? $teHeaderView
        : view()->shared('teHeaderView');
    $teFooterView = isset($teFooterView) && is_string($teFooterView)
        ? $teFooterView
        : view()->shared('teFooterView');

    $teBlockViews = isset($teBlockViews) && is_array($teBlockViews)
        ? $teBlockViews
        : (is_array(view()->shared('teBlockViews')) ? view()->shared('teBlockViews') : []);
    $tePageContentView = isset($tePageContentView) && is_string($tePageContentView)
        ? $tePageContentView
        : (is_string(view()->shared('tePageContentView')) ? view()->shared('tePageContentView') : null);

    $teContentBlocksForRoute = $teContentBlocksForRoute ?? view()->shared('teContentBlocksForRoute', collect());
    if (!($teContentBlocksForRoute instanceof \Illuminate\Support\Collection)) {
        $teContentBlocksForRoute = collect(is_array($teContentBlocksForRoute) ? $teContentBlocksForRoute : []);
    }
@endphp
