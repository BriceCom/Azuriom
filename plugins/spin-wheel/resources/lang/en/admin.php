<?php

return [
    'plugin' => [
        'name' => 'Wheel of Fortune'
    ],
    'permission' => [
        'admin' => "View and manage the Wheel of Fortune plugin",
        'user' => 'Play wheel of fortune',
        'required' => "It is necessary to add the permission <code>Play the Wheel of Fortune</code> so that the groups concerned can play!",
        'denied' => "You do not have permission to play!"
    ],
    'pages' => [
        'settings' => [
            'title' => 'Settings',
            'general' => [
                'title' => 'General',
                'forms' => [
                    'price' => "Price of a spin",
                    'priceDesc' => "If no price is entered (or = 0), players will be able to play for free.",
                    'delay' => "Delay between two spins.",
                    'delayDesc' => "If no delay is entered (or = 0), players can play without restrictions.",
                    "displayPlayers" => "Number of latest players on the home page.",
                    "displayPlayersInfo" => 'If = 0, the "Latest Players" category will not appear.',
                    'tooglePercentage' => "Display percentage on the home page",
                    'ordering' => "Rank rewards by probability.",
                    'proportionalWheel' => "Wheel segments proportional to reward chances"
                ]
            ],
            'freeSpin' => [
                'title' => 'Free spin',
                'forms' => [
                    'toogleFreeSpin' => 'Activate a free spin',
                    'delay' => 'Delay between two free spins'
                ]
            ],
            'webhook' => [
                'title' => 'Webhook',
                'forms' => [
                    'url' => 'Discord webhook url',
                    'title' => 'Title',
                    'desc' => 'Description',
                    'footer' => 'Footer',
                    'toogleSkin' => 'Show Player Skin',
                    'toogleDate' => 'Show date in footer'
                ],
                'placeholders' => [
                    'title' => "You can use the following placeholders:",
                    'player' => '<code>{player}</code> : Player\'s nickname',
                    'reward' => '<code>{reward}</code> : Reward name',
                    'siteName' => '<code>{site_name}</code> : ' . site_name(),
                    'markdown' => 'You can also use the <a target="_blank" href="https://support.discord.com/hc/en-us/articles/210298617-Markdown-Text-101-Chat-Formatting-Bold-Italic-Underline-">Markdown</a> language.'
                ]
                ],
            'notifs' => [
                'updated' => 'Parameters updated successfully',
            ]
        ],
        'statistics' => [
            'title' => 'Statistics',
            'truncate' => [
                'title' => 'Empty statistics',
                'desc' => "This will delete all statistics from the database. This will not delete the rewards. Warning, this action is irreversible and will reset the free spins!",
                'button' => 'Empty statistics',
                'notifs' => [
                    'success' => 'Statistics emptied successfully'
                ]
            ],
            'cards' => [
                'rewards' => 'Active Rewards',
                'spins' => 'Wheel spins',
                'moneySpent' => 'Money spent',
                'moneyGiven' => 'Money given'
            ],
            'tables' => [
                'rewards' => [
                    'title' => 'Rewards',
                    'cols' => [
                        'reward' => "Reward",
                        'total' => 'Won x times',
                        'winRate' => 'Win rate'
                    ]
                ],
                'players' => [
                    'title' => 'Last players',
                    'cols' => [
                        'player' => 'Player',
                        'reward' => 'Rewards',
                        'price' => 'Pricd',
                        'date' => 'Date'
                    ],
                    'row' => [
                        'empty' => 'No player'
                    ]
                ]
            ]

        ],
        'rewards' => [
            'index' => [
                'title' => 'Rewards',
                'table' => [
                    'cols' => [
                        'name' => 'Name',
                        'chances' => 'Chances',
                        'enabled' => 'Enabled',
                        'actions' => 'Actions'
                    ],
                    'row' => [
                        'empty' => "No reward"
                    ]
                ],
            ],
            'create' => [
                'title' => 'Create a reward',
            ],
            'edit' => [
                'title' => 'Edit Reward'
            ],
            'form' => [
                'name' => 'Name',
                'color' => 'Color',
                'chances' => 'Chances',
                'money' => 'Money',
                'scratchCard' => 'Scratch card',
                'scratchCardDesc' => '',
                'scratchCardNone' => 'No scratch card',
                'servers' => 'Servers (ctrl + click to select several)',
                'commands' => 'Commands',
                'commandsDesc' => "You can use <code>{player}</code> to use the player name. The command must not contain <code>/</code> at the beginning.",
                'toogleWebhook' => 'Send a webhook',
                'toogleAzlink' => "Execute commands when the user is online on the server (only available with AzLink)",
                'toogleEnable' => "Activate reward",
                'fontSize' => "Text size",
                'orientation' => 'Text orientation',
                'direction' => 'Text Direction',
                'horizontal' => 'Horizontal',
                'vertical' => 'Vertical',
                'curved' => 'Curved',
                'normal' => 'Normal',
                'reversed' => 'Reversed'
            ],
            'notifs' => [
                'created' => 'Reward created successfully.',
                'updated' => 'Reward successfully updated',
                'deleted' => 'Reward successfully deleted'
            ]
        ]
    ],
    'errors' => [
        'api' => [
            'delay' => "You can play ",
            'money' => "You don't have enough " . money_name() . '.',
        ]
    ],
    "infos" => [
        'sold' => 'Your balance is : ',
        'updateMessage' => "<strong>Important! V2.0.0</strong> You need to edit all your rewards"
    ],
    "webhook" => [
        'title' => '>> Spin the wheel !',
        'description' => '``{player} won {reward}``',
        'footer' => '{site_name} | Wheel of Fortune',
        'sent' => 'Webhook sent !'
    ]
];
