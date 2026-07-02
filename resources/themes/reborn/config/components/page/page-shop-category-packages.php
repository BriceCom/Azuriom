<?php

return [
    'type' => 'page-shop-category-packages',
    'label' => 'Shop category packages',
    'description' => 'Grille des packages d’une catégorie shop.',
    'view' => 'components.render.page.shop-category-packages',
    'placements' => ['body'],
    'scopes' => ['page'],
    'requires' => ['shop'],
    'defaults' => [],
    'fields' => [],
];
