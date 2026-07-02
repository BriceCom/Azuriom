<?php

return [
    'nav' => [
        'title' => 'Daily Reward',
        'settings' => 'Settings',
        'days' => 'Cycle days',
        'rewards' => 'Rewards',
        'claims' => 'Claims',
    ],
    'permissions' => [
        'admin' => 'Manage Daily Reward plugin',
        'settings' => 'Update Daily Reward settings',
        'days' => 'Manage cycle days',
        'rewards' => 'Manage rewards',
        'logs' => 'View claim history',
    ],
    'logs' => [
        'settings' => [
            'updated' => 'Updated daily reward settings',
        ],
        'daily-reward-days' => [
            'created' => 'Created daily reward day #:id',
            'updated' => 'Updated daily reward day #:id',
            'deleted' => 'Deleted daily reward day #:id',
        ],
        'daily-reward-rewards' => [
            'created' => 'Created daily reward reward #:id',
            'updated' => 'Updated daily reward reward #:id',
            'deleted' => 'Deleted daily reward reward #:id',
        ],
    ],
    'settings' => [
        'title' => 'Daily Reward Settings',
        'fields' => [
            'enabled' => 'Enable daily reward',
            'reset_mode' => 'Reset mode',
            'cycle_length' => 'Cycle length (days)',
            'default_money' => 'Default reward money',
            'webhook' => 'Discord webhook URL',
            'mail_notifications' => 'Send claim confirmation emails',
            'public_leaderboard' => 'Enable public leaderboard',
            'sync_rewards' => 'Generate default rewards for missing days',
        ],
        'reset_modes' => [
            'midnight' => 'Midnight reset',
            'rolling_24h' => 'Rolling 24h',
        ],
        'webhook_info' => 'Webhook payload follows the same embed approach as the Support plugin.',
        'mail_info' => 'Emails use the global Azuriom mail configuration:',
        'mail_link' => 'open mail settings',
        'mail_disabled' => 'Mail is currently disabled in Azuriom settings.',
        'public_leaderboard_info' => 'When enabled, users can view streak rankings.',
        'public_leaderboard_link' => 'open leaderboard',
        'sync_rewards_info' => 'When enabled, one default money reward is created for days with no rewards.',
    ],
    'days' => [
        'title' => 'Cycle days',
        'create' => 'Create day',
        'edit' => 'Edit day #:day',
        'fields' => [
            'enabled' => 'Enable this day',
        ],
    ],
    'rewards' => [
        'title' => 'Rewards',
        'create' => 'Create reward',
        'edit' => 'Edit reward :reward',
        'types' => [
            'money' => 'Money',
            'command' => 'Command',
        ],
        'fields' => [
            'servers' => 'Servers',
            'commands' => 'Commands',
            'need_online' => 'Require online player for commands',
            'enabled' => 'Enable this reward',
        ],
        'money_info' => 'Used when type is Money. Must be > 0.',
        'servers_info' => 'Required when type is Command.',
        'commands_info' => 'Available placeholders: :placeholders',
        'validation' => [
            'money_required' => 'Money must be greater than 0 for money rewards.',
            'commands_required' => 'At least one command is required for command rewards.',
            'servers_required' => 'At least one server is required for command rewards.',
        ],
    ],
    'claims' => [
        'title' => 'Claim history',
        'search_placeholder' => 'Search by username...',
        'fields' => [
            'rewards' => 'Rewards count',
        ],
    ],
];
