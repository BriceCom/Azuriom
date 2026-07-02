<?php

return [
    'id' => 'utility',
    'label' => 'Utilitaires',
    'description' => 'Blocs techniques (CSS global/page, HTML/CSS safe, espacement).',
    'blocks' => [
        require __DIR__.'/utility/custom-css.php',
        require __DIR__.'/utility/custom-html-safe.php',
        require __DIR__.'/utility/custom-spacer.php',
    ],
];
