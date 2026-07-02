<?php

return [
    'title' => 'Quiz',
    'plugin' => [
        'name' => 'Quiz',
        'description' => 'A daily quiz plugin for your community.',
    ],
    'questions' => [
        'title' => 'Questions',
        'create' => 'Create Question',
        'edit' => 'Edit Question',
        'status' => 'Status',
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],
    'fields' => [
        'question' => 'Question',
        'difficulty' => 'Difficulty',
        'reward' => 'Reward',
        'time_limit' => 'Time Limit (seconds)',
        'activation_date' => 'Activation Date',
        'answers' => 'Answers',
        'is_correct' => 'Is Correct',
        'actions' => 'Actions',
    ],
    'difficulties' => [
        'easy' => 'Easy',
        'medium' => 'Medium',
        'hard' => 'Hard',
    ],
    'settings' => [
        'title' => 'Settings',
        'delay_hours' => 'Delay between quizzes (hours)',
        'leaderboard_enabled' => 'Enable Leaderboard',
        'admin_stats_enabled' => 'Allow Admin Responses',
        'difficulty_rewards' => 'Difficulty Rewards',
        'random_rewards' => 'Random Rewards',
        'reward_type' => 'Reward Type',
        'reward_value' => 'Reward Value',
        'reward_probability' => 'Probability',
        'reward_points' => 'Points',
        'reward_money' => 'Money',
        'reward_item' => 'Virtual Item',
        'no_random_rewards' => 'No random rewards configured.',
    ],
    'messages' => [
        'created' => 'Question created successfully.',
        'updated' => 'Question updated successfully.',
        'deleted' => 'Question deleted successfully.',
    ],
    'permissions' => [
        'admin' => 'Manage the Quiz plugin',
    ],
];
