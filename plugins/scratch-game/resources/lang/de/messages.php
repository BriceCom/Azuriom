<?php

return [
    'title' => 'Rubbellos-Spiel',
    'result_title' => 'Rubbellos-Ergebnis',

    'points_label' => 'Shop-Punkte',
    'your_points' => 'Deine Punkte: :points',
    'remaining_points' => 'Verbleibende Punkte',
    'price_paid' => 'Gezahlter Preis',

    'cards_count' => 'Rubbellos(e)',
    'linked_rewards' => 'Verknüpfte Belohnungen',
    'buy_and_scratch' => 'Kaufen und freirubbeln',
    'locked_for_role' => 'Für deine Rolle gesperrt',
    'no_cards_available' => 'Derzeit sind keine Rubbellose verfügbar.',
    'no_reward' => 'Keine Belohnung',

    'login_required' => 'Logge dich ein, um Lose zu kaufen und freizurubbeln.',
    'back_to_cards' => 'Zurück zu den Losen',
    'scratch_here' => 'Hier rubbeln',
    'scratch_to_reveal' => 'Rubbeln, um deine Belohnung aufzudecken',
    'revealing_reward' => 'Deine Belohnung wird aufgedeckt...',
    'command_reward_only' => 'Befehle wurden an die konfigurierten Server gesendet.',
    'try_again' => 'Versuche ein anderes Rubbellos.',
    'play_summary' => 'Spielzusammenfassung',
    'card_label' => 'Los',
    'played_at' => 'Gespielt am',
    'play_again' => 'Nochmal spielen',

    'pending' => [
        'title' => ':count unvollendete(s) Rubbellos(e)',
        'description' => 'Du hast diese Lose bereits gekauft. Rubble weiter, um die Belohnungen aufzudecken.',
        'continue' => 'Weiter rubbeln',
        'see_all' => 'Gesamten Verlauf ansehen',
    ],

    'history' => [
        'title' => 'Mein Rubbellos-Verlauf',
        'empty' => 'Du hast noch keine Rubbellos-Spiele.',
        'card' => 'Los',
        'reward' => 'Belohnung',
        'gain' => 'Erhaltene Belohnung',
        'money_gain' => ':name erhalten',
        'commands_gain' => 'Befehl(e) erhalten',
        'commands_modal_title' => 'Befehle für Los #:id',
        'commands_executed' => ':count Serverbefehl(e)',
        'no_gain' => 'Kein direkter Gewinn',
        'status' => [
            'pending' => 'Ausstehend',
            'claimed' => 'Beansprucht',
        ],
        'actions' => [
            'continue' => 'Jetzt rubbeln',
            'view' => 'Ergebnis ansehen',
        ],
    ],

    'play' => [
        'success' => 'Dein Los wurde gekauft. Rubble, um deine Belohnung zu entdecken!',
    ],

    'categories' => [
        'public' => 'Öffentliches Los',
    ],

    'errors' => [
        'role_not_allowed' => 'Du bist nicht berechtigt, dieses Rubbellos zu spielen.',
        'no_enabled_rewards' => 'Diesem Rubbellos ist keine aktivierte Belohnung zugewiesen.',
        'not_enough_points' => 'Nicht genug :currency. Preis: :price :currency.',
        'unknown_error' => 'Ein unerwarteter Fehler ist bei der Verarbeitung deines Rubbelloses aufgetreten.',
        'claim_failed' => 'Deine Belohnung kann derzeit nicht aufgedeckt werden. Bitte versuche es erneut.',
        'reward_money_failed' => 'Geld-Belohnung konnte nicht vergeben werden: :error',
        'reward_commands_failed' => 'Serverbefehle konnten nicht ausgeführt werden: :error',
        'reward_commands_no_server' => 'Serverbefehle konnten nicht ausgeführt werden: Für diese Belohnung ist kein Server konfiguriert.',
        'need_online_ignored' => 'Online-Zwang wurde auf Server :server ignoriert (nicht AzLink).',
    ],

    'free' => [
        'label' => 'Kostenloses Los',
        'available' => 'Kostenloses Los jetzt verfügbar.',
        'cooldown_label' => 'Kostenlos in: :cooldown',
        'next' => 'Kostenloses Los in :cooldown.',
        'next_for_card' => 'Nächstes kostenloses Los für :card in :cooldown.',
        'price_label' => 'Kostenlos',
        'price_paid_label' => 'Kostenlos',
    ],
];
