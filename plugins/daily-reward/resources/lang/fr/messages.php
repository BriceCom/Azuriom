<?php

return [
    'title' => 'Daily Reward',
    'disabled' => 'Le système de récompense quotidienne est actuellement désactivé.',
    'login_required' => 'Connectez-vous pour réclamer votre récompense quotidienne.',

    'actions' => [
        'claim' => 'Réclamer la récompense',
        'leaderboard' => 'Voir le leaderboard',
    ],

    'fields' => [
        'streak' => 'Streak actuel',
        'max_streak' => 'Meilleur streak',
        'next_day' => 'Prochain jour',
        'next_claim' => 'Prochaine claim',
        'day' => 'Jour',
        'label' => 'Label',
        'rewards' => 'Récompenses',
    ],

    'cycle' => [
        'title' => 'Cycle de récompenses',
        'empty' => 'Aucun jour n’a encore été configuré.',
    ],

    'day_label' => 'Jour :day',
    'default_reward_name' => 'Récompense par défaut jour :day',

    'reward' => [
        'money' => ':money crédits',
        'commands_count' => ':count commande(s)',
    ],

    'states' => [
        'claimed' => 'Réclamé',
        'available' => 'Disponible',
        'cooldown' => 'Cooldown',
        'locked' => 'Verrouillé',
    ],

    'leaderboard' => [
        'title' => 'Classement Daily Reward',
        'current' => 'Classement streak actuel',
        'best' => 'Classement meilleur streak',
    ],

    'claim' => [
        'disabled' => 'Le daily reward est désactivé.',
        'cooldown' => 'Vous avez déjà claim. Merci d’attendre avant de recommencer.',
        'day_disabled' => 'Ce jour de récompense est désactivé.',
        'success' => 'Récompense réclamée.',
        'success_feedback' => 'Récompense réclamée pour le jour :day. Streak : :streak. Monnaie : :money. Commandes : :commands.',
        'dispatch_money_failed' => 'Échec récompense monnaie ":reward" : :error',
        'dispatch_commands_failed' => 'Échec récompense commande ":reward" : :error',
    ],

    'webhook' => [
        'claimed' => 'Daily reward réclamé',
        'fields' => [
            'player' => 'Joueur',
            'day' => 'Jour',
            'streak' => 'Streak',
            'money' => 'Monnaie',
            'commands' => 'Commandes',
        ],
    ],

    'mails' => [
        'claim' => [
            'subject' => 'Daily reward réclamé sur :name',
            'line' => 'Vous avez réclamé le jour :day. Streak actuel : :streak. Monnaie : :money. Commandes : :commands.',
            'action' => 'Voir le daily reward',
        ],
    ],
];
