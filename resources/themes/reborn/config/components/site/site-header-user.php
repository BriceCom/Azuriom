<?php

return [
    'type' => 'site-header-user',
    'label' => 'Navigation utilisateur',
    'description' => 'Bloc compte/login/logout (sans theme toggle).',
    'view' => 'components.render.site.reborn-user',
    'placements' => ['header'],
    'scopes' => ['global'],
    'defaults' => [
        'show_avatar' => true,
        'show_role' => true,
    ],
    'fields' => [
        ['key' => 'show_avatar', 'type' => 'switch', 'label' => 'Afficher avatar'],
        ['key' => 'show_role', 'type' => 'switch', 'label' => 'Afficher rôle'],
    ],
];
