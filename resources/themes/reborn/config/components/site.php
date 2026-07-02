<?php

return [
    'id' => 'site',
    'label' => 'Header',
    'description' => 'Composants structurels du header global.',
    'blocks' => [
        require __DIR__.'/site/site-header-brand.php',
        require __DIR__.'/site/site-header-menu.php',
        require __DIR__.'/site/site-header-user.php',
        require __DIR__.'/site/site-social-links.php',
    ],
];
