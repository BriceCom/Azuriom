<?php

use Azuriom\Rules\Color;
use Illuminate\Support\Facades\Validator;

$themeEditorRegistryPath = __DIR__.'/block-registry.php';
$themeEditorRegistry = is_file($themeEditorRegistryPath)
    ? require $themeEditorRegistryPath
    : [];

$blockCatalog = is_array($themeEditorRegistry['catalog'] ?? null)
    ? $themeEditorRegistry['catalog']
    : [];
$blockParamDefinitions = is_array($themeEditorRegistry['param_definitions'] ?? null)
    ? $themeEditorRegistry['param_definitions']
    : [];
$blockParamRules = is_array($themeEditorRegistry['param_rules'] ?? null)
    ? $themeEditorRegistry['param_rules']
    : [];

$blockIds = [];
foreach ($blockCatalog as $catalogItem) {
    $blockId = $catalogItem['id'] ?? null;
    if (is_string($blockId) && $blockId !== '') {
        $blockIds[] = $blockId;
    }
}
$blockIds = array_values(array_unique($blockIds));
$blockIdRule = count($blockIds) > 0
    ? 'in:'.implode(',', $blockIds)
    : 'in:__missing_block_registry__';

$allowedParamsByBlockId = [];
foreach ($blockParamDefinitions as $blockId => $definitions) {
    if (! is_array($definitions)) {
        continue;
    }

    $allowedParamsByBlockId[$blockId] = array_values(array_filter(array_map(
        static fn ($definition) => is_array($definition) && is_string($definition['key'] ?? null)
            ? $definition['key']
            : null,
        $definitions,
    )));
}

$validateBlockParams = static function (string $attribute, mixed $value, callable $fail) use ($allowedParamsByBlockId, $blockParamRules) {
    if (! is_array($value)) {
        return;
    }

    if (! preg_match('/^page\.blocks\.([^.]+)\.(\d+)\.params$/', $attribute, $matches)) {
        return;
    }

    $routeKey = $matches[1];
    $blockIndex = (int) $matches[2];
    $blockId = request()->input("page.blocks.$routeKey.$blockIndex.id");

    if (! is_string($blockId) || $blockId === '') {
        $fail('Bloc invalide: identifiant manquant pour la validation des parametres.');
        return;
    }

    $allowedKeys = $allowedParamsByBlockId[$blockId] ?? [];
    $unknownKeys = array_values(array_diff(array_keys($value), $allowedKeys));
    if (count($unknownKeys) > 0) {
        $fail(sprintf(
            'Bloc "%s": parametres non autorises (%s).',
            $blockId,
            implode(', ', $unknownKeys),
        ));
        return;
    }

    $rules = $blockParamRules[$blockId] ?? [];
    if (! is_array($rules) || count($rules) === 0) {
        if (count($value) > 0) {
            $fail(sprintf('Bloc "%s": aucun parametre n\'est autorise pour ce bloc.', $blockId));
        }
        return;
    }

    $validator = Validator::make($value, $rules);
    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $message) {
            $fail(sprintf('Bloc "%s": %s', $blockId, $message));
        }
    }
};

return [
    'styles' => ['required', 'array'],
    'styles.theme_dark_disabled' => ['nullable', 'boolean'],
    'styles.theme_priority' => ['required', 'in:dark,light'],
    'styles.bg_light' => ['nullable', 'string'],
    'styles.bg_dark' => ['nullable', 'string'],
    'styles.font_custom_enabled' => ['nullable', 'boolean'],
    'styles.font_body_url' => ['nullable', 'url'],
    'styles.font_body_name' => ['nullable', 'string', 'max:100'],
    'styles.font_heading_url' => ['nullable', 'url'],
    'styles.font_heading_name' => ['nullable', 'string', 'max:100'],
    'styles.colors' => ['required', 'array'],
    'styles.colors.light' => ['required', 'array'],
    'styles.colors.light.*' => ['nullable', new Color()],
    'styles.colors.dark' => ['required', 'array'],
    'styles.colors.dark.*' => ['nullable', new Color()],

    'global' => ['required', 'array'],
    'global.particles_enabled' => ['nullable', 'boolean'],
    'global.particles_count' => ['nullable', 'integer', 'min:10', 'max:500'],
    'global.particles_density' => ['nullable', 'integer', 'min:1', 'max:100'],
    'global.particles_image' => ['nullable', 'string'],
    'global.particles_speed' => ['nullable', 'integer', 'min:1', 'max:10'],
    'global.particles_size' => ['nullable', 'integer', 'min:1', 'max:20'],
    'global.discord_link' => ['nullable', 'url'],
    'global.discord_id' => ['nullable', 'string', 'max:50'],
    'global.server_launcher' => ['nullable', 'boolean'],
    'global.server_launcher_url' => ['nullable', 'url'],
    'global.server_launcher_button_text' => ['nullable', 'string', 'max:120'],
    'global.server_address' => ['nullable', 'string', 'max:120'],

    'advanced' => ['required', 'array'],
    'advanced.advanced_mode' => ['nullable', 'boolean'],
    'advanced.serveurliste_link' => ['nullable', 'url'],
    'advanced.serveurliste_token' => ['nullable', 'string', 'max:255'],

    'modules' => ['required', 'array'],
    'modules.announce_bar.enabled' => ['nullable', 'boolean'],
    'modules.announce_bar.text' => ['nullable', 'string', 'max:1000'],
    'modules.announce_bar.background_color' => ['nullable', new Color()],
    'modules.scroll_progress.enabled' => ['nullable', 'boolean'],
    'modules.scroll_progress.height' => ['nullable', 'integer', 'min:2', 'max:20'],
    'modules.scroll_progress.background_color' => ['nullable', new Color()],
    'modules.scroll_progress.color' => ['nullable', new Color()],

    'variables' => ['nullable', 'array'],
    'variables.custom' => ['nullable', 'array', 'max:150'],
    'variables.custom.*' => ['nullable', 'array'],
    'variables.custom.*.key' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_]+$/'],
    'variables.custom.*.value' => ['nullable', 'string', 'max:5000'],

    'page' => ['nullable', 'array'],
    'page.blocks' => ['nullable', 'array'],
    'page.blocks.*' => ['nullable', 'array'],
    'page.blocks.*.*.id' => ['required', 'string', $blockIdRule],
    'page.blocks.*.*.order' => ['nullable', 'integer', 'min:0'],
    'page.blocks.*.*.params' => ['nullable', 'array', $validateBlockParams],
];
