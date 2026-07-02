<?php

return [
    'type' => 'page-vote-rewards',
    'label' => 'Vote rewards',
    'description' => 'Tableau des récompenses vote.',
    'view' => 'components.render.page.vote-rewards',
    'placements' => ['body'],
    'scopes' => ['page'],
    'requires' => ['vote'],
    'defaults' => [],
    'fields' => [],
];
