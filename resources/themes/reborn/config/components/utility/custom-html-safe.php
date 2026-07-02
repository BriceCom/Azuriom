<?php

return [
    'type' => 'custom-html-safe',
    'label' => 'Custom HTML/CSS',
    'description' => 'Bloc libre HTML/CSS (JavaScript bloqué).',
    'view' => 'components.render.custom.html-safe',
    'placements' => ['body'],
    'scopes' => ['global', 'page'],
    'defaults' => [
        'html' => '<div class="p-3 border rounded-3">Mon bloc HTML</div>',
        'css' => '',
    ],
    'fields' => [
        ['key' => 'html', 'type' => 'code', 'label' => 'HTML', 'language' => 'html'],
        ['key' => 'css', 'type' => 'code', 'label' => 'CSS', 'language' => 'css'],
    ],
];
