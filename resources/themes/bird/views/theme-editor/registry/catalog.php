<?php

$buttonVariants = ['server', 'primary', 'secondary', 'tertiary', 'quaternary'];
$aosOptions = [
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

$withLayoutBlocks = static function (array $ids): array {
    $sanitized = array_values(array_filter(
        $ids,
        static fn ($id) => is_string($id) && $id !== 'header' && $id !== 'footer',
    ));

    array_unshift($sanitized, 'header');
    $sanitized[] = 'footer';

    return array_values(array_unique($sanitized));
};

$headerBlock = [
    'id' => 'header',
    'label' => 'Header',
    'fixed' => true,
    'required' => true,
    'unique' => true,
    'external' => true,
    'anchor' => 'start',
    'addable' => false,
    'movable' => false,
    'deletable' => false,
    'duplicable' => false,
    'default_params' => [
        'sticky' => false,
        'show_shadow' => true,
        'button_styles' => [],
    ],
    'params' => [
        ['key' => 'sticky', 'label' => 'Activer le header sticky', 'type' => 'toggle', 'rules' => ['nullable', 'boolean']],
        ['key' => 'show_shadow', 'label' => 'Afficher l’ombre', 'type' => 'toggle', 'hidden' => true, 'rules' => ['nullable', 'boolean']],
        [
            'key' => 'button_styles',
            'label' => 'Styles de boutons (par texte de lien)',
            'type' => 'list',
            'item_defaults' => ['label' => '', 'variant' => 'primary'],
            'item_fields' => [
                ['key' => 'label', 'label' => 'Texte ciblé (ex: Boutique)', 'type' => 'text'],
                ['key' => 'variant', 'label' => 'Type de bouton', 'type' => 'select', 'options' => $buttonVariants],
            ],
            'rules' => ['nullable', 'array', 'max:20'],
        ],
    ],
];

$pageContentBlock = [
    'id' => 'page_content',
    'label' => 'Contenu de la page',
    'unique' => true,
    'addable' => false,
    'editable' => false,
    'deletable' => false,
    'duplicable' => false,
    'default_params' => [],
    'params' => [],
];

$footerBlock = [
    'id' => 'footer',
    'label' => 'Footer',
    'fixed' => true,
    'required' => true,
    'unique' => true,
    'external' => true,
    'anchor' => 'end',
    'addable' => false,
    'movable' => false,
    'deletable' => false,
    'duplicable' => false,
    'default_params' => [
        'show_logo' => true,
        'description' => '',
        'show_social_links' => true,
        'show_dixept_copyright' => true,
    ],
    'params' => [
        ['key' => 'show_logo', 'label' => 'Afficher le logo', 'type' => 'toggle', 'rules' => ['nullable', 'boolean']],
        ['key' => 'description', 'label' => 'Description', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:255']],
        ['key' => 'show_social_links', 'label' => 'Afficher les liens sociaux', 'type' => 'toggle', 'rules' => ['nullable', 'boolean']],
        ['key' => 'show_dixept_copyright', 'label' => 'Afficher le copyright Dixept', 'type' => 'toggle', 'advanced' => true, 'rules' => ['nullable', 'boolean']],
    ],
];

$catalog = [$headerBlock, $pageContentBlock];

$demoCatalogPath = theme_path('views/theme-editor/registry/demo-catalog.php');
$demoRegistry = (is_string($demoCatalogPath) && is_file($demoCatalogPath))
    ? require $demoCatalogPath
    : [];
if (! is_array($demoRegistry)) {
    $demoRegistry = [];
}

$demoCatalog = is_array($demoRegistry['catalog'] ?? null) ? $demoRegistry['catalog'] : [];
foreach ($demoCatalog as $demoBlock) {
    if (! is_array($demoBlock)) {
        continue;
    }

    $catalog[] = $demoBlock;
}
$catalog[] = $footerBlock;

$viewMap = [
    'header' => 'theme-editor.blocks.home.header',
    'page_content' => 'theme-editor.blocks.home.page-content',
    'footer' => 'theme-editor.blocks.home.footer',
];

$paramRulesOverrides = [
    'header' => [
        'button_styles.*' => ['nullable', 'array'],
        'button_styles.*.label' => ['nullable', 'string', 'max:120'],
        'button_styles.*.variant' => ['nullable', 'in:'.implode(',', $buttonVariants)],
    ],
];

$demoParamRulesOverrides = is_array($demoRegistry['param_rules_overrides'] ?? null)
    ? $demoRegistry['param_rules_overrides']
    : [];
foreach ($demoParamRulesOverrides as $blockId => $rules) {
    if (! is_array($rules)) {
        continue;
    }

    $paramRulesOverrides[$blockId] = array_replace($paramRulesOverrides[$blockId] ?? [], $rules);
}

$defaultBlocksForRoute = static function (?string $routeName, ?string $routePattern, string $routePath) use ($withLayoutBlocks): array {
    $defaultBlocksPath = theme_path('views/theme-editor/registry/default-blocks.php');
    if (is_string($defaultBlocksPath) && is_file($defaultBlocksPath)) {
        $defaultBlocksResolver = require $defaultBlocksPath;
        if (is_callable($defaultBlocksResolver)) {
            return $defaultBlocksResolver($routeName, $routePattern, $routePath);
        }
    }

    return $withLayoutBlocks(['page_content']);
};

return [
    'aos_options' => $aosOptions,
    'catalog' => $catalog,
    'view_map' => $viewMap,
    'param_rules_overrides' => $paramRulesOverrides,
    'default_blocks_for_route' => $defaultBlocksForRoute,
];
