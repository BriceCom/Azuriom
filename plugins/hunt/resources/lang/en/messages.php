<?php

return [
    'title' => 'Hunt',
    'description' => 'Find and collect hunt items that randomly appear on the site to earn rewards!',

    'current' => 'Current',
    'current_hunt' => 'Current Hunt',
    'active' => 'Active',
    'scheduled' => 'Scheduled',
    'ended' => 'Ended',
    'archived' => 'Archived',

    'all_hunts' => 'All Hunts',
    'no_hunts' => 'No Hunts Available',
    'no_hunts_description' => 'There are currently no hunts available. Check back later!',
    'no_active_hunt' => 'No active hunt at the moment. Check back later for new hunts!',
    'view_details' => 'View Details',
    'view_leaderboard' => 'View Leaderboard',
    'back_to_hunts' => 'Back to Hunts',

    'hunt_details' => 'Hunt: :hunt',
    'starts' => 'Starts',
    'ends' => 'Ends',
    'total_claims' => 'Total claims',
    'amount_total_claims' => ':amount total claims',
    'total_players' => 'Total Players',
    'total_money_given' => 'Total Money Given',
    'max_per_day' => 'Max Per Day',
    'rewards' => 'Rewards',

    'global_progress' => ':current / :total claims',
    'your_progress_today' => 'Your progress: :current / :total',
    'cap_reached' => 'Cap Reached',
    'global_cap_reached' => 'This hunt has reached its maximum number of rewards.',

    'leaderboard' => 'Leaderboard',
    'rank' => 'Rank',
    'player' => 'Player',
    'money_earned' => 'Money Earned',
    'last_claim' => 'Last Claim',
    'you' => 'You',
    'no_claims_yet' => 'No Claims Yet',
    'be_the_first' => 'Be the first to claim this hunt!',

    'your_position' => 'Your position: #:position',
    'claims_today' => 'Claims Today',
    'earned_today' => 'Earned Today',
    'money_earned_today' => 'Money earned today: :amount',
    'daily_progress' => 'Daily Progress',
    'daily_progress_summary' => 'You have hunted :current times out of :total today',
    'overall_stats' => 'Overall Stats',
    'total_earned' => 'Total earned',
    'money_total_earned' => ':money :moneyName total earned',
    'your_rank' => 'Your Rank',
    'no_progress_yet' => 'You haven\'t participated in this hunt yet.',
    'ready_to_hunt' => 'Ready to hunt! Look for items appearing on the site.',
    'daily_limit_reached' => 'You have reached your daily limit for this hunt.',
    'cooldown_remaining' => 'Cooldown remaining',
    'minutes' => 'minutes',

    'login_to_participate' => 'Login to Participate',
    'login_description' => 'You need to be logged in to participate in hunts and earn rewards.',
    'login' => 'Login',
    'not_authenticated' => 'You must be logged in to claim hunt rewards.',

    'available_rewards' => 'Available Rewards',

    'hunt_not_active' => 'This hunt is not currently active.',
    'spawn_failed' => 'Better luck next time! No reward was given.',
    'cooldown_active' => 'You need to wait before claiming another hunt item.',
    'unknown_error' => 'An unexpected error occurred. Please try again.',

    'congratulations' => 'Congratulations!',
    'reward_received' => 'You received: :reward',
    'money_earned_amount' => 'Money earned: :amount',
    'commands_executed' => 'Commands executed: :count',
    'no_reward_this_time' => 'No reward was given this time, but keep hunting!',
    'better_luck_next_time' => 'Better Luck Next Time!',
    'hunt_didnt_reward' => 'The hunt didn\'t reward anything this time, but keep trying!',
    'next_attempt_available' => 'Next attempt available in: :minutes minutes',
    'connection_error' => 'Connection Error',
    'failed_to_process' => 'Failed to process hunt claim. Please try again later.',
    'warnings' => 'Warnings',
    'error' => 'Error',
    'hunt_error' => 'Hunt Error',
    'time_remaining' => 'Time remaining',

    'unfortunately_not_logged_in' => 'Unfortunately, you were not logged in. The hunt reward cannot be attributed to you. Maybe next time!',

    'hunt_cap_reached' => 'The hunt has given out all possible rewards!',
    'total_rewards_given' => 'Total rewards given: :total',

    'just_now' => 'Just now',
    'seconds_ago' => ':count seconds ago',
    'minutes_ago' => ':count minutes ago',
    'hours_ago' => ':count hours ago',
    'days_ago' => ':count days ago',

    'close' => 'Close',
    'hunt_result' => 'Hunt Result',
    'view_leaderboard_btn' => 'View Leaderboard',
    'try_again' => 'Try Again',
    'daily_limit_message' => 'You have reached your daily limit for this hunt.',

    'hunt_mechanics' => [
        'title' => 'How Hunts Work',
        'description' => 'Hunt items appear randomly across the site. When you see one, click it quickly to claim your reward!',
        'tips' => [
            'Hunt items appear for a limited time before disappearing.',
            'You can only claim a certain number of rewards per day.',
            'Different hunts have different spawn rates and rewards.',
            'Make sure you\'re logged in to receive rewards.',
            'Hunt items won\'t appear on admin pages or during login/registration.',
        ],
    ],

    'errors' => [
        'hunt_not_found' => 'Hunt not found.',
        'reward_not_found' => 'Reward not found.',
        'invalid_request' => 'Invalid request.',
        'server_error' => 'Server error occurred.',
        'rate_limited' => 'Too many requests. Please slow down.',
        'reward_money_failed' => 'Failed to add money reward: :error',
        'reward_commands_failed' => 'Failed to execute server commands: :error',
    ],

    'success' => [
        'reward_claimed' => 'Reward claimed successfully!',
        'progress_updated' => 'Your progress has been updated.',
    ],

    'placeholders' => [
        'no_description' => 'No description available.',
        'no_image' => 'No image',
        'loading' => 'Loading...',
        'coming_soon' => 'Coming Soon',
    ],

    'accessibility' => [
        'hunt_item_alt' => 'Hunt item: :name',
        'user_avatar_alt' => 'Avatar of :name',
        'reward_image_alt' => 'Reward: :name',
        'hunt_image_alt' => 'Hunt: :name',
        'progress_bar' => 'Progress: :current out of :total',
        'leaderboard_position' => 'Position :rank in leaderboard',
    ],

    'meta' => [
        'page_title' => 'Hunt - :hunt',
        'page_description' => 'Participate in :hunt and earn rewards by finding hunt items across the site.',
        'leaderboard_title' => ':hunt Leaderboard',
        'leaderboard_description' => 'See who\'s leading in the :hunt and compete for the top spots!',
    ],
];
