<?php

return [
    'type' => 'page-shop-home',
    'label' => 'Shop home welcome',
    'description' => 'Message d’accueil shop.home.',
    'view' => 'components.render.page.shop-home',
    'placements' => ['body'],
    'scopes' => ['page'],
    'requires' => ['shop'],
    'defaults' => [],
    'fields' => [],
];
