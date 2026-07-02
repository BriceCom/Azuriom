<?php

return [
    'type' => 'custom-trailer-card',
    'label' => 'Trailer card',
    'description' => 'Carte média avec visuel + CTA vidéo.',
    'view' => 'components.render.custom.trailer-card',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Trailer du serveur',
        'text' => 'Présentez votre univers en vidéo.',
        'video_url' => '#',
        'poster_url' => '',
        'button_label' => 'Voir la vidéo',
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'text', 'type' => 'textarea', 'label' => 'Texte'],
        ['key' => 'video_url', 'type' => 'url', 'label' => 'URL vidéo'],
        ['key' => 'poster_url', 'type' => 'url', 'label' => 'URL image'],
        ['key' => 'button_label', 'type' => 'text', 'label' => 'Label bouton'],
    ],
];
