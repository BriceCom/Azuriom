<?php

return [
    'type' => 'custom-highlight-shop',
    'label' => 'Shop highlight',
    'description' => 'Mise en avant d’un article Shop.',
    'view' => 'components.render.custom.highlight-shop',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Article mis en avant',
        'button_label' => 'Voir la boutique',
        'package_id' => 0,
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'button_label', 'type' => 'text', 'label' => 'Label bouton'],
        ['key' => 'package_id', 'type' => 'number', 'label' => 'ID package Shop', 'min' => 0, 'step' => 1],
    ],
];
