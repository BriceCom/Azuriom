<?php

return [
    'type' => 'custom-pomodoro-focus',
    'label' => 'Pomodoro focus',
    'description' => 'Bloc focus inspiré Pomodoro (sans JS).',
    'view' => 'components.render.custom.pomodoro-focus',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Session Focus',
        'subtitle' => 'Cadence de travail recommandée.',
        'work_minutes' => 25,
        'short_break' => 5,
        'long_break' => 15,
        'cycles' => 4,
        'button_label' => 'Démarrer une session',
        'button_url' => '#',
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'subtitle', 'type' => 'text', 'label' => 'Sous-titre'],
        ['key' => 'work_minutes', 'type' => 'number', 'label' => 'Minutes focus', 'min' => 1, 'max' => 180, 'step' => 1],
        ['key' => 'short_break', 'type' => 'number', 'label' => 'Pause courte', 'min' => 1, 'max' => 60, 'step' => 1],
        ['key' => 'long_break', 'type' => 'number', 'label' => 'Pause longue', 'min' => 1, 'max' => 120, 'step' => 1],
        ['key' => 'cycles', 'type' => 'number', 'label' => 'Nombre de cycles', 'min' => 1, 'max' => 12, 'step' => 1],
        ['key' => 'button_label', 'type' => 'text', 'label' => 'Label bouton'],
        ['key' => 'button_url', 'type' => 'url', 'label' => 'URL bouton'],
    ],
];
