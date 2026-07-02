<?php

return [
    'title' => 'Quiz',
    'plugin' => [
        'name' => 'Quiz',
        'description' => 'Un plugin de quiz quotidien pour votre communauté.',
    ],
    'questions' => [
        'title' => 'Questions',
        'create' => 'Créer une question',
        'edit' => 'Modifier la question',
        'status' => 'Statut',
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],
    'fields' => [
        'question' => 'Question',
        'difficulty' => 'Difficulté',
        'reward' => 'Récompense',
        'time_limit' => 'Temps limite (secondes)',
        'activation_date' => 'Date d\'activation',
        'answers' => 'Réponses',
        'is_correct' => 'Est correcte',
        'actions' => 'Actions',
    ],
    'difficulties' => [
        'easy' => 'Facile',
        'medium' => 'Moyen',
        'hard' => 'Difficile',
    ],
    'settings' => [
        'title' => 'Paramètres',
        'delay_hours' => 'Délai entre les quiz (heures)',
        'leaderboard_enabled' => 'Activer le classement',
        'admin_stats_enabled' => 'Autoriser les réponses des admins',
        'difficulty_rewards' => 'Récompenses par difficulté',
        'random_rewards' => 'Récompenses aléatoires',
        'reward_type' => 'Type de récompense',
        'reward_value' => 'Valeur',
        'reward_probability' => 'Probabilité',
        'reward_points' => 'Points',
        'reward_money' => 'Monnaie',
        'reward_item' => 'Objet virtuel',
        'no_random_rewards' => 'Aucune récompense aléatoire configurée.',
    ],
    'messages' => [
        'created' => 'Question créée avec succès.',
        'updated' => 'Question mise à jour avec succès.',
        'deleted' => 'Question supprimée avec succès.',
    ],
    'permissions' => [
        'admin' => 'Gérer le plugin Quiz',
    ],
];
