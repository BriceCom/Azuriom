<?php

return [
    'type' => 'custom-stats-grid',
    'label' => 'Stats grid',
    'description' => 'Grille statistiques prête à l’emploi.',
    'view' => 'components.render.custom.stats-grid',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Statistiques du serveur',
        'stat_1_value' => '1 245',
        'stat_1_label' => 'Joueurs',
        'stat_1_icon' => 'bi bi-people-fill',
        'stat_2_value' => '87',
        'stat_2_label' => 'Guildes',
        'stat_2_icon' => 'bi bi-shield-fill',
        'stat_3_value' => '42',
        'stat_3_label' => 'Événements',
        'stat_3_icon' => 'bi bi-lightning-fill',
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'stat_1_value', 'type' => 'text', 'label' => 'Stat 1 valeur'],
        ['key' => 'stat_1_label', 'type' => 'text', 'label' => 'Stat 1 label'],
        ['key' => 'stat_1_icon', 'type' => 'text', 'label' => 'Stat 1 icône'],
        ['key' => 'stat_2_value', 'type' => 'text', 'label' => 'Stat 2 valeur'],
        ['key' => 'stat_2_label', 'type' => 'text', 'label' => 'Stat 2 label'],
        ['key' => 'stat_2_icon', 'type' => 'text', 'label' => 'Stat 2 icône'],
        ['key' => 'stat_3_value', 'type' => 'text', 'label' => 'Stat 3 valeur'],
        ['key' => 'stat_3_label', 'type' => 'text', 'label' => 'Stat 3 label'],
        ['key' => 'stat_3_icon', 'type' => 'text', 'label' => 'Stat 3 icône'],
    ],
];
