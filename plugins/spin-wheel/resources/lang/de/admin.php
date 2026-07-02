<?php
// Thanks to Kadnick

return [
    'plugin' => [
        'name' => 'Glücksrad'
    ],
    'permission' => [
        'admin' => "Glücksrad Verwaltung ansehen und bearbeiten",
        'user' => 'Spiele das Glücksrad',
        'required' => "Es ist zwingend erforderlich die Berechtigung <code>Spiele das Glücksrad</code> für Gruppen zu aktivieren, die spielen dürfen!",
        'denied' => "Du hast leider keine Berechtigung, um zu spielen!"
    ],
    'pages' => [
        'settings' => [
            'title' => 'Einstellungen',
            'general' => [
                'title' => 'Allgemein',
                'forms' => [
                    'price' => "Preis einer Drehung",
                    'priceDesc' => "Wenn kein Preis angegeben (oder = 0), sind Drehungen immer kostenlos.",
                    'delay' => "Zeit zwischen den Drehungen",
                    'delayDesc' => "Wenn keine Verzögerung (oder = 0), können Spieler direkt hintereinander drehen.",
                    "displayPlayers" => "Die Anzahl der Einträge unter Drehverlauf",
                    "displayPlayersInfo" => 'Wenn = 0, dann wird "Drehverlauf" Kategorie nicht angezeigt.',
                    'tooglePercentage' => "Zeige die Chancen auf der Glücksrad Seite an",
                    'ordering' => "Sortiere die Belohnungen nach Chancen."
                ]
            ],
            'freeSpin' => [
                'title' => 'Kostenlose Drehung',
                'forms' => [
                    'toogleFreeSpin' => 'Aktiviere kostenlose Drehungen',
                    'delay' => 'Verzögerung zwischen kostenlosen Drehungen'
                ]
            ],
            'webhook' => [
                'title' => 'Webhook',
                'forms' => [
                    'url' => 'Discord webhook url',
                    'title' => 'Titel',
                    'desc' => 'Beschreibung',
                    'footer' => 'Fußzeile',
                    'toogleSkin' => 'Zeige Spieler Skin',
                    'toogleDate' => 'Zeige Datum in Fußzeile'
                ],
                'placeholders' => [
                    'title' => "Du kannst die folgenden Platzhalter verwenden:",
                    'player' => '<code>{player}</code> : Spielername',
                    'reward' => '<code>{reward}</code> : Belohnungsname',
                    'siteName' => '<code>{site_name}</code> : ' . site_name(),
                    'markdown' => 'Du kannst außerdem <a target="_blank" href="https://support.discord.com/hc/en-us/articles/210298617-Markdown-Text-101-Chat-Formatting-Bold-Italic-Underline-">Markdown</a> Sprache verwenden.'
                ]
            ],
            'notifs' => [
                'updated' => 'Eingaben geupdatet.',
            ]
        ],
        'statistics' => [
            'title' => 'Statistiken',
            'truncate' => [
                'title' => 'Setze Statistiken zurück',
                'desc' => "Es werden alle statistischen Einträge gelöscht. Es werden keine Belohnungen gelöscht. Warnung, diese Aktion ist unumkehrbar und löscht die kostenfreien Drehungen!",
                'button' => 'Setze Statistiken zurück',
                'notifs' => [
                    'success' => 'Die Statistiken wurden zurückgesetzt'
                ]
            ],
            'cards' => [
                'rewards' => 'Aktive Belohnungen',
                'spins' => 'Drehungen',
                'moneySpent' => 'Ausgegebenes Geld',
                'moneyGiven' => 'Gewonnenes Geld'
            ],
            'tables' => [
                'rewards' => [
                    'title' => 'Belohnungen',
                    'cols' => [
                        'reward' => "Belohnung",
                        'total' => 'x Mal gewonnen',
                        'winRate' => 'Gewinnrate'
                    ]
                ],
                'players' => [
                    'title' => 'Drehverlauf',
                    'cols' => [
                        'player' => 'Spieler',
                        'reward' => 'Belohnung',
                        'price' => 'Preis',
                        'date' => 'Datum'
                    ],
                    'row' => [
                        'empty' => 'Keine Einträge'
                    ]
                ]
            ]

        ],
        'rewards' => [
            'index' => [
                'title' => 'Belohnungen',
                'table' => [
                    'cols' => [
                        'name' => 'Name',
                        'chances' => 'Chancen',
                        'enabled' => 'Aktiviert',
                        'actions' => 'Aktionen'
                    ],
                    'row' => [
                        'empty' => "Keine Belohnungen"
                    ]
                ],
            ],
            'create' => [
                'title' => 'Erstelle eine Belohnung',
            ],
            'edit' => [
                'title' => 'Bearbeite eine Belohnung'
            ],
            'form' => [
                'name' => 'Name',
                'color' => 'Farbe',
                'chances' => 'Chance',
                'money' => 'Geld',
                'servers' => 'Server (ctrl + Klicken um mehrere auszuwählen)',
                'commands' => 'Befehle',
                'commandsDesc' => "Du kannst den Platzhalter <code>{player}</code> für den Spielernamen verwenden. Der Befehl darf nicht mit einem <code>/</code> anfangen!",
                'toogleWebhook' => 'Sende einen Webhook',
                'toogleAzlink' => "Befehl erst ausführen, wenn der Spieler online ist (nur verfügbar mit AzLink)",
                'toogleEnable' => "Belohnung aktivieren",
                'fontSize' => "Schriftgröße",
                'orientation' => 'Schriftausrichtung',
                'direction' => 'Schriftverlauf',
                'horizontal' => 'Horizontal',
                'vertical' => 'Vertikal',
                'curved' => 'Kurviert',
                'normal' => 'Normal',
                'reversed' => 'Umgekehrt'
            ],
            'notifs' => [
                'created' => 'Belohnung erfolgreich erstellt.',
                'updated' => 'Belohnung erfolgreich gespeichert.',
                'deleted' => 'Belohnung erfolgreich gelöscht.'
            ]
        ]
    ],
    'errors' => [
        'api' => [
            'delay' => "Du kannst spielen ",
            'money' => "Du hast nicht genug " . money_name() . '.',
        ]
    ],
    "infos" => [
        'sold' => 'Dein Guthaben : ',
        'updateMessage' => "<strong>Wichtig! V2.0.0</strong> Du musst alle Belohnungen bearbeiten!"
    ],
    "webhook" => [
        'title' => '>> Drehe das Glücksrad !',
        'description' => '``{player} hat {reward} gewonnen``',
        'footer' => '{site_name} | Glücksrad',
        'sent' => 'Webhook gesendet !'
    ]
];
