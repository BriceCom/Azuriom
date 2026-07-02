<?php

return [
    'plugin' => [
        'name' => 'Roue de la fortune'
    ],
    'permission' => [
        'admin' => "Voir & gérer le plugin Roue de la fortune",
        'user' => 'Jouer à la Roue de la fortune',
        'required' => "Il est nécessaire d'ajouter la permission <code> jouer à la Roue de la fortune</code> pour que les groupes concernés puissent jouer !",
        'denied' => "Vous n'avez pas la permission de jouer!"
    ],
    'pages' => [
        'settings' => [
            'title' => 'Paramètres',
            'general' => [
                'title' => 'Général',
                'forms' => [
                    'price' => "Prix d'un tour de roue",
                    'priceDesc' => "Si aucun prix n'est renseigné (ou = 0), les joueurs peuvent jouer gratuitement.",
                    'delay' => "Délaie entre deux tours de roue.",
                    'delayDesc' => "Si aucun délai n'est renseigné (ou = 0), les joueurs peuvent jouer sans restrictions.",
                    "displayPlayers" => "Nombre de derniers joueurs sur la page d'accueil.",
                    "displayPlayersInfo" => 'Si = 0, La catégorie "Derniers joueurs" n\'apparaîtra pas.',
                    'tooglePercentage' => "Afficher le pourcentage sur la page d'accueil",
                    'ordering' => "Classer les récompenses selon la probabilité.",
                    'proportionalWheel' => "Les segments de la roue sont proportionnels aux chances de récompense",
                ]
            ],
            'freeSpin' => [
                'title' => 'Tour gratuit',
                'forms' => [
                    'toogleFreeSpin' => 'Activer un tour gratuit',
                    'delay' => 'Délai entre deux tours gratuits'
                ]
            ],
            'webhook' => [
                'title' => 'Webhook',
                'forms' => [
                    'url' => 'Url du webhook discord',
                    'title' => 'Titre',
                    'desc' => 'Description',
                    'footer' => 'Footer',
                    'toogleSkin' => 'Afficher le skin du joueur',
                    'toogleDate' => 'Afficher la date dans le footer'
                ],
                'placeholders' => [
                    'title' => "Vous pouvez utiliser les placeholders suivants :",
                    'player' => '<code>{player}</code> : Pseudo du joueur',
                    'reward' => '<code>{reward}</code> : Nom de la récompense',
                    'siteName' => '<code>{site_name}</code> : ' . site_name(),
                    'markdown' => 'Vous pouvez aussi utiliser le langage <a target="_blank" href="https://support.discord.com/hc/en-us/articles/210298617-Markdown-Text-101-Chat-Formatting-Bold-Italic-Underline-">Markdown</a>'
                ]
                ],
            'notifs' => [
                'updated' => 'Paramétres mis à jour avec succès',
            ]
        ],
        'statistics' => [
            'title' => 'Statistiques',
            'truncate' => [
                'title' => 'Vider les statistiques',
                'desc' => "Cela supprimera toutes les statistiques de la base de données. Cela ne supprimera pas les récompenses. Attention, cette action est irréversible et entrainera la réinitialisation des tours gratuits !",
                'button' => 'Vider les statistiques',
                'notifs' => [
                    'success' => 'Statistiques vidées avec succès'
                ]
            ],
            'cards' => [
                'rewards' => 'Récompenses actives',
                'spins' => 'Tours de roue',
                'moneySpent' => 'Argent dépensé',
                'moneyGiven' => 'Argent donné'
            ],
            'tables' => [
                'rewards' => [
                    'title' => 'Récompenses',
                    'cols' => [
                        'reward' => "Récompense",
                        'total' => 'Gagné x fois',
                        'winRate' => 'Taux de gain'
                    ]
                ],
                'players' => [
                    'title' => 'Derniers joueurs',
                    'cols' => [
                        'player' => 'Joueur',
                        'reward' => 'Récompenses',
                        'price' => 'Prix',
                        'date' => 'Date'
                    ],
                    'row' => [
                        'empty' => 'Aucun joueur'
                    ]
                ]
            ]

        ],
        'rewards' => [
            'index' => [
                'title' => 'Récompenses',
                'table' => [
                    'cols' => [
                        'name' => 'Nom',
                        'chances' => 'Chances',
                        'enabled' => 'Activé',
                        'actions' => 'Actions'
                    ],
                    'row' => [
                        'empty' => "Aucune récompense"
                    ]
                ],
            ],
            'create' => [
                'title' => 'Créer une récompense',
            ],
            'edit' => [
                'title' => 'Modifier la récompense'
            ],
            'form' => [
                'name' => 'Nom',
                'color' => 'Couleur',
                'chances' => 'Chances',
                'money' => 'Argent',
                'scratchCard' => 'Carte à gratter',
                'scratchCardDesc' => 'Attribuer un ticket de carte à gratter en plus de la récompense.',
                'scratchCardNone' => 'Aucune carte à gratter',
                'servers' => 'Serveurs (ctrl + click pour en sélectionner plusieurs)',
                'commands' => 'Commandes',
                'commandsDesc' => "Vous pouvez utiliser <code>{player}</code> pour utiliser le nom du joueur. La commande ne doit pas contenir de <code>/</code> au début.",
                'toogleWebhook' => 'Envoyer un webhook',
                'toogleAzlink' => "Exécuter les commandes lorsque l'utilisateur est en ligne sur le serveur (uniquement disponible avec AzLink)",
                'toogleEnable' => "Activer la récompense",
                'fontSize' => "Taille du texte",
                'orientation' => 'Orientation du texte',
                'direction' => 'Direction du texte',
                'horizontal' => 'Horizontale',
                'vertical' => 'Verticale',
                'curved' => 'Incurvée',
                'normal' => 'Normale',
                'reversed' => 'Renversée'
            ],
            'notifs' => [
                'created' => 'Récompense créée avec succès.',
                'updated' => 'Récompense mise à jour avec succès',
                'deleted' => 'Récompense supprimée avec succès'
            ]
        ]
    ],
    'errors' => [
        'api' => [
            'delay' => "Vous pourrez jouer ",
            'money' => "Vous n'avez pas assez de " . money_name() . '.',
        ]
    ],
    "infos" => [
        'sold' => 'Votre solde est de : ',
        'updateMessage' => "<strong>Important! V2.0.0</strong> Vous devez modifier toutes vos récompenses"
    ],
    "webhook" => [
        'title' => '>> Faire tourner la roue !',
        'description' => '``{player} à gagné {reward}``',
        'footer' => '{site_name} | Roue de la fortune',
        'sent' => 'Webhook envoyé !'
    ]
];
