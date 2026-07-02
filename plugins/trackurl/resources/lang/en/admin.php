<?php

return [
    'plugin' => [
        'name' => 'URL Tracker',
    ],

    'links' => [
        'title' => 'Links',
        'create' => 'Create link',
        'edit' => 'Edit link',
        'created' => 'The link has been created.',
        'updated' => 'The link has been updated.',
        'deleted' => 'The link has been deleted.',
        'stats' => 'Statistics',
        'blocked' => 'The link has been blocked.',
        'unblocked' => 'The link has been unblocked.',
        'status' => [
            'active' => 'Active',
            'blocked' => 'Blocked',
        ],
        'actions' => [
            'block' => 'Block',
            'unblock' => 'Unblock',
        ],
    ],

    'fields' => [
        'name' => 'Name',
        'short_code' => 'Tracking Code',
        'short_code_help' => 'The unique code for the tracked URL. Leave empty to generate a random code.',
        'destination_url' => 'Destination URL',
        'clicks' => 'Clicks',
        'created_at' => 'Created At',
        'user' => 'Created By',
        'urls' => 'Available URLs',
    ],

    'stats' => [
        'title' => 'Link Statistics',
        'back' => 'Back to links',
        'clicks' => 'Total Clicks',
        'daily_clicks' => 'Daily Clicks',
        'recent_clicks' => 'Recent Clicks',
        'session' => 'Session ID',
        'user_agent' => 'User Agent',
        'date' => 'Date',
        'no_clicks' => 'No clicks recorded yet.',
        'today' => 'Today',
        'week' => 'This Week',
        'month' => 'This Month',
        'unique_visitors' => 'Unique Sessions',
        'link_info' => 'Link Information',
        'created_by' => 'Created By',
        'created_at' => 'Created At',
        'status' => 'Status',
    ],

    'logs' => [
        'links' => [
            'created' => 'Created link #:id',
            'updated' => 'Updated link #:id',
            'deleted' => 'Deleted link #:id',
            'blocked' => 'Blocked link #:id',
            'unblocked' => 'Unblocked link #:id',
        ],
    ],

    'custom_theme' => "Custom theme service",
    'support' => "Discord support",
    "serveurliste" => "Top Servers listing",
    "contribute" => "Contribute",
    'advanced_section' => [
        'title' => 'Advanced statistics',
        'description' => 'Link, QR code, link page, real-time analysis, interactive world, link comparison with Lank.li',
        'cta' => 'Learn more about Lank.li',
    ],

    'permissions' => [
        'view' => 'View and manage Trackurl',
    ]
];
