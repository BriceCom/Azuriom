<?php

return [
    'type' => 'custom-cta-ribbon',
    'label' => 'CTA ribbon',
    'description' => 'Bannière call-to-action large.',
    'view' => 'components.render.custom.cta-ribbon',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'icon' => 'bi bi-megaphone-fill',
        'title' => 'Annonce importante',
        'text' => 'Activez ce bloc pour promouvoir une nouveauté.',
        'button_label' => 'En savoir plus',
        'button_url' => '#',
    ],
    'fields' => [
        ['key' => 'icon', 'type' => 'text', 'label' => 'Icône'],
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'text', 'type' => 'textarea', 'label' => 'Texte'],
        ['key' => 'button_label', 'type' => 'text', 'label' => 'Label bouton'],
        ['key' => 'button_url', 'type' => 'url', 'label' => 'URL bouton'],
    ],
];
