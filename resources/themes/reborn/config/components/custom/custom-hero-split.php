<?php

return [
    'type' => 'custom-hero-split',
    'label' => 'Hero split',
    'description' => 'Section hero avec texte + visuel.',
    'view' => 'components.render.custom.hero-split',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'badge' => 'Nouveau',
        'title' => 'Titre hero',
        'subtitle' => 'Sous-titre hero',
        'primary_label' => 'Commencer',
        'primary_url' => '#',
        'secondary_label' => 'Découvrir',
        'secondary_url' => '#',
        'image_url' => '',
    ],
    'fields' => [
        ['key' => 'badge', 'type' => 'text', 'label' => 'Badge'],
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'subtitle', 'type' => 'textarea', 'label' => 'Sous-titre'],
        ['key' => 'primary_label', 'type' => 'text', 'label' => 'Label bouton principal'],
        ['key' => 'primary_url', 'type' => 'url', 'label' => 'URL bouton principal'],
        ['key' => 'secondary_label', 'type' => 'text', 'label' => 'Label bouton secondaire'],
        ['key' => 'secondary_url', 'type' => 'url', 'label' => 'URL bouton secondaire'],
        ['key' => 'image_url', 'type' => 'url', 'label' => 'URL image'],
    ],
];
