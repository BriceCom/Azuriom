@php
    $resolvedThemeEditorVersion = isset($themeEditorVersion) && is_string($themeEditorVersion) && $themeEditorVersion !== ''
        ? $themeEditorVersion
        : '1';
    $teBlockHandlersAssetPath = theme_path('assets/js/theme-editor/editor-block-handlers.js');
    $teHasBlockHandlersAsset = is_string($teBlockHandlersAssetPath) && is_file($teBlockHandlersAssetPath);
@endphp

@auth
    @can('admin')
        <link href="{{ theme_asset('js/theme-editor/editor.css').'?ver='.$resolvedThemeEditorVersion }}" rel="stylesheet">

        @include('theme-editor.offcanvas', ['theme' => $theme ?? themes()->currentTheme()])

        <script src="{{ theme_asset('js/theme-editor/editor-i18n.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
        <script src="{{ theme_asset('js/theme-editor/editor-presets.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
        @if($teHasBlockHandlersAsset)
            <script src="{{ theme_asset('js/theme-editor/editor-block-handlers.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
        @endif
        <script src="{{ theme_asset('js/theme-editor/editor-core-variables.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
        <script src="{{ theme_asset('js/theme-editor/editor-core-layout.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
        <script src="{{ theme_asset('js/theme-editor/editor-core.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
        <script src="{{ theme_asset('js/theme-editor/editor.js').'?ver='.$resolvedThemeEditorVersion }}" defer></script>
    @endcan
@endauth
