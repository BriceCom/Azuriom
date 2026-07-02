<?php

return [
    'type' => 'custom-css',
    'label' => 'Custom CSS',
    'description' => 'CSS injecté pour le scope courant.',
    'view' => null,
    'placements' => ['body', 'header'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'css' => '',
    ],
    'fields' => [
        ['key' => 'css', 'type' => 'code', 'label' => 'CSS', 'language' => 'css'],
    ],
];
