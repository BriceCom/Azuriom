<?php

return [
    'type' => 'page-shop-sidebar',
    'label' => 'Shop sidebar',
    'description' => 'Sidebar catégories Shop.',
    'view' => 'components.render.page.shop-sidebar',
    'placements' => ['body'],
    'scopes' => ['page'],
    'requires' => ['shop'],
    'defaults' => [],
    'fields' => [],
];
