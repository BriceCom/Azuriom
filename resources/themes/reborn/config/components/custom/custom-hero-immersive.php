<?php

return [
    'type' => 'custom-hero-immersive',
    'label' => 'Hero immersive',
    'description' => 'Hero plein écran inspiré Nova/Kurt.',
    'view' => 'components.render.custom.hero-immersive',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'badge' => 'Nouveau chapitre',
        'title' => 'Welcome to Reborn',
        'subtitle' => 'Un layout premium prêt à customiser bloc par bloc.',
        'background_url' => '',
        'primary_label' => 'Commencer',
        'primary_url' => '#',
        'secondary_label' => 'Voir les nouveautés',
        'secondary_url' => '#',
    ],
    'fields' => [
        ['key' => 'badge', 'type' => 'text', 'label' => 'Badge'],
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'subtitle', 'type' => 'textarea', 'label' => 'Sous-titre'],
        ['key' => 'background_url', 'type' => 'url', 'label' => 'URL image de fond'],
        ['key' => 'primary_label', 'type' => 'text', 'label' => 'Label bouton principal'],
        ['key' => 'primary_url', 'type' => 'url', 'label' => 'URL bouton principal'],
        ['key' => 'secondary_label', 'type' => 'text', 'label' => 'Label bouton secondaire'],
        ['key' => 'secondary_url', 'type' => 'url', 'label' => 'URL bouton secondaire'],
    ],
];
