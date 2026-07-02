<?php

return [
    'title' => 'Scratch Game',
    'result_title' => 'Scratch Result',

    'points_label' => 'shop points',
    'your_points' => 'Your points: :points',
    'remaining_points' => 'Remaining points',
    'price_paid' => 'Price paid',

    'cards_count' => 'scratch(s)',
    'linked_rewards' => 'Linked rewards',
    'buy_and_scratch' => 'Buy and scratch',
    'locked_for_role' => 'Locked for your role',
    'no_cards_available' => 'No scratch cards are currently available.',
    'no_reward' => 'No reward',

    'login_required' => 'Log in to buy and scratch tickets.',
    'back_to_cards' => 'Back to cards',
    'scratch_here' => 'Scratch here',
    'scratch_to_reveal' => 'Scratch to reveal your reward',
    'revealing_reward' => 'Revealing your reward...',
    'command_reward_only' => 'Commands were sent on configured server(s).',
    'try_again' => 'Try another scratch card.',
    'play_summary' => 'Play summary',
    'card_label' => 'Card',
    'played_at' => 'Played at',
    'play_again' => 'Play again',

    'pending' => [
        'title' => ':count unfinished scratch ticket(s)',
        'description' => 'You already bought these tickets. Continue scratching to reveal the rewards.',
        'continue' => 'Continue scratching',
        'see_all' => 'View full history',
    ],

    'history' => [
        'title' => 'My scratch history',
        'empty' => 'You have no scratch games yet.',
        'card' => 'Card',
        'reward' => 'Reward',
        'gain' => 'Reward gain',
        'money_gain' => ':name gain',
        'commands_gain' => 'Command(s) gain',
        'commands_modal_title' => 'Commands for scratch #:id',
        'commands_executed' => ':count server command(s)',
        'no_gain' => 'No direct gain',
        'status' => [
            'pending' => 'Pending',
            'claimed' => 'Claimed',
        ],
        'actions' => [
            'continue' => 'Scratch now',
            'view' => 'View result',
        ],
    ],

    'play' => [
        'success' => 'Your ticket has been purchased. Scratch to discover your reward!',
    ],

    'categories' => [
        'public' => 'Public scratch',
    ],

    'errors' => [
        'role_not_allowed' => 'You are not allowed to play this scratch card.',
        'no_enabled_rewards' => 'No enabled reward is linked to this scratch card.',
        'not_enough_points' => 'Not enough :currency. Price: :price :currency.',
        'unknown_error' => 'An unexpected error happened while processing your scratch.',
        'claim_failed' => 'Unable to reveal your reward right now. Please try again.',
        'reward_money_failed' => 'Unable to grant money reward: :error',
        'reward_commands_failed' => 'Unable to execute server commands: :error',
        'reward_commands_no_server' => 'Unable to execute server commands: no server configured for this reward.',
        'need_online_ignored' => 'Need online was ignored on server :server (not AzLink).',
    ],

    'free' => [
        'label' => 'Free ticket',
        'available' => 'Free ticket available now.',
        'cooldown_label' => 'Free in: :cooldown',
        'next' => 'Free ticket in :cooldown.',
        'next_for_card' => 'Next free ticket for :card in :cooldown.',
        'price_label' => 'Free',
        'price_paid_label' => 'Free',
    ],
];
