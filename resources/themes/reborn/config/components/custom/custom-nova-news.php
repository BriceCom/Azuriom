<?php

return [
    'type' => 'custom-nova-news',
    'label' => 'News feed',
    'description' => 'Bloc actualités inspiré Nova.',
    'view' => 'components.render.custom.nova-news',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Dernières actualités',
        'subtitle' => 'Posts publiés récemment',
        'count' => 3,
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'subtitle', 'type' => 'text', 'label' => 'Sous-titre'],
        ['key' => 'count', 'type' => 'number', 'label' => 'Nombre d’articles', 'min' => 1, 'max' => 12, 'step' => 1],
    ],
];
