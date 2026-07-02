<?php

return [
    'errors' => [
        'badApiKey' => 'Public token Tebex erroné',
        'noApiKey' => 'Vous devez entrer un public token Tebex',
        'token_test_failed' => 'Le test du public token a échoué.',
        'nickname' => 'Nom d\'utilisateur incorrect',
        'wrong_settings' => 'Paramètres incorrects !',
        'category_not_found' => 'Catégorie non trouvée',
        'basket_creation_failed' => 'Erreur critique de l\'API Tebex : Impossible de créer le panier.'
    ],

    'permission' => 'Gérer le plugin Tebex',
    'title' => 'Paramètres Tebex',

    'fields' => [
        'shop_title' => 'Titre de la boutique',
        'shop_subtitle' => 'Sous-titre de la boutique',
        'currency' => 'Devise',
        'public_key' => 'Public Token',
        'public_key_info' => 'You can find your Tebex API keys here:',
        'test_public_token' => 'Tester',
        'token_test_success' => 'Le public token est valide.',
        'project_id' => 'ID du projet',
        'private_key' => 'Clé privée',
        'private_key_placeholder' => 'Entrez la nouvelle clé privée ou laissez vide pour conserver l\'actuelle',
        'private_key_security_warning' => 'Pour des raisons de sécurité, laissez vide pour conserver l\'ancienne clé',
        'private_key_info' => 'Entrez votre clé privée Tebex (sera cryptée)',
        'package' => 'Article',
        'banner_text' => 'Texte du bandeau',
        'banner_color' => 'Couleur',
        'banner_position' => 'Position',
        'select_package' => 'Sélectionner un article',
    ],

    'banners' => [
        'title' => 'Bandeaux d\'articles',
        'info' => 'Ajoutez des bandeaux décoratifs sur vos articles (ex: Meilleur choix, Offre limitée).',
        'add' => 'Ajouter un bandeau',
    ],

    'validation' => [
        'public_key_max' => 'Le public token Tebex ne peut pas dépasser 255 caractères.',
        'project_id_max' => 'L\'ID du projet ne peut pas dépasser 255 caractères.',
        'private_key_max' => 'La clé privée ne peut pas dépasser 255 caractères.',
        'title_max' => 'Le titre de la boutique ne peut pas dépasser 255 caractères.',
        'subtitle_max' => 'Le sous-titre de la boutique ne peut pas dépasser 255 caractères.',
    ],

    'support' => "Support Discord",
    "serveurliste" => "Classement top serveurs"
];
