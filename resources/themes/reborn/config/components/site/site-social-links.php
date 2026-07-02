<?php

return [
    'type' => 'site-social-links',
    'label' => 'Liens sociaux',
    'description' => 'Affiche les liens sociaux configurés dans Azuriom.',
    'view' => 'components.render.site.social-links',
    'placements' => ['header', 'body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => '',
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre (optionnel)'],
    ],
];
