<?php

return [
    'type' => 'custom-spacer',
    'label' => 'Spacer',
    'description' => 'Crée un espace vertical entre sections.',
    'view' => 'components.render.custom.spacer',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'height' => 48,
        'height_mobile' => 24,
    ],
    'fields' => [
        ['key' => 'height', 'type' => 'number', 'label' => 'Hauteur desktop (px)', 'min' => 0, 'max' => 400, 'step' => 1],
        ['key' => 'height_mobile', 'type' => 'number', 'label' => 'Hauteur mobile (px)', 'min' => 0, 'max' => 400, 'step' => 1],
    ],
];
