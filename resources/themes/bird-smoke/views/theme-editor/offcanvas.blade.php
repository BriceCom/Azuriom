@php
    $azuriomImages = \Azuriom\Models\Image::query()
        ->latest('id')
        ->limit(250)
        ->get();
    $editorImages = $azuriomImages->map(static fn (\Azuriom\Models\Image $image) => [
        'name' => $image->name,
        'file' => $image->file,
        'url' => $image->url(),
    ])->values()->all();
    $editorImageFiles = array_values(array_filter(array_map(static fn (array $image) => $image['file'] ?? null, $editorImages)));

    $themeEditorConfigPath = theme_path('theme-editor/editor-config.php');
    $themeEditorConfig = (is_string($themeEditorConfigPath) && is_file($themeEditorConfigPath))
        ? require $themeEditorConfigPath
        : [];

    $themeEditorRootId = is_string($themeEditorConfig['root_id'] ?? null) && $themeEditorConfig['root_id'] !== ''
        ? $themeEditorConfig['root_id']
        : 'theme-editor-root';
    $themeEditorPanelId = is_string($themeEditorConfig['panel_id'] ?? null) && $themeEditorConfig['panel_id'] !== ''
        ? $themeEditorConfig['panel_id']
        : 'themeEditorPanel';
    $themeEditorScriptIds = array_replace([
        'runtime' => 'theme-editor-runtime',
        'initial' => 'theme-editor-initial',
        'defaults' => 'theme-editor-defaults',
        'catalog' => 'theme-editor-catalog',
        'images' => 'theme-editor-images',
        'lang' => 'theme-editor-lang',
    ], is_array($themeEditorConfig['script_ids'] ?? null) ? $themeEditorConfig['script_ids'] : []);
    $themeEditorStorage = array_replace([
        'last_tab_key' => 'theme_editor_last_tab',
    ], is_array($themeEditorConfig['storage'] ?? null) ? $themeEditorConfig['storage'] : []);
    $themeEditorRuntimeIds = array_replace([
        'live_style' => 'theme-editor-live',
        'font_link' => 'theme-editor-font-link',
        'announce_bar' => 'theme-editor-announce-bar',
        'scroll_progress' => 'theme-editor-scroll-progress',
    ], is_array($themeEditorConfig['runtime_ids'] ?? null) ? $themeEditorConfig['runtime_ids'] : []);
    $themeEditorAttrs = array_replace([
        'container' => 'data-te-block-container',
        'block' => 'data-te-block',
        'template_block' => 'data-te-template-block',
        'param' => 'data-te-param',
        'param_href' => 'data-te-param-href',
        'param_image' => 'data-te-param-image',
        'param_list' => 'data-te-param-list',
        'param_class' => 'data-te-param-class',
        'node' => 'data-te-node',
        'empty_image' => 'data-te-empty-image',
        'footer_logo' => 'data-te-footer-logo',
        'footer_social' => 'data-te-footer-social',
    ], is_array($themeEditorConfig['attrs'] ?? null) ? $themeEditorConfig['attrs'] : []);

    $themeEditorRuntime = [
        'root_id' => $themeEditorRootId,
        'panel_id' => $themeEditorPanelId,
        'script_ids' => $themeEditorScriptIds,
        'storage' => $themeEditorStorage,
        'runtime_ids' => $themeEditorRuntimeIds,
        'attrs' => $themeEditorAttrs,
    ];

    $themeEditorRegistryPath = theme_path('theme-editor/block-registry.php');
    $themeEditorRegistry = (is_string($themeEditorRegistryPath) && is_file($themeEditorRegistryPath))
        ? require $themeEditorRegistryPath
        : [];

    $blockCatalog = is_array($themeEditorRegistry['catalog'] ?? null)
        ? $themeEditorRegistry['catalog']
        : [];
    $blockViewMap = is_array($themeEditorRegistry['view_map'] ?? null)
        ? $themeEditorRegistry['view_map']
        : [];
    $defaultBlocksForRoute = is_callable($themeEditorRegistry['default_blocks_for_route'] ?? null)
        ? $themeEditorRegistry['default_blocks_for_route']
        : static function (?string $routeName, ?string $routePattern, string $routePath): array {
            $withLayoutBlocks = static function (array $ids): array {
                $sanitized = array_values(array_filter(
                    $ids,
                    static fn ($id) => is_string($id) && $id !== 'header' && $id !== 'footer',
                ));

                array_unshift($sanitized, 'header');
                $sanitized[] = 'footer';

                return array_values(array_unique($sanitized));
            };

            $normalizedRouteName = strtolower(trim((string) $routeName));
            if ($routePath === '/' || $normalizedRouteName === 'home') {
                return $withLayoutBlocks(['hero', 'features', 'servers', 'news', 'steps', 'stats', 'cta']);
            }

            return $withLayoutBlocks(['page_content']);
        };

    $defaultLightColors = [
        'primary' => '#00b7ff',
        'secondary' => '#c8cccd',
        'tertiary' => '#f8ca47',
        'quaternary' => '#ecaf2d',
        'background' => '#f2f2f2',
        'dark_tone_1' => '#e3e2e2',
        'dark_tone_2' => '#d7d7d7',
        'light_tone_1' => '#fafafa',
        'light_tone_2' => '#ffffff',
        'text' => '#111111',
        'text_background' => '#ffffff',
        'alert_success' => '#bbf24b',
        'alert_info' => '#0dcaf0',
        'alert_warning' => '#f88934',
        'alert_error' => '#dc3545',
    ];

    $defaultDarkColors = [
        'primary' => '#00b7ff',
        'secondary' => '#3e404d',
        'tertiary' => '#f8ca47',
        'quaternary' => '#ff6cba',
        'background' => '#111111',
        'dark_tone_1' => '#070606',
        'dark_tone_2' => '#17191b',
        'light_tone_1' => '#21262c',
        'light_tone_2' => '#2b3036',
        'text' => '#ffffff',
        'text_background' => '#21262c',
        'alert_success' => '#bbf24b',
        'alert_info' => '#3499f8',
        'alert_warning' => '#f88934',
        'alert_error' => '#f83434',
    ];

    $editorLang = [
        'state' => [
            'idle' => 'Idle',
            'open' => 'Open',
            'dirty' => 'Dirty',
            'saving' => 'Saving',
            'saved' => 'Saved',
            'error' => 'Error',
        ],
        'status' => [
            'unsaved_changes' => 'Modifications non sauvegardées',
            'up_to_date' => 'À jour',
            'editor_opened' => 'Éditeur ouvert',
            'ready' => 'Prêt',
            'preview_applied' => 'Prévisualisation appliquée',
            'saving_in_progress' => 'Sauvegarde en cours...',
            'save_failed' => 'Échec de la sauvegarde',
            'last_config_restored' => 'Dernière configuration restaurée',
        ],
        'messages' => [
            'block_added' => 'Bloc "{label}" ajouté sur {route}',
            'block_updated' => 'Bloc "{label}" mis à jour sur {route}',
            'blocks_reordered' => 'Ordre des blocs mis à jour sur {route}',
            'no_active_block_for_route' => 'Aucun bloc actif pour {route}.',
            'config_saved_for_route' => 'Configuration sauvegardée ({route})',
        ],
    ];

    if (isset($themeEditorLang) && is_array($themeEditorLang)) {
        $editorLang = array_replace_recursive($editorLang, $themeEditorLang);
    }

    $adminThemeEditorLang = trans('admin.theme_editor');
    if (is_array($adminThemeEditorLang)) {
        $editorLang = array_replace_recursive($editorLang, $adminThemeEditorLang);
    }

    $route = request()->route();
    $routeName = $route?->getName();
    $routePattern = $route && method_exists($route, 'uri') ? $route->uri() : null;
    $path = trim(request()->path(), '/');
    $routePath = $path === '' ? '/' : '/'.$path;
    $currentRouteLabel = $routeName ?: ($routePattern ? '/'.$routePattern : $routePath);
    $currentRouteSignature = $routeName
        ? 'route:'.$routeName
        : ($routePattern ? 'uri:'.$routePattern : 'path:'.$routePath);
    $currentRouteKey = 'r_'.substr(md5($currentRouteSignature), 0, 16);

    $pageBlocks = theme_config('page.blocks', []);
    if (! is_array($pageBlocks)) {
        $pageBlocks = [];
    }

    $isList = static function (array $array): bool {
        if (function_exists('array_is_list')) {
            return array_is_list($array);
        }

        return array_keys($array) === range(0, count($array) - 1);
    };

    if ($isList($pageBlocks)) {
        $pageBlocks = [$currentRouteKey => $pageBlocks];
    }

    foreach ($pageBlocks as $routeKey => $blocks) {
        if (! is_array($blocks)) {
            $pageBlocks[$routeKey] = [];
            continue;
        }

        $pageBlocks[$routeKey] = array_values(array_filter($blocks, static fn ($block) => is_array($block) && isset($block['id'])));
    }

    if (! array_key_exists($currentRouteKey, $pageBlocks)) {
        $pageBlocks[$currentRouteKey] = [];
    }

    if (! count($pageBlocks[$currentRouteKey])) {
        $defaultRouteBlocks = array_values(array_filter(
            $defaultBlocksForRoute($routeName, $routePattern, $routePath),
            static fn ($id) => is_string($id) && isset($blockViewMap[$id]),
        ));

        $pageBlocks[$currentRouteKey] = array_values(array_map(static fn (string $id, int $index) => [
            'id' => $id,
            'order' => $index + 1,
            'params' => [],
        ], $defaultRouteBlocks, array_keys($defaultRouteBlocks)));
    }

    $lightColors = [];
    foreach ($defaultLightColors as $key => $default) {
        $lightColors[$key] = theme_config("styles.colors.light.$key", $default);
    }

    $darkColors = [];
    foreach ($defaultDarkColors as $key => $default) {
        $darkColors[$key] = theme_config("styles.colors.dark.$key", $default);
    }

    $defaultRouteBlockIds = array_values(array_filter(
        $defaultBlocksForRoute($routeName, $routePattern, $routePath),
        static fn ($id) => is_string($id) && isset($blockViewMap[$id]),
    ));
    $defaultRouteBlocks = array_values(array_map(static fn (string $id, int $index) => [
        'id' => $id,
        'order' => $index + 1,
        'params' => [],
    ], $defaultRouteBlockIds, array_keys($defaultRouteBlockIds)));

    $serverOnlineCount = 0;
    if (isset($servers) && $servers instanceof \Illuminate\Support\Collection) {
        $serverOnlineCount = (int) $servers->where('home_display', true)->sum(static function ($server) {
            return method_exists($server, 'isOnline') && $server->isOnline() && method_exists($server, 'getOnlinePlayers')
                ? $server->getOnlinePlayers()
                : 0;
        });
    }

    $systemVariables = [
        [
            'key' => 'discord_online_count',
            'label' => 'Membres Discord en ligne',
            'value' => 0,
            'locked' => true,
        ],
        [
            'key' => 'servers_online_count',
            'label' => 'Joueurs en ligne (serveurs home_display)',
            'value' => $serverOnlineCount,
            'locked' => true,
        ],
    ];

    $customVariables = theme_config('variables.custom', []);
    if (!is_array($customVariables)) {
        $customVariables = [];
    }
    $customVariables = array_values(array_filter(array_map(static function ($variable) {
        if (!is_array($variable)) {
            return null;
        }
        $key = trim((string) ($variable['key'] ?? ''));
        $value = (string) ($variable['value'] ?? '');
        if ($key === '' || !preg_match('/^[A-Za-z0-9_]+$/', $key)) {
            return null;
        }
        return ['key' => $key, 'value' => $value];
    }, $customVariables)));

    $editorDefaultState = [
        'styles' => [
            'theme_dark_disabled' => false,
            'theme_priority' => 'dark',
            'bg_light' => null,
            'bg_dark' => null,
            'font_custom_enabled' => false,
            'font_body_url' => '',
            'font_body_name' => '',
            'font_heading_url' => '',
            'font_heading_name' => '',
            'colors' => [
                'light' => $defaultLightColors,
                'dark' => $defaultDarkColors,
            ],
        ],
        'global' => [
            'particles_enabled' => false,
            'particles_count' => 80,
            'particles_density' => 50,
            'particles_image' => null,
            'particles_speed' => 3,
            'particles_size' => 3,
            'discord_link' => '',
            'discord_id' => '',
            'server_launcher' => false,
            'server_launcher_url' => '',
            'server_launcher_button_text' => '',
            'server_address' => '',
        ],
        'advanced' => [
            'advanced_mode' => false,
            'serveurliste_link' => '',
            'serveurliste_token' => '',
        ],
        'modules' => [
            'announce_bar' => [
                'enabled' => false,
                'text' => '',
                'background_color' => '#1a1a2e',
            ],
            'scroll_progress' => [
                'enabled' => false,
                'height' => 8,
                'background_color' => '#1a1a2e',
                'color' => '#6c63ff',
            ],
        ],
        'page' => [
            'current_route_key' => $currentRouteKey,
            'current_route_label' => $currentRouteLabel,
            'current_route_signature' => $currentRouteSignature,
            'blocks' => [
                $currentRouteKey => $defaultRouteBlocks,
            ],
        ],
        'variables' => [
            'system' => $systemVariables,
            'custom' => [],
        ],
    ];

    $editorState = [
        'styles' => [
            'theme_dark_disabled' => (bool) theme_config('styles.theme_dark_disabled', false),
            'theme_priority' => theme_config('styles.theme_priority', 'dark'),
            'bg_light' => theme_config('styles.bg_light'),
            'bg_dark' => theme_config('styles.bg_dark'),
            'font_custom_enabled' => (bool) theme_config('styles.font_custom_enabled', false),
            'font_body_url' => theme_config('styles.font_body_url', ''),
            'font_body_name' => theme_config('styles.font_body_name', ''),
            'font_heading_url' => theme_config('styles.font_heading_url', ''),
            'font_heading_name' => theme_config('styles.font_heading_name', ''),
            'colors' => [
                'light' => $lightColors,
                'dark' => $darkColors,
            ],
        ],
        'global' => [
            'particles_enabled' => (bool) theme_config('global.particles_enabled', false),
            'particles_count' => (int) theme_config('global.particles_count', 80),
            'particles_density' => (int) theme_config('global.particles_density', 50),
            'particles_image' => theme_config('global.particles_image'),
            'particles_speed' => (int) theme_config('global.particles_speed', 3),
            'particles_size' => (int) theme_config('global.particles_size', 3),
            'discord_link' => theme_config('global.discord_link', ''),
            'discord_id' => theme_config('global.discord_id', ''),
            'server_launcher' => (bool) theme_config('global.server_launcher', false),
            'server_launcher_url' => theme_config('global.server_launcher_url', ''),
            'server_launcher_button_text' => theme_config('global.server_launcher_button_text', ''),
            'server_address' => theme_config('global.server_address', ''),
        ],
        'advanced' => [
            'advanced_mode' => (bool) theme_config('advanced.advanced_mode', false),
            'serveurliste_link' => theme_config('advanced.serveurliste_link', ''),
            'serveurliste_token' => theme_config('advanced.serveurliste_token', ''),
        ],
        'modules' => [
            'announce_bar' => [
                'enabled' => (bool) theme_config('modules.announce_bar.enabled', false),
                'text' => theme_config('modules.announce_bar.text', ''),
                'background_color' => theme_config('modules.announce_bar.background_color', '#1a1a2e'),
            ],
            'scroll_progress' => [
                'enabled' => (bool) theme_config('modules.scroll_progress.enabled', false),
                'height' => (int) theme_config('modules.scroll_progress.height', 8),
                'background_color' => theme_config('modules.scroll_progress.background_color', '#1a1a2e'),
                'color' => theme_config('modules.scroll_progress.color', '#6c63ff'),
            ],
        ],
        'page' => [
            'current_route_key' => $currentRouteKey,
            'current_route_label' => $currentRouteLabel,
            'current_route_signature' => $currentRouteSignature,
            'blocks' => $pageBlocks,
        ],
        'variables' => [
            'system' => $systemVariables,
            'custom' => $customVariables,
        ],
    ];
@endphp

<div id="{{ $themeEditorRootId }}" data-theme-editor-root>
    <button id="themeEditorToggle" class="te-toggle" type="button" aria-controls="{{ $themeEditorPanelId }}" aria-expanded="false">
        Éditer
    </button>

    <aside id="{{ $themeEditorPanelId }}" class="te-panel" aria-hidden="true">
        <header class="te-header">
            <div>
                <h2 class="te-title">Theme Editor Live</h2>
                <p id="teStatusText" class="te-status-text">Prêt</p>
            </div>
            <div class="te-header-actions">
                <span id="teStateBadge" class="te-state-badge">Idle</span>
                <button type="button" id="themeEditorClose" class="te-icon-btn" aria-label="Fermer">×</button>
            </div>
        </header>

        <nav class="te-tabs" role="tablist" aria-label="Theme Editor tabs">
            <button type="button" class="te-tab te-tab-active" data-te-tab-target="styles">Styles</button>
            <button type="button" class="te-tab" data-te-tab-target="global">Global</button>
            <button type="button" class="te-tab" data-te-tab-target="advanced">Mode avancé</button>
            <button type="button" class="te-tab" data-te-tab-target="modules">Modules</button>
            <button type="button" class="te-tab" data-te-tab-target="variables">Variables</button>
            <button type="button" class="te-tab" data-te-tab-target="page">Page builder</button>
        </nav>

        <div class="te-content">
            <section class="te-tab-panel te-tab-panel-active" data-te-tab="styles">
                @include('theme-editor.tabs.styles')
            </section>

            <section class="te-tab-panel" data-te-tab="global" hidden>
                @include('theme-editor.tabs.global')
            </section>

            <section class="te-tab-panel" data-te-tab="advanced" hidden>
                @include('theme-editor.tabs.advanced')
            </section>

            <section class="te-tab-panel" data-te-tab="modules" hidden>
                @include('theme-editor.tabs.modules')
            </section>

            <section class="te-tab-panel" data-te-tab="variables" hidden>
                @include('theme-editor.tabs.variables')
            </section>

            <section class="te-tab-panel" data-te-tab="page" hidden>
                @include('theme-editor.tabs.page')
            </section>
        </div>

        <footer class="te-footer">
            <a
                href="https://lank.li/dixept-discord"
                target="_blank"
                rel="noopener noreferrer"
                class="te-btn te-btn-ghost te-btn-support"
                id="teSupportLink"
            >
                <i class="bi bi-patch-question-fill"></i>
                <span>Support</span>
            </a>
            <button type="button" id="teCancel" class="te-btn te-btn-ghost">Annuler</button>
            <button type="button" id="teSave" class="te-btn te-btn-success">
                <span class="te-save-label">Save</span>
                <span class="te-save-loading" hidden>Sauvegarde…</span>
            </button>
        </footer>
    </aside>

    @include('theme-editor.partials.block-modal')
    @include('theme-editor.partials.config-form')

    <div id="themeEditorTemplates" hidden>
        @foreach($blockCatalog as $catalogItem)
            @php
                $templateBlockId = $catalogItem['id'] ?? null;
                $templateBlockView = $templateBlockId ? ($blockViewMap[$templateBlockId] ?? null) : null;
                $templateBlockParams = is_array($catalogItem['default_params'] ?? null) ? $catalogItem['default_params'] : [];
            @endphp
            @if($templateBlockView)
                <template {{ $themeEditorAttrs['template_block'] }}="{{ $templateBlockId }}">
                    @include($templateBlockView, ['params' => $templateBlockParams])
                </template>
            @endif
        @endforeach
    </div>

    <div id="themeEditorBlockForms" hidden>
        @foreach($blockCatalog as $catalogItem)
            @php
                $formBlockId = $catalogItem['id'] ?? null;
                $formBlockView = is_string($formBlockId) && $formBlockId !== ''
                    ? 'theme-editor.forms.blocks.'.$formBlockId
                    : null;
                if (!is_string($formBlockView) || !view()->exists($formBlockView)) {
                    $formBlockView = 'theme-editor.forms.blocks._generic';
                }
                $formParamDefinitions = is_array($catalogItem['params'] ?? null) ? $catalogItem['params'] : [];
            @endphp
            @if(is_string($formBlockId) && $formBlockId !== '')
                <template data-te-block-form="{{ $formBlockId }}">
                    @include($formBlockView, [
                        'block' => $catalogItem,
                        'paramDefinitions' => $formParamDefinitions,
                        'images' => $editorImages,
                    ])
                </template>
            @endif
        @endforeach
    </div>
</div>

<script id="{{ $themeEditorScriptIds['runtime'] }}" type="application/json">@json($themeEditorRuntime)</script>
<script id="{{ $themeEditorScriptIds['initial'] }}" type="application/json">@json($editorState)</script>
<script id="{{ $themeEditorScriptIds['defaults'] }}" type="application/json">@json($editorDefaultState)</script>
<script id="{{ $themeEditorScriptIds['catalog'] }}" type="application/json">@json($blockCatalog)</script>
<script id="{{ $themeEditorScriptIds['images'] }}" type="application/json">@json($editorImages)</script>
<script id="{{ $themeEditorScriptIds['lang'] }}" type="application/json">@json($editorLang)</script>
