<?php

return [
    'type' => 'custom-nomad-roadmap',
    'label' => 'Nomad roadmap',
    'description' => 'Timeline roadmap avec gestion du nombre d’items.',
    'view' => 'components.render.custom.nomad-roadmap',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'title' => 'Roadmap',
        'subtitle' => 'Vision produit sur les prochains mois.',
        'items' => [
            ['phase' => 'T1', 'title' => 'Refonte UI', 'status' => 'done', 'text' => 'Nouveau thème et panneau de configuration.'],
            ['phase' => 'T2', 'title' => 'Événements live', 'status' => 'progress', 'text' => 'Système d’événements hebdomadaires.'],
            ['phase' => 'T3', 'title' => 'Quêtes avancées', 'status' => 'planned', 'text' => 'Nouvelles quêtes coopératives.'],
        ],
    ],
    'fields' => [
        ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
        ['key' => 'subtitle', 'type' => 'text', 'label' => 'Sous-titre'],
        [
            'key' => 'items',
            'type' => 'collection',
            'label' => 'Étapes',
            'min' => 1,
            'max' => 10,
            'fields' => [
                ['key' => 'phase', 'type' => 'text', 'label' => 'Phase'],
                ['key' => 'title', 'type' => 'text', 'label' => 'Titre'],
                [
                    'key' => 'status',
                    'type' => 'select',
                    'label' => 'Statut',
                    'options' => [
                        ['value' => 'done', 'label' => 'Done'],
                        ['value' => 'progress', 'label' => 'In progress'],
                        ['value' => 'planned', 'label' => 'Planned'],
                    ],
                ],
                ['key' => 'text', 'type' => 'textarea', 'label' => 'Description'],
            ],
        ],
    ],
];
