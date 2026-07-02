<?php

return [
    'title' => 'Chasse',
    'description' => 'Trouvez et collectez des objets de chasse qui apparaissent aléatoirement sur le site pour gagner des récompenses !',

    'current' => 'En cours',
    'current_hunt' => 'Chasse en cours',
    'active' => 'Active',
    'scheduled' => 'Planifiée',
    'ended' => 'Terminée',
    'archived' => 'Archivée',

    'all_hunts' => 'Toutes les chasses',
    'no_hunts' => 'Aucune chasse disponible',
    'no_hunts_description' => 'Il n\'y a aucune chasse disponible pour le moment. Revenez plus tard !',
    'no_active_hunt' => 'Aucune chasse active pour le moment. Revenez plus tard pour de nouvelles chasses !',
    'view_details' => 'Voir les détails',
    'view_leaderboard' => 'Voir le classement',
    'back_to_hunts' => 'Retour aux chasses',

    'hunt_details' => 'Chasse : :hunt',
    'starts' => 'Débute',
    'ends' => 'Se termine',
    'total_claims' => 'Total des récupérations',
    'amount_total_claims' => ':amount récupérations au total',
    'total_players' => 'Total de joueurs',
    'total_money_given' => 'Total distribué',
    'max_per_day' => 'Maximum par jour',
    'rewards' => 'Récompenses',

    'global_progress' => ':current / :total récupérations',
    'your_progress_today' => 'Votre progression : :current / :total',
    'cap_reached' => 'Cap atteint',
    'global_cap_reached' => 'Cette chasse a atteint son nombre maximum de récompenses.',

    'leaderboard' => 'Classement',
    'rank' => 'Rang',
    'player' => 'Joueur',
    'money_earned' => 'Gains',
    'last_claim' => 'Dernière récupération',
    'you' => 'Vous',
    'no_claims_yet' => 'Aucune récupération pour le moment',
    'be_the_first' => 'Soyez le premier à récupérer cette chasse !',

    'your_position' => 'Votre position : #:position',
    'claims_today' => 'Récupérations aujourd\'hui',
    'earned_today' => 'Gagné aujourd\'hui',
    'money_earned_today' => 'Gains aujourd\'hui : :amount',
    'daily_progress' => 'Progression journalière',
    'daily_progress_summary' => 'Vous avez eu la chasse :current fois sur :total aujourd\'hui',
    'overall_stats' => 'Statistiques globales',
    'total_earned' => 'Total gagné',
    'money_total_earned' => 'Total gagné : :money :moneyName',
    'your_rank' => 'Votre rang',
    'no_progress_yet' => 'Vous n\'avez pas encore participé à cette chasse.',
    'ready_to_hunt' => 'Prêt à chasser ! Cherchez les objets qui apparaissent sur le site.',
    'daily_limit_reached' => 'Vous avez atteint votre limite journalière pour cette chasse.',
    'cooldown_remaining' => 'Temps d\'attente restant',
    'minutes' => 'minutes',

    'login_to_participate' => 'Connectez-vous pour participer',
    'login_description' => 'Vous devez être connecté pour participer aux chasses et gagner des récompenses.',
    'login' => 'Connexion',
    'not_authenticated' => 'Vous devez être connecté pour récupérer les récompenses de chasse.',

    'available_rewards' => 'Récompenses disponibles',

    'hunt_not_active' => 'Cette chasse n\'est pas active actuellement.',
    'spawn_failed' => 'Pas de chance cette fois ! Aucune récompense n\'a été donnée.',
    'cooldown_active' => 'Vous devez attendre avant de récupérer une nouvelle chasse.',
    'unknown_error' => 'Une erreur inattendue est survenue. Veuillez réessayer.',

    'congratulations' => 'Félicitations !',
    'reward_received' => 'Vous avez reçu : :reward',
    'money_earned_amount' => 'Gains : :amount',
    'commands_executed' => 'Commandes exécutées : :count',
    'no_reward_this_time' => 'Aucune récompense cette fois, mais continuez à chasser !',
    'better_luck_next_time' => 'Meilleure chance la prochaine fois !',
    'hunt_didnt_reward' => 'La chasse n\'a rien donné cette fois, mais continuez !',
    'next_attempt_available' => 'Prochaine tentative disponible dans : :minutes minutes',
    'connection_error' => 'Erreur de connexion',
    'failed_to_process' => 'Impossible de traiter la récupération. Veuillez réessayer plus tard.',
    'warnings' => 'Avertissements',
    'error' => 'Erreur',
    'hunt_error' => 'Erreur de chasse',
    'time_remaining' => 'Temps restant',

    'unfortunately_not_logged_in' => 'Vous n\'étiez pas connecté. La récompense ne peut pas vous être attribuée. Peut-être la prochaine fois !',

    'hunt_cap_reached' => 'La chasse a distribué toutes les récompenses possibles !',
    'total_rewards_given' => 'Total des récompenses distribuées : :total',

    'just_now' => 'À l\'instant',
    'seconds_ago' => 'il y a :count secondes',
    'minutes_ago' => 'il y a :count minutes',
    'hours_ago' => 'il y a :count heures',
    'days_ago' => 'il y a :count jours',

    'close' => 'Fermer',
    'hunt_result' => 'Résultat de la chasse',
    'view_leaderboard_btn' => 'Voir le classement',
    'try_again' => 'Réessayer',
    'daily_limit_message' => 'Vous avez atteint votre limite journalière pour cette chasse.',

    'hunt_mechanics' => [
        'title' => 'Comment fonctionnent les chasses',
        'description' => 'Les objets de chasse apparaissent aléatoirement sur le site. Quand vous en voyez un, cliquez vite pour récupérer votre récompense !',
        'tips' => [
            'Les objets de chasse apparaissent pendant un temps limité avant de disparaître.',
            'Vous ne pouvez récupérer qu\'un certain nombre de récompenses par jour.',
            'Chaque chasse a son propre taux d\'apparition et ses récompenses.',
            'Assurez-vous d\'être connecté pour recevoir les récompenses.',
            'Les objets de chasse n\'apparaissent pas sur les pages admin ni pendant la connexion/inscription.',
        ],
    ],

    'errors' => [
        'hunt_not_found' => 'Chasse introuvable.',
        'reward_not_found' => 'Récompense introuvable.',
        'invalid_request' => 'Requête invalide.',
        'server_error' => 'Une erreur serveur est survenue.',
        'rate_limited' => 'Trop de requêtes. Merci de ralentir.',
        'reward_money_failed' => 'Impossible d\'ajouter la récompense en monnaie : :error',
        'reward_commands_failed' => 'Impossible d\'exécuter les commandes serveur : :error',
    ],

    'success' => [
        'reward_claimed' => 'Récompense récupérée avec succès !',
        'progress_updated' => 'Votre progression a été mise à jour.',
    ],

    'placeholders' => [
        'no_description' => 'Aucune description disponible.',
        'no_image' => 'Aucune image',
        'loading' => 'Chargement...',
        'coming_soon' => 'Bientôt disponible',
    ],

    'accessibility' => [
        'hunt_item_alt' => 'Objet de chasse : :name',
        'user_avatar_alt' => 'Avatar de :name',
        'reward_image_alt' => 'Récompense : :name',
        'hunt_image_alt' => 'Chasse : :name',
        'progress_bar' => 'Progression : :current sur :total',
        'leaderboard_position' => 'Position :rank dans le classement',
    ],

    'meta' => [
        'page_title' => 'Chasse - :hunt',
        'page_description' => 'Participez à :hunt et gagnez des récompenses en trouvant des objets de chasse sur le site.',
        'leaderboard_title' => 'Classement :hunt',
        'leaderboard_description' => 'Découvrez qui mène la :hunt et disputez les premières places !',
    ],
];
