<?php

return [
    'type' => 'custom-dungeons-classes',
    'label' => 'Dungeons classes',
    'description' => 'Grille de classes inspirée Dungeons.',
    'view' => 'components.render.custom.dungeons-classes',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Choisissez votre classe',
        'subtitle' => 'Chaque classe apporte son style de combat.',
        'items' => [
            ['icon' => 'bi bi-shield-fill', 'name' => 'Guardian', 'role' => 'Tank', 'text' => 'Absorbe les dégâts et protège le groupe.'],
            ['icon' => 'bi bi-lightning-fill', 'name' => 'Arcanist', 'role' => 'DPS', 'text' => 'Burst magique à longue portée.'],
            ['icon' => 'bi bi-heart-pulse-fill', 'name' => 'Warden', 'role' => 'Support', 'text' => 'Soins, buffs et contrôle de zone.'],
        ],
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'subtitle', 'type' => 'text', 'label' => 'Sous-titre'],
        [
            'key' => 'items',
            'type' => 'collection',
            'label' => 'Classes',
            'min' => 1,
            'max' => 8,
            'fields' => [
                ['key' => 'icon', 'type' => 'text', 'label' => 'Icône'],
                ['key' => 'name', 'type' => 'text', 'label' => 'Nom'],
                ['key' => 'role', 'type' => 'text', 'label' => 'Rôle'],
                ['key' => 'text', 'type' => 'textarea', 'label' => 'Description'],
            ],
        ],
    ],
];
