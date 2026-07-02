<?php

return [
    'title' => 'Scratch Game',
    'result_title' => 'Résultat du grattage',

    'points_label' => 'points boutique',
    'your_points' => 'Vos points : :points',
    'remaining_points' => 'Points restants',
    'price_paid' => 'Prix payé',

    'cards_count' => 'grattage(s)',
    'linked_rewards' => 'Récompenses liées',
    'buy_and_scratch' => 'Acheter et gratter',
    'locked_for_role' => 'Bloqué pour votre grade',
    'no_cards_available' => 'Aucune carte à gratter n\'est disponible pour le moment.',
    'no_reward' => 'Aucune récompense',

    'login_required' => 'Connectez-vous pour acheter et gratter des tickets.',
    'back_to_cards' => 'Retour aux cartes',
    'scratch_here' => 'Grattez ici',
    'scratch_to_reveal' => 'Grattez pour découvrir votre récompense',
    'revealing_reward' => 'Révélation de votre récompense...',
    'command_reward_only' => 'Des commandes ont été envoyées sur le(s) serveur(s) configuré(s).',
    'try_again' => 'Essayez une autre carte.',
    'play_summary' => 'Résumé du tirage',
    'card_label' => 'Carte',
    'played_at' => 'Joué le',
    'play_again' => 'Rejouer',

    'pending' => [
        'title' => ':count ticket(s) non terminé(s)',
        'description' => 'Vous avez déjà acheté ces tickets. Continuez le grattage pour révéler les récompenses.',
        'continue' => 'Continuer le grattage',
        'see_all' => 'Voir l\'historique complet',
    ],

    'history' => [
        'title' => 'Historique de mes grattages',
        'empty' => 'Vous n\'avez encore aucun grattage.',
        'card' => 'Carte',
        'reward' => 'Récompense',
        'gain' => 'Gain',
        'money_gain' => 'Gain :name',
        'commands_gain' => 'Gain commande(s)',
        'commands_modal_title' => 'Commandes du grattage #:id',
        'commands_executed' => ':count commande(s) serveur',
        'no_gain' => 'Aucun gain direct',
        'status' => [
            'pending' => 'En attente',
            'claimed' => 'Révélé',
        ],
        'actions' => [
            'continue' => 'Gratter maintenant',
            'view' => 'Voir le résultat',
        ],
    ],

    'play' => [
        'success' => 'Votre ticket a été acheté. Grattez pour découvrir votre récompense !',
    ],

    'categories' => [
        'public' => 'Scratch public',
    ],

    'errors' => [
        'role_not_allowed' => 'Vous n\'avez pas le grade requis pour cette carte.',
        'no_enabled_rewards' => 'Aucune récompense active n\'est liée à cette carte.',
        'not_enough_points' => ':currency insuffisants. Prix : :price :currency.',
        'unknown_error' => 'Une erreur inattendue est survenue pendant le grattage.',
        'claim_failed' => 'Impossible de révéler votre récompense pour le moment. Réessayez.',
        'reward_money_failed' => 'Impossible de donner l\'argent de la récompense : :error',
        'reward_commands_failed' => 'Impossible d\'exécuter les commandes serveur : :error',
        'reward_commands_no_server' => 'Impossible d\'exécuter les commandes serveur : aucun serveur configuré pour cette récompense.',
        'need_online_ignored' => 'L\'option "en ligne" a été ignorée sur le serveur :server (non AzLink).',
    ],

    'free' => [
        'label' => 'Ticket gratuit',
        'available' => 'Ticket gratuit disponible.',
        'cooldown_label' => 'Gratuit dans : :cooldown',
        'next' => 'Ticket gratuit dans :cooldown.',
        'next_for_card' => 'Prochain ticket gratuit pour :card dans :cooldown.',
        'price_label' => 'Gratuit',
        'price_paid_label' => 'Gratuit',
    ],
];
