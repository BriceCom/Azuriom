<?php

return [
    'title' => 'URL Tracker',
    'description' => 'Create and track URLs.',
    'copy' => 'Copy',
    'copied' => 'Copied!',
    'url_format' => 'URL Format',
    'copy_standard' => 'Copy Standard URL',
    'copy_pretty' => 'Copy Pretty URL',
    'standard_url' => 'Standard URL',
    'pretty_url' => 'Pretty URL (/?ref=code)',
    'your_link' => 'Your tracked link:',
    'original_link' => 'Original link:',
    'no_links' => 'No links yet.',
    'create' => 'Create a tracked URL',
    'back' => 'Back to links',

    'fields' => [
        'name' => 'Name',
        'name_help' => 'A name to help you identify this link',
        'destination_url' => 'Destination URL',
        'destination_url_help' => 'The URL you want to track',
        'short_code' => 'Custom code (optional)',
        'short_code_help' => 'Leave empty to generate a random code',
    ],

    'rate_limit' => [
        'title' => 'Rate Limit Exceeded',
        'message' => 'You have exceeded the maximum number of clicks allowed. Please try again in :minutes minutes.',
        'explanation' => 'To prevent spam and abuse, we limit the number of times you can use our tracking service in a short period of time.',
    ],

    'blocked' => [
        'title' => 'Link Blocked',
        'message' => 'This link has been blocked due to suspicious or harmful content.',
        'explanation' => 'For your safety, we have blocked access to this link. If you believe this is an error, please contact the site administrator.',
    ],

    'errors' => [
        'blacklisted_url' => 'The destination URL contains blacklisted content or is potentially harmful.',
        'spam_detected' => 'This link has been flagged as potential spam.',
    ],
];
