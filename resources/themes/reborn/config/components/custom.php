<?php

return [
    'id' => 'custom',
    'label' => 'Composants personnalisés',
    'description' => 'Sections prêtes à l’emploi inspirées de Nova/Nomad/Kurt/Dungeons/Pomodoro.',
    'blocks' => [
        require __DIR__.'/custom/custom-hero-immersive.php',
        require __DIR__.'/custom/custom-hero-split.php',
        require __DIR__.'/custom/custom-nova-news.php',
        require __DIR__.'/custom/custom-stats-grid.php',
        require __DIR__.'/custom/custom-feature-cards.php',
        require __DIR__.'/custom/custom-cta-ribbon.php',
        require __DIR__.'/custom/custom-trailer-card.php',
        require __DIR__.'/custom/custom-highlight-shop.php',
        require __DIR__.'/custom/custom-nomad-roadmap.php',
        require __DIR__.'/custom/custom-dungeons-classes.php',
        require __DIR__.'/custom/custom-pomodoro-focus.php',
    ],
];
