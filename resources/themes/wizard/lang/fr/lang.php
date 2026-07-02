<?php

return [
    'image'             => 'Image',
    'title'             => 'Titre',
    'description'       => 'Description',
    'icon'              => 'Icon  exemple: <i class="fab fa-discord"></i>',
    'name'              => 'Nom',
    'animation'         => 'Animation',
    'easing'            => 'L\'assouplissement',
    'duration'          => 'Durée (ms)',
    'offset'            => 'Décalage',
    'placement'         => 'Placement',
    'fontawesome'       => 'Pour obtenir les icones veuillez utiliser les classes de',
    'styles'            => 'Styles',
    'plugin'            => [
        'requires' => 'Nécessite ce plugin'
    ],
    'menus'             => [
        'articles'       => [
            'index' => 'Les articles',
            'show'  => 'L\'article',
        ],
        'forum'          => [
            'index'                  => 'Forum',
            'forum_breadcrumb'       => 'Breadcrumb',
            'forum_message'          => 'Message',
            'forum_stati'            => 'Statistique',
            'show'                   => 'Le forum',
            'profile_edit'           => 'Modifier l\'utilisateur',
            'profile_show'           => 'L\'utilisateur',
            'discussions_posts_edit' => 'Modifier post',
            'discussions_create'     => 'Creation discussions',
            'discussions_edit'       => 'Modification discussions',
            'discussions_show'       => 'La discussions',
        ],
        'flyff'          => [
            'flyff_accounts'       => 'Compte',
            'flyff_resetPassword'  => 'Modification mots de passe',
            'flyff_guilds'         => 'Guilds',
            'flyff_guildsShow'     => 'Guild',
            'flyff_guildSiege'     => 'Guild Siege',
            'flyff_guildSiegeShow' => 'Guild Siege Show',
            'flyff_characters'     => 'Personnages',
            'flyff_characterShow'  => 'Personnage',
        ],
        'identification' => [
            'passwordReset'   => 'Réinitialiser mot de passe (Reset)',
            'passwordEmail'   => 'Réinitialiser mot de passe (Email)',
            'passwordConfirm' => 'Réinitialiser mot de passe (Confirm)',
            'account'         => 'Mon profil',
            'accountF2a'      => 'Mon profil F2a',
            'error'           => 'Erreur',
            'maintenance'     => 'Maintenance',
        ],
        'jirai'          => [
            'index'             => 'Jirai',
            'jirai_suggestions' => 'Suggestions',
            'jirai_bugs'        => 'Bugs',
            'jirai_changelogs'  => 'Changelogs',
            'changelogs_create' => 'Crée changelog',
            'changelogs_edit'   => 'Modifier changelog',
            'changelogs_show'   => 'Le changelog',
            'issues_create'     => 'Crée (Bug/Suggestion)',
            'issues_edit'       => 'Modifier (Bug/Suggestion)',
            'issues_show'       => 'Le (Bug/Suggestion)',
            'messages_edit'     => 'Modifier message',
        ],
        'shop'           => [
            'index'            => 'Boutique',
            'shop_filter'      => 'Filter',
            'shop_profil'      => 'Profile',
            'cart'             => 'Panier',
            'shop_coupons'     => 'Coupons',
            'shop_add_coupons' => 'Ajouter Coupons',
            'offre_select'     => 'Selection offre',
            'offre_buy'        => 'Achat offre',
            'payments'         => 'Paiments',
            'my_achats'        => 'Mes achats',
        ],
        'support'        => [
            'index'  => 'Support',
            'show'   => 'Un ticket',
            'create' => 'Creation ticket',
        ],
        'wiki'           => [
            'index' => 'Wiki',
            'show'  => 'Le wiki',
        ]
    ],
    'footer'            => [
        'title'     => 'Pied de page',
        'social'    => [
            'title' => 'Réseau social',
            'info'  => '<span>Permet d\'ajouter vos réseaux sociaux.</span>'
        ],
        'condition' => [
            'title' => 'CGU,CGV,etc...',
            'info'  => '<span>Permet d\'ajouter vos liens de CGV, CGU, Mention légale.</span>
                        <span>Pensez juste à ajouter un lien de page que vous pouvez créer ici  <a href="/admin/pages" target="_blank" title="Page">page</a></span>
                        '
        ],
        'logo'      => [
            'title'  => 'Logo en pied de page',
        ],
        'liens'     => [
            'title'  => 'Liens utiles',
            'info'   => '<span>Permet d\'ajouter vos liens (Accueil, boutique, contact, discord) sans difficulté.</span>'
        ],
    ],
    'global'            => [
        'title' => 'Général',
    ],
    'header'            => [
        'title'     => 'Entête',
    ],
    'home'              => [
        'title' => 'Page d\'accueil',
    ],
    'page'              => [
        'title' => 'Pages',
    ],
    'shop'              => [
        'title'  => 'Plugin Shop',
    ],
    'vote'          => [
        'title'  => 'Plugin Vote',
    ],
    'wiki'          => [
        'title'  => 'Plugin Wiki',
    ],
    'launcher'          => [
        'title'  => 'Plugin Launcher',
    ],
];
