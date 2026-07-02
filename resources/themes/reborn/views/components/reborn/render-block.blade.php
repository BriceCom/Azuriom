@props(['block' => [], 'context' => []])

@php
    static $rebornRegistryMap = null;

    if ($rebornRegistryMap === null) {
        $rebornRegistryMap = [];
        $rebornCategories = require resource_path('themes/reborn/config/components.php');

        foreach ($rebornCategories as $rebornCategory) {
            foreach (($rebornCategory['blocks'] ?? []) as $rebornDefinition) {
                if (is_array($rebornDefinition) && is_string($rebornDefinition['type'] ?? null)) {
                    $rebornRegistryMap[$rebornDefinition['type']] = $rebornDefinition;
                }
            }
        }
    }

    $rebornBlock = is_array($block) ? $block : [];
    $rebornType = is_string($rebornBlock['type'] ?? null) ? $rebornBlock['type'] : '';
    $rebornEnabled = array_key_exists('enabled', $rebornBlock) ? (bool) $rebornBlock['enabled'] : true;
    $rebornDefinition = $rebornRegistryMap[$rebornType] ?? null;
@endphp

@if($rebornEnabled && is_array($rebornDefinition))
    @php
        $rebornDefaults = is_array($rebornDefinition['defaults'] ?? null) ? $rebornDefinition['defaults'] : [];
        $rebornSettings = is_array($rebornBlock['settings'] ?? null)
            ? array_replace_recursive($rebornDefaults, $rebornBlock['settings'])
            : $rebornDefaults;

        $rebornAttributes = is_array($rebornBlock['attributes'] ?? null) ? $rebornBlock['attributes'] : [];
        foreach ($rebornSettings as $rebornKey => $rebornValue) {
            if (is_scalar($rebornValue) || $rebornValue === null) {
                $rebornAttributes['data-'.str_replace('_', '-', (string) $rebornKey)] = (string) ($rebornValue ?? '');
            }
        }

        $rebornLegacyComponent = [
            'type' => $rebornType,
            'attributes' => $rebornAttributes,
            'classes' => is_array($rebornBlock['classes'] ?? null) ? $rebornBlock['classes'] : [],
            'style' => is_array($rebornBlock['style'] ?? null) ? $rebornBlock['style'] : [],
            'components' => is_array($rebornBlock['components'] ?? null) ? $rebornBlock['components'] : [],
            'content' => is_string($rebornBlock['content'] ?? null) ? $rebornBlock['content'] : '',
        ];

        $rebornContext = is_array($context) ? $context : [];
    @endphp

    @if(is_string($rebornDefinition['view'] ?? null) && $rebornDefinition['view'] !== '')
        @include($rebornDefinition['view'], ['component' => $rebornLegacyComponent, 'settings' => $rebornSettings] + $rebornContext)
    @endif
@endif
