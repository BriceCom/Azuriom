<?php

return [
    'nav' => [
        'title' => 'Daily Reward',
        'settings' => 'Paramètres',
        'days' => 'Jours du cycle',
        'rewards' => 'Récompenses',
        'claims' => 'Historique',
    ],
    'permissions' => [
        'admin' => 'Gérer le plugin Daily Reward',
        'settings' => 'Modifier les paramètres Daily Reward',
        'days' => 'Gérer les jours du cycle',
        'rewards' => 'Gérer les récompenses',
        'logs' => 'Consulter l’historique des claims',
    ],
    'logs' => [
        'settings' => [
            'updated' => 'Mise à jour des paramètres Daily Reward',
        ],
        'daily-reward-days' => [
            'created' => 'Création du jour Daily Reward #:id',
            'updated' => 'Modification du jour Daily Reward #:id',
            'deleted' => 'Suppression du jour Daily Reward #:id',
        ],
        'daily-reward-rewards' => [
            'created' => 'Création de la récompense Daily Reward #:id',
            'updated' => 'Modification de la récompense Daily Reward #:id',
            'deleted' => 'Suppression de la récompense Daily Reward #:id',
        ],
    ],
    'settings' => [
        'title' => 'Paramètres Daily Reward',
        'fields' => [
            'enabled' => 'Activer le daily reward',
            'reset_mode' => 'Mode de reset',
            'cycle_length' => 'Longueur du cycle (jours)',
            'default_money' => 'Montant monnaie par défaut',
            'webhook' => 'URL webhook Discord',
            'mail_notifications' => 'Envoyer un e-mail après chaque claim',
            'public_leaderboard' => 'Activer le leaderboard public',
            'sync_rewards' => 'Créer des récompenses par défaut pour les jours manquants',
        ],
        'reset_modes' => [
            'midnight' => 'Reset à minuit',
            'rolling_24h' => 'Fenêtre glissante 24h',
        ],
        'webhook_info' => 'Le payload webhook suit le même principe embed que le plugin Support.',
        'mail_info' => 'Les e-mails utilisent la configuration mail globale Azuriom :',
        'mail_link' => 'ouvrir les paramètres mail',
        'mail_disabled' => 'Le système mail est actuellement désactivé dans Azuriom.',
        'public_leaderboard_info' => 'Quand activé, les utilisateurs peuvent consulter le classement des streaks.',
        'public_leaderboard_link' => 'ouvrir le leaderboard',
        'sync_rewards_info' => 'Si activé, une récompense monnaie par défaut est créée pour chaque jour sans récompense.',
    ],
    'days' => [
        'title' => 'Jours du cycle',
        'create' => 'Créer un jour',
        'edit' => 'Modifier le jour #:day',
        'fields' => [
            'enabled' => 'Activer ce jour',
        ],
    ],
    'rewards' => [
        'title' => 'Récompenses',
        'create' => 'Créer une récompense',
        'edit' => 'Modifier la récompense :reward',
        'types' => [
            'money' => 'Monnaie',
            'command' => 'Commande',
        ],
        'fields' => [
            'servers' => 'Serveurs',
            'commands' => 'Commandes',
            'need_online' => 'Nécessite le joueur en ligne pour les commandes',
            'enabled' => 'Activer cette récompense',
        ],
        'money_info' => 'Utilisé si le type est Monnaie. Doit être > 0.',
        'servers_info' => 'Obligatoire si le type est Commande.',
        'commands_info' => 'Variables disponibles : :placeholders',
        'validation' => [
            'money_required' => 'Le montant doit être supérieur à 0 pour une récompense monnaie.',
            'commands_required' => 'Au moins une commande est requise pour une récompense commande.',
            'servers_required' => 'Au moins un serveur est requis pour une récompense commande.',
        ],
    ],
    'claims' => [
        'title' => 'Historique des claims',
        'search_placeholder' => 'Rechercher par pseudo...',
        'fields' => [
            'rewards' => 'Nombre de récompenses',
        ],
    ],
];
