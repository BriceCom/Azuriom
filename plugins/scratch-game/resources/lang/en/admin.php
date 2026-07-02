<?php

return [
    'nav' => [
        'title' => 'Scratch Game',
        'cards' => 'Scratch Cards',
        'rewards' => 'Rewards',
        'logs' => 'Logs',
        'settings' => 'Settings',
    ],

    'permission' => 'Manage scratch game plugin',

    'cards' => [
        'title' => 'Scratch Cards',
        'create' => 'Create Card',
        'edit' => 'Edit Card :card',
        'no_cards' => 'No scratch cards found.',
        'search_placeholder' => 'Search a card...',
        'confirm_delete' => 'Are you sure you want to delete this card?',

        'fields' => [
            'name' => 'Name',
            'price' => 'Price',
            'images' => 'Card Images',
            'cover_image' => 'Ticket Cover Image',
            'background_image' => 'Background Image After Scratch',
            'free_interval_minutes' => 'Free ticket interval',
            'free_interval_unit' => 'minutes',
            'free_interval_help' => 'Leave empty to disable the free interval.',
            'relations' => 'Relations',
            'rewards' => 'Linked Rewards',
            'roles' => 'Required Roles',
            'roles_info' => 'Leave empty for public access.',
            'public_access' => 'Public',
            'is_enabled' => 'Enabled',
        ],

        'status' => [
            'created' => 'Scratch card created successfully.',
            'updated' => 'Scratch card updated successfully.',
            'deleted' => 'Scratch card deleted successfully.',
            'enabled' => 'Scratch card enabled successfully.',
            'disabled' => 'Scratch card disabled successfully.',
        ],
    ],

    'rewards' => [
        'title' => 'Scratch Rewards',
        'create' => 'Create Reward',
        'edit' => 'Edit Reward :reward',
        'no_rewards' => 'No rewards found.',
        'search_placeholder' => 'Search a reward...',
        'confirm_delete' => 'Are you sure you want to delete this reward?',
        'not_used_yet' => 'This reward is not linked to any card yet.',

        'fields' => [
            'name' => 'Name',
            'chance' => 'Chance %',
            'money' => 'Money to give',
            'image' => 'Reward image',
            'commands_section' => 'Commands',
            'commands' => 'Commands',
            'command_name' => 'Command name',
            'command_line' => 'Command line',
            'commands_info' => 'You can use {player}, {reward}, {scratch}, {steam_id} and {steam_id_32}.',
            'add_command' => 'Add command',
            'servers' => 'Server(s)',
            'need_online' => 'Execute commands when the user is online on the server (only available with AzLink)',
            'need_online_info' => 'Execute commands when the user is online on the server (only available with AzLink)',
            'is_enabled' => 'Enabled',
            'used_in_cards' => 'Used in scratch',
        ],

        'validation' => [
            'reward_required' => 'You must configure at least one reward type (money or commands).',
            'servers_required_for_commands' => 'At least one server is required when commands are configured.',
            'servers_required_for_need_online' => 'At least one server is required when online-only mode is enabled.',
            'need_online_only_azlink' => 'Online-only execution works only with AzLink servers.',
        ],

        'status' => [
            'created' => 'Reward created successfully.',
            'updated' => 'Reward updated successfully.',
            'deleted' => 'Reward deleted successfully.',
            'enabled' => 'Reward enabled successfully.',
            'disabled' => 'Reward disabled successfully.',
        ],
    ],

    'logs' => [
        'title' => 'Scratch Logs',
        'user' => 'User',
        'card' => 'Card',
        'reward' => 'Reward',
        'price_paid' => 'Price paid',
        'money_given' => 'Money given',
        'commands_given' => 'Commands give',
        'commands_modal_title' => 'Commands for log #:id',
        'played_at' => 'Played at',
        'no_logs' => 'No logs found.',
        'search_placeholder' => 'Search by user, card or reward...',
        'filter_card' => 'Filter by card',
        'filter_user' => 'Filter by user',
        'all_cards' => 'All cards',
        'all_users' => 'All users',
    ],

    'settings' => [
        'title' => 'Scratch Settings',
        'page' => [
            'title' => 'Page',
            'page_title' => 'Page title',
            'page_title_help' => 'Leave empty to keep the default title.',
        ],
        'cards' => [
            'title' => 'Scratch Card Size',
            'min_width' => 'Minimum card width',
            'min_height' => 'Minimum card height',
            'help' => 'Controls the scratch area size on the result page.',
        ],
        'status' => [
            'updated' => 'Settings updated successfully.',
        ],
    ],

    'buttons' => [
        'create' => 'Create',
        'save' => 'Save',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'back' => 'Back',
        'filter' => 'Filter',
        'reset' => 'Reset',
    ],

    'common' => [
        'general' => 'General',
        'name' => 'Name',
        'search' => 'Search',
        'status' => 'Status',
        'actions' => 'Actions',
        'all' => 'All',
        'enabled' => 'Enabled',
        'disabled' => 'Disabled',
        'enable' => 'Enable',
        'disable' => 'Disable',
        'enable_feature' => 'Enable this feature',
        'hold_ctrl_multiple' => 'Hold Ctrl to select multiple',
        'max_image_size' => 'Maximum file size: :size',
    ],
];
