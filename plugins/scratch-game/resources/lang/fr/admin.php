<?php

return [
    'nav' => [
        'title' => 'Scratch Game',
        'cards' => 'Cartes',
        'rewards' => 'Récompenses',
        'logs' => 'Logs',
        'settings' => 'Paramètres',
    ],

    'permission' => 'Gérer le plugin scratch game',

    'cards' => [
        'title' => 'Cartes à gratter',
        'create' => 'Créer une carte',
        'edit' => 'Modifier la carte :card',
        'no_cards' => 'Aucune carte à gratter trouvée.',
        'search_placeholder' => 'Rechercher une carte...',
        'confirm_delete' => 'Supprimer cette carte à gratter ?',

        'fields' => [
            'name' => 'Nom',
            'price' => 'Prix',
            'images' => 'Images de la carte',
            'cover_image' => 'Couverture du ticket',
            'background_image' => 'Image de fond après grattage',
            'free_interval_minutes' => 'Intervalle de gratuité',
            'free_interval_unit' => 'minutes',
            'free_interval_help' => 'Laisser vide pour désactiver la gratuité.',
            'relations' => 'Relations',
            'rewards' => 'Récompenses liées',
            'roles' => 'Grade(s) requis',
            'roles_info' => 'Laisser vide pour rendre la carte publique.',
            'public_access' => 'Public',
            'is_enabled' => 'Activée',
        ],

        'status' => [
            'created' => 'Carte à gratter créée avec succès.',
            'updated' => 'Carte à gratter mise à jour avec succès.',
            'deleted' => 'Carte à gratter supprimée avec succès.',
            'enabled' => 'Carte à gratter activée.',
            'disabled' => 'Carte à gratter désactivée.',
        ],
    ],

    'rewards' => [
        'title' => 'Récompenses',
        'create' => 'Créer une récompense',
        'edit' => 'Modifier la récompense :reward',
        'no_rewards' => 'Aucune récompense trouvée.',
        'search_placeholder' => 'Rechercher une récompense...',
        'confirm_delete' => 'Supprimer cette récompense ?',
        'not_used_yet' => 'Cette récompense n\'est liée à aucune carte.',

        'fields' => [
            'name' => 'Nom',
            'chance' => 'Chance %',
            'money' => 'Argent à donner',
            'image' => 'Image de la récompense',
            'commands_section' => 'Commandes',
            'commands' => 'Commandes',
            'command_name' => 'Nom de la commande',
            'command_line' => 'Ligne de commande',
            'commands_info' => 'Vous pouvez utiliser {player}, {reward}, {scratch}, {steam_id} et {steam_id_32}.',
            'add_command' => 'Ajouter une commande',
            'servers' => 'Serveur(s)',
            'need_online' => 'Exécuter uniquement si le joueur est en ligne',
            'need_online_info' => 'Disponible uniquement avec AzLink.',
            'is_enabled' => 'Activée',
            'used_in_cards' => 'Utilisée dans les scratch',
        ],

        'validation' => [
            'reward_required' => 'Vous devez configurer au moins un gain (argent ou commandes).',
            'servers_required_for_commands' => 'Au moins un serveur est requis si des commandes sont configurées.',
            'servers_required_for_need_online' => 'Au moins un serveur est requis si le mode en ligne est activé.',
            'need_online_only_azlink' => 'L\'option "joueur en ligne" fonctionne uniquement avec des serveurs AzLink.',
        ],

        'status' => [
            'created' => 'Récompense créée avec succès.',
            'updated' => 'Récompense mise à jour avec succès.',
            'deleted' => 'Récompense supprimée avec succès.',
            'enabled' => 'Récompense activée.',
            'disabled' => 'Récompense désactivée.',
        ],
    ],

    'logs' => [
        'title' => 'Logs des grattages',
        'user' => 'Utilisateur',
        'card' => 'Carte',
        'reward' => 'Récompense',
        'price_paid' => 'Prix payé',
        'money_given' => 'Argent donné',
        'commands_given' => 'Commandes données',
        'commands_modal_title' => 'Commandes du log #:id',
        'played_at' => 'Joué le',
        'no_logs' => 'Aucun log trouvé.',
        'search_placeholder' => 'Rechercher par utilisateur, carte ou récompense...',
        'filter_card' => 'Filtrer par carte',
        'filter_user' => 'Filtrer par utilisateur',
        'all_cards' => 'Toutes les cartes',
        'all_users' => 'Tous les utilisateurs',
    ],

    'settings' => [
        'title' => 'Paramètres Scratch',
        'page' => [
            'title' => 'Page',
            'page_title' => 'Titre de la page',
            'page_title_help' => 'Laisser vide pour conserver le titre par défaut.',
        ],
        'cards' => [
            'title' => 'Taille des cartes à gratter',
            'min_width' => 'Largeur minimale des cartes',
            'min_height' => 'Hauteur minimale des cartes',
            'help' => 'Contrôle la taille de la zone de grattage sur la page résultat.',
        ],
        'status' => [
            'updated' => 'Paramètres mis à jour.',
        ],
    ],

    'buttons' => [
        'create' => 'Créer',
        'save' => 'Sauvegarder',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'back' => 'Retour',
        'filter' => 'Filtrer',
        'reset' => 'Réinitialiser',
    ],

    'common' => [
        'general' => 'Général',
        'name' => 'Nom',
        'search' => 'Recherche',
        'status' => 'Statut',
        'actions' => 'Actions',
        'all' => 'Tous',
        'enabled' => 'Activé',
        'disabled' => 'Désactivé',
        'enable' => 'Activer',
        'disable' => 'Désactiver',
        'enable_feature' => 'Activer cette fonctionnalité',
        'hold_ctrl_multiple' => 'Maintenez Ctrl pour sélectionner plusieurs éléments',
        'max_image_size' => 'Taille max du fichier : :size',
    ],
];
