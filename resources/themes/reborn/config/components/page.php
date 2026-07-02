<?php

return [
    'id' => 'page',
    'label' => 'Composants dynamiques',
    'description' => 'Blocs connectés aux pages Shop/Vote.',
    'blocks' => [
        require __DIR__.'/page/page-vote-card.php',
        require __DIR__.'/page/page-vote-top.php',
        require __DIR__.'/page/page-vote-rewards.php',
        require __DIR__.'/page/page-shop-sidebar.php',
        require __DIR__.'/page/page-shop-home.php',
        require __DIR__.'/page/page-shop-category-description.php',
        require __DIR__.'/page/page-shop-category-packages.php',
    ],
];
