<?php

return [
    'errors' => [
        'badApiKey' => 'Wrong Tebex public token',
        'noApiKey' => 'You must enter a Tebex public token',
        'token_test_failed' => 'Public token test failed.',
        'nickname' => 'Incorrect username',
        'wrong_settings' => 'Wrong settings!',
        'category_not_found' => 'Category not found',
        'basket_creation_failed' => 'Critical Tebex API error: Unable to create basket.'
    ],

    'permission' => 'Manage Tebex Plugin',
    'title' => 'Tebex Settings',

    'fields' => [
        'shop_title' => 'Shop Title',
        'shop_subtitle' => 'Shop Subtitle',
        'currency' => 'Currency',
        'public_key' => 'Public Token',
        'public_key_info' => 'You can find your Tebex API keys here:',
        'test_public_token' => 'Test',
        'token_test_success' => 'Public token is valid.',
        'project_id' => 'Project ID',
        'private_key' => 'Private Key',
        'private_key_placeholder' => 'Enter new private key or leave empty to keep current',
        'private_key_security_warning' => 'For security reasons, leave empty to keep the old key',
        'private_key_info' => 'Enter your Tebex private key (will be encrypted)',
        'package' => 'Package',
        'banner_text' => 'Banner Text',
        'banner_color' => 'Color',
        'banner_position' => 'Position',
        'select_package' => 'Select a package',
    ],

    'banners' => [
        'title' => 'Package Banners',
        'info' => 'Add decorative banners to your packages (e.g., Best Choice, Limited Offer).',
        'add' => 'Add a banner',
    ],

    'validation' => [
        'public_key_max' => 'The Tebex public token may not be greater than 255 characters.',
        'project_id_max' => 'The project ID may not be greater than 255 characters.',
        'private_key_max' => 'The private key may not be greater than 255 characters.',
        'title_max' => 'The shop title may not be greater than 255 characters.',
        'subtitle_max' => 'The shop subtitle may not be greater than 255 characters.',
    ],

    'support' => "Discord support",
    "serveurliste" => "Top Servers listing"
];
