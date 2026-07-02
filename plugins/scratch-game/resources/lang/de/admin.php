<?php

return [
    'nav' => [
        'title' => 'Rubbellos-Spiel',
        'cards' => 'Rubbellose',
        'rewards' => 'Belohnungen',
        'logs' => 'Protokolle',
        'settings' => 'Einstellungen',
    ],

    'permission' => 'Rubbellos-Plugin verwalten',

    'cards' => [
        'title' => 'Rubbellose',
        'create' => 'Los erstellen',
        'edit' => 'Los bearbeiten :card',
        'no_cards' => 'Keine Rubbellose gefunden.',
        'search_placeholder' => 'Nach einem Los suchen...',
        'confirm_delete' => 'Bist du sicher, dass du dieses Los löschen möchtest?',

        'fields' => [
            'name' => 'Name',
            'price' => 'Preis',
            'images' => 'Los-Bilder',
            'cover_image' => 'Los-Titelbild',
            'background_image' => 'Hintergrundbild nach dem Freirubbeln',
            'free_interval_minutes' => 'Intervall für kostenlose Lose',
            'free_interval_unit' => 'Minuten',
            'free_interval_help' => 'Leer lassen, um das kostenlose Intervall zu deaktivieren.',
            'relations' => 'Beziehungen',
            'rewards' => 'Verknüpfte Belohnungen',
            'roles' => 'Erforderliche Rollen',
            'roles_info' => 'Leer lassen für öffentlichen Zugang.',
            'public_access' => 'Öffentlich',
            'is_enabled' => 'Aktiviert',
        ],

        'status' => [
            'created' => 'Rubbellos erfolgreich erstellt.',
            'updated' => 'Rubbellos erfolgreich aktualisiert.',
            'deleted' => 'Rubbellos erfolgreich gelöscht.',
            'enabled' => 'Rubbellos erfolgreich aktiviert.',
            'disabled' => 'Rubbellos erfolgreich deaktiviert.',
        ],
    ],

    'rewards' => [
        'title' => 'Rubbellos-Belohnungen',
        'create' => 'Belohnung erstellen',
        'edit' => 'Belohnung bearbeiten :reward',
        'no_rewards' => 'Keine Belohnungen gefunden.',
        'search_placeholder' => 'Nach einer Belohnung suchen...',
        'confirm_delete' => 'Bist du sicher, dass du diese Belohnung löschen möchtest?',
        'not_used_yet' => 'Diese Belohnung ist noch mit keinem Los verknüpft.',

        'fields' => [
            'name' => 'Name',
            'chance' => 'Chance %',
            'money' => 'Zu vergebendes Geld',
            'image' => 'Belohnungsbild',
            'commands_section' => 'Befehle',
            'commands' => 'Befehle',
            'command_name' => 'Befehlsname',
            'command_line' => 'Befehlszeile',
            'commands_info' => 'Du kannst {player}, {reward}, {scratch}, {steam_id} und {steam_id_32} verwenden.',
            'add_command' => 'Befehl hinzufügen',
            'servers' => 'Server',
            'need_online' => 'Befehle ausführen, wenn der Benutzer auf dem Server online ist (nur mit AzLink verfügbar)',
            'need_online_info' => 'Befehle ausführen, wenn der Benutzer auf dem Server online ist (nur mit AzLink verfügbar)',
            'is_enabled' => 'Aktiviert',
            'used_in_cards' => 'In Rubbellosen verwendet',
        ],

        'validation' => [
            'reward_required' => 'Du musst mindestens eine Belohnungsart (Geld oder Befehle) konfigurieren.',
            'servers_required_for_commands' => 'Mindestens ein Server ist erforderlich, wenn Befehle konfiguriert sind.',
            'servers_required_for_need_online' => 'Mindestens ein Server ist erforderlich, wenn der Nur-Online-Modus aktiviert ist.',
            'need_online_only_azlink' => 'Die Nur-Online-Ausführung funktioniert nur mit AzLink-Servern.',
        ],

        'status' => [
            'created' => 'Belohnung erfolgreich erstellt.',
            'updated' => 'Belohnung erfolgreich aktualisiert.',
            'deleted' => 'Belohnung erfolgreich gelöscht.',
            'enabled' => 'Belohnung erfolgreich aktiviert.',
            'disabled' => 'Belohnung erfolgreich deaktiviert.',
        ],
    ],

    'logs' => [
        'title' => 'Rubbellos-Protokolle',
        'user' => 'Benutzer',
        'card' => 'Los',
        'reward' => 'Belohnung',
        'price_paid' => 'Gezahlter Preis',
        'money_given' => 'Vergebenes Geld',
        'commands_given' => 'Ausgeführte Befehle',
        'commands_modal_title' => 'Befehle für Protokoll #:id',
        'played_at' => 'Gespielt am',
        'no_logs' => 'Keine Protokolle gefunden.',
        'search_placeholder' => 'Nach Benutzer, Los oder Belohnung suchen...',
        'filter_card' => 'Nach Los filtern',
        'filter_user' => 'Nach Benutzer filtern',
        'all_cards' => 'Alle Lose',
        'all_users' => 'Alle Benutzer',
    ],

    'settings' => [
        'title' => 'Rubbellos-Einstellungen',
        'page' => [
            'title' => 'Seite',
            'page_title' => 'Seitentitel',
            'page_title_help' => 'Leer lassen, um den Standardtitel beizubehalten.',
        ],
        'cards' => [
            'title' => 'Rubbellos-Größe',
            'min_width' => 'Minimale Losbreite',
            'min_height' => 'Minimale Loshöhe',
            'help' => 'Steuert die Größe des Rubbelbereichs auf der Ergebnisseite.',
        ],
        'status' => [
            'updated' => 'Einstellungen erfolgreich aktualisiert.',
        ],
    ],

    'buttons' => [
        'create' => 'Erstellen',
        'save' => 'Speichern',
        'edit' => 'Bearbeiten',
        'delete' => 'Löschen',
        'back' => 'Zurück',
        'filter' => 'Filtern',
        'reset' => 'Zurücksetzen',
    ],

    'common' => [
        'general' => 'Allgemein',
        'name' => 'Name',
        'search' => 'Suchen',
        'status' => 'Status',
        'actions' => 'Aktionen',
        'all' => 'Alle',
        'enabled' => 'Aktiviert',
        'disabled' => 'Deaktiviert',
        'enable' => 'Aktivieren',
        'disable' => 'Deaktivieren',
        'enable_feature' => 'Dieses Feature aktivieren',
        'hold_ctrl_multiple' => 'Strg gedrückt halten, um mehrere auszuwählen',
        'max_image_size' => 'Maximale Dateigröße: :size',
    ],
];
