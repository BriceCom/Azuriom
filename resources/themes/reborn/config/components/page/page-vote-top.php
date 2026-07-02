<?php

return [
    'type' => 'page-vote-top',
    'label' => 'Vote top',
    'description' => 'Classement des votes.',
    'view' => 'components.render.page.vote-top',
    'placements' => ['body'],
    'scopes' => ['page'],
    'requires' => ['vote'],
    'defaults' => [],
    'fields' => [],
];
