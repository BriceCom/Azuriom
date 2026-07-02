<?php

return [
    'type' => 'page-vote-card',
    'label' => 'Vote card',
    'description' => 'Bloc principal de vote (page vote.home).',
    'view' => 'components.render.page.vote-card',
    'placements' => ['body'],
    'scopes' => ['page'],
    'requires' => ['vote'],
    'defaults' => [],
    'fields' => [],
];
