<?php

return [
    'title' => 'Daily Reward',
    'disabled' => 'The daily reward feature is currently disabled.',
    'login_required' => 'Log in to claim your daily reward.',

    'actions' => [
        'claim' => 'Claim reward',
        'leaderboard' => 'View leaderboard',
    ],

    'fields' => [
        'streak' => 'Current streak',
        'max_streak' => 'Best streak',
        'next_day' => 'Next day',
        'next_claim' => 'Next claim',
        'day' => 'Day',
        'label' => 'Label',
        'rewards' => 'Rewards',
    ],

    'cycle' => [
        'title' => 'Reward cycle',
        'empty' => 'No day has been configured yet.',
    ],

    'day_label' => 'Day :day',
    'default_reward_name' => 'Default reward day :day',

    'reward' => [
        'money' => ':money credits',
        'commands_count' => ':count command(s)',
    ],

    'states' => [
        'claimed' => 'Claimed',
        'available' => 'Available',
        'cooldown' => 'Cooldown',
        'locked' => 'Locked',
    ],

    'leaderboard' => [
        'title' => 'Daily Reward Leaderboard',
        'current' => 'Current streak ranking',
        'best' => 'Best streak ranking',
    ],

    'claim' => [
        'disabled' => 'Daily reward is disabled.',
        'cooldown' => 'You already claimed your reward. Please wait before trying again.',
        'day_disabled' => 'This reward day is currently disabled.',
        'success' => 'Reward claimed.',
        'success_feedback' => 'Reward claimed for day :day. Streak: :streak. Money: :money. Commands: :commands.',
        'dispatch_money_failed' => 'Money reward ":reward" failed: :error',
        'dispatch_commands_failed' => 'Command reward ":reward" failed: :error',
    ],

    'webhook' => [
        'claimed' => 'Daily reward claimed',
        'fields' => [
            'player' => 'Player',
            'day' => 'Day',
            'streak' => 'Streak',
            'money' => 'Money',
            'commands' => 'Commands',
        ],
    ],

    'mails' => [
        'claim' => [
            'subject' => 'Daily reward claimed on :name',
            'line' => 'You claimed day :day. Current streak: :streak. Money: :money. Commands: :commands.',
            'action' => 'View daily reward',
        ],
    ],
];
