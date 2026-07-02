<?php

return [
    'type' => 'site-header-menu',
    'label' => 'Menu header',
    'description' => 'Menu principal construit depuis les liens Azuriom.',
    'view' => 'components.render.site.reborn-menu',
    'placements' => ['header'],
    'scopes' => ['global'],
    'defaults' => [
        'style' => 'pills',
        'uppercase' => false,
    ],
    'fields' => [
        [
            'key' => 'style',
            'type' => 'select',
            'label' => 'Style menu',
            'options' => [
                ['value' => 'minimal', 'label' => 'Minimal'],
                ['value' => 'underline', 'label' => 'Underline'],
                ['value' => 'pills', 'label' => 'Pills'],
            ],
        ],
        ['key' => 'uppercase', 'type' => 'switch', 'label' => 'Texte en majuscule'],
    ],
];
