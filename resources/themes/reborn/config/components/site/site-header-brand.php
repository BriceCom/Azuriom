<?php

return [
    'type' => 'site-header-brand',
    'label' => 'Brand header',
    'description' => 'Logo, nom du site et baseline.',
    'view' => 'components.render.site.reborn-brand',
    'placements' => ['header'],
    'scopes' => ['global'],
    'defaults' => [
        'show_logo' => true,
        'show_name' => true,
        'tagline' => '',
    ],
    'fields' => [
        ['key' => 'show_logo', 'type' => 'switch', 'label' => 'Afficher le logo'],
        ['key' => 'show_name', 'type' => 'switch', 'label' => 'Afficher le nom du site'],
        ['key' => 'tagline', 'type' => 'text', 'label' => 'Baseline', 'placeholder' => 'Serveur RP fantasy FR'],
    ],
];
