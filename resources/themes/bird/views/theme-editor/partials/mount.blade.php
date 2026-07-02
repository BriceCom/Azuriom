@include('theme-editor.partials.init')
@include('theme-editor.partials.context')

@php
    $teThemeEditorVersion = view()->shared('teThemeEditorVersion', '1');
    $teLayoutBlockParams = view()->shared('teLayoutBlockParams', ['header' => [], 'footer' => []]);
    $teHeaderView = view()->shared('teHeaderView');
    $teFooterView = view()->shared('teFooterView');
    $teBlockViews = view()->shared('teBlockViews', []);
    $tePageContentView = view()->shared('tePageContentView');
    $teBlocksForRoute = view()->shared('teBlocksForRoute', collect());
    $teContentBlocksForRoute = view()->shared('teContentBlocksForRoute', collect());
@endphp

@once
    @push('styles')
        <link href="{{ theme_asset('js/theme-editor/aos.css').'?ver='.$teThemeEditorVersion }}" rel="stylesheet">
        @include('theme-editor.partials.styles')
    @endpush

    @push('footer-scripts')
        @include('theme-editor.partials.inject', [
            'theme' => themes()->currentTheme(),
            'themeEditorVersion' => $teThemeEditorVersion ?? '1',
        ])
    @endpush
@endonce
